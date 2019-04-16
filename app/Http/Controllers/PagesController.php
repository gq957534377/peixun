<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Alarm;
use App\Models\Hardware;
use App\Models\School;
use App\Models\User;
use App\Providers\SendNews;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\BackWarehousing;
use App\Models\Collar;
use App\Models\Inventory;
use App\Models\News;
use App\Models\Purchase;
use App\Models\Scrap;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }

    public function emailVerifyNotice(Request $request)
    {
        return view('pages.email_verify_notice');
    }

    public function uploadImg(Request $request)
    {
        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('public/banners');
            return response()->json(['StatusCode' => 200, 'ResultData' => Storage::url($path)]);
        }
        return response()->json(['StatusCode' => 400, 'ResultData' => '请上传缩略图']);
    }

    public function maps()
    {
        switch (Auth::user()->role) {
            case User::Role_Admin:
            case User::Role_Educator:
                $schools = School::with('alarms')->get();
                break;
            case User::Role_School:
                $schools = Auth::user()->schools;
                break;
            default:
                $schools = collect([Auth::user()->school]);
                break;
        }

        return view('pages.map', ['schools' => $schools]);
    }

    public function mapsData()
    {
        switch (Auth::user()->role) {
            case User::Role_Admin:
            case User::Role_Educator:
                $schools = School::get();
                break;
            case User::Role_School:
                $schools = Auth::user()->schools;
                break;
            default:
                $schools = collect([Auth::user()->school]);
                break;
        }
        return response()->json(['StatusCode' => 200, 'ResultData' => $schools]);
    }

    public function schoolAlarms(School $school)
    {
        return response()->json(['StatusCode' => 200, 'ResultData' => $school->alarms->where('status',2)->sortBy('created_at')->take(10)]);
    }

    public function alarmMessage(PageRequest $request)
    {
        if ($request->event_num == '1130') {
            $event = config('alarm.alarm.' . $request->sector);
            $event['event'] = $event['event'] . '';
        } else {
            return response()->json(['StatusCode' => 400, 'ResultData' => '事件无需记录']);
//
//            $event = config('alarm.receive.' . $request->type . '.' . $request->event_num);
//            if (empty($event)) {
//                return response()->json(['StatusCode' => 400, 'ResultData' => '事件不存在或解析失败']);
//            }
        }
        $hardware = Hardware::where([
            'type' => Hardware::Type_Monitor,
            'ip' => $request->ip
        ])->first();
        if (empty($hardware))
            return response()->json(['StatusCode' => 404, 'ResultData' => '该报警设备未加入到硬件信息系统中']);

        $laboratory = $hardware->laboratory;
        if (empty($laboratory)) {
            return response()->json(['StatusCode' => 400, 'ResultData' => '未查询到该报警设备所在仓库！']);
        }

        // 报警信息存数据库
        Alarm::create([
            'school_id' => $laboratory->school_id,
            'laboratory_id' => $laboratory->id,
            'hardware_id' => $hardware->id,
            'type' => $event['type'],
            'event' => $event['event'] . '【' . $request->sector . '防区】',
            'client_id' => $request->client_id,
            'ip' => $request->ip,
            'event_num' => $request->event_num,
            'hex_data' => $request->hex_data,
            'serial_number' => $request->serial_number,
            'check_sum' => $request->check_sum,
            'alarm_time' => new Carbon(),
            'sector' => $request->sector
        ]);

        // 消息
        $content = sprintf(
            '%s 的 %s 仓库' . Carbon::now()->toDateTimeString() . '发生 %s 事件，请及时处理！(负责人：%s【%s】,安全负责人：%s【%s】)',
            $laboratory->school_name ?? '',
            $laboratory->name,
            $event['event'],
            $laboratory->admin_user_name,
            empty($laboratory->admin) ? '' : $laboratory->admin->tel,
            $laboratory->security->name ?? '',
            empty($laboratory->security) ? '' : $laboratory->security->tel
        );

//        // 仓库负责人发
//        if (!empty($laboratory->admin_user_id)) {
//            $ids[]=$laboratory->admin_user_id;
//        }
//
//        // 给仓库安全负责人发
//        if (!empty($laboratory->security_user_id)) {
//            $ids[]=$laboratory->security_user_id;
//        }
        // 给学校所有人发
        $ids = User::where('school_id', $laboratory->school_id)
            ->pluck('id')
            ->toArray();

        // 给仓库校园负责人发
        if (!empty($laboratory->school)) {
            if (!empty($laboratory->school->security_user_id)) {
                $ids[] = $laboratory->school->security_user_id;
            }
        }

        // 给admin+教委发
        if (!empty($laboratory->security_user_id)) {
            foreach (User::whereIn('role', [User::Role_Admin, User::Role_Educator])->get() as $admin) {
                event(new SendNews($admin->id, $event['event'] . "-" . $event['type'], $content));
            }
        }

        // 给指定邮箱发
        if (!empty(User::where('email', '2219735020@qq.com')->first())) {
            $ids[] = User::where('email', '')->first()->id;
        }

        foreach (collect($ids)->unique() as $id) {
            event(new SendNews($id, $event['event'] . "-" . $event['type'], $content));
        }
        return response()->json(['StatusCode' => 200, 'ResultData' => '报警成功！']);
    }

    public function monitor()
    {
        switch (Auth::user()->role) {
            case User::Role_Admin:
            case User::Role_Educator:
                $hardwares = Hardware::with('school')
                    ->with('laboratory')
                    ->where('type', Hardware::Type_Camera)
                    ->get();
                break;
            default:
                $hardwares = Hardware::with('school')
                    ->with('laboratory')
                    ->where('type', Hardware::Type_Camera)
                    ->whereIn('laboratory_id', Auth::user()->able_laboratories->pluck('id')->toArray())
                    ->get();
                break;
        }

        return view('web.monitor', ['hardwares' => $hardwares]);
    }

    public function nvr()
    {
        return view('web.nvr', ['monitor_url' => config('view.monitor_url')]);
    }
}
