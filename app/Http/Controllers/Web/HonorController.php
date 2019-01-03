<?php

namespace App\Http\Controllers\Web;

use App\Imports\HonorsImport;
use App\Models\Honor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class HonorController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        $query = Honor::where($where);
        if (!empty($request->user_name)) {
            $query = $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }
        if (!empty($request->year)) {
            $query = $query->where('year', 'like', '%' . $request->year . '%');
        }
        if (!empty($request->team)) {
            $query = $query->where('team', 'like', '%' . $request->team . '%');
        }
        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' . $request->name . '%');
        }
        $honors = $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return view('web.honor.index', compact('honors'));
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
            $arr      = Excel::toArray(new HonorsImport(), $file);
            $position = new Honor;
            foreach ($arr[0] as $row) {
                if (
                    empty($row['year']) ||
                    empty($row['user_name']) ||
                    empty($row['honor']) ||
                    empty($row['team'])
                ) {
                    continue;
                }
                $position::create([
                    'year'      => $row['year'] ?? '',
                    'name'      => $row['honor'] ?? '',
                    'team'      => $row['team'] ?? '',
                    'user_name' => $row['user_name'] ?? '',
                    'remark'    => $row['remark'] ?? ''
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
