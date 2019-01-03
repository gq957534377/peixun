<?php

namespace App\Http\Controllers\Web;

use App\Imports\TrainsImport;
use App\Models\Train;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        $query = Train::where($where);
        if (!empty($request->student)) {
            $query = $query->where('student', 'like', '%' . $request->student . '%');
        }
        if (!empty($request->year)) {
            $query = $query->where('year', 'like', '%' . $request->year . '%');
        }
        if (!empty($request->team)) {
            $query = $query->where('team', 'like', '%' . $request->team . '%');
        }
        if (!empty($request->case)) {
            $query = $query->where('case', 'like', '%' . $request->case . '%');
        }
        $trains = $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return view('web.trains.index', compact('trains'));
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'code'    => 400,
                'message' => '请上传excel文件！'
            ]);
        }
        $file = $request->file;
        if (!in_array($entension = $file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            return response()->json([
                'code'    => 400,
                'message' => '请上传正确的文件,文件格式不合法' . $request->file->getMimeType()
            ]);
        }
        try {
            $arr   = Excel::toArray(new TrainsImport(), $file);
            $train = new Train;
            foreach ($arr[0] as $row) {
                if (
                    empty($row['year'])      ||
                    empty($row['course'])    ||
                    empty($row['team'])      ||
                    empty($row['user_name'])
                ) {
                    continue;
                }
                $train::create([
                    'year'        => $row['year'] ?? '',
                    'case'        => $row['course'] ?? '',
                    'team'        => $row['team'] ?? '',
                    'student'     => $row['user_name'] ?? '',
                    'student_tel' => $row['tel'] ?? '',
                    'remark'      => $row['remark'] ?? ''
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'code'    => 400,
                'message' => '导入数据失败,'.$exception->getMessage()
            ]);
        }


        return response()->json([
            'code'    => 200,
            'message' => '导入数据成功'
        ]);
    }
}
