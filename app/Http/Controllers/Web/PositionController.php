<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\PositionsImprot;
use App\Models\Position;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        $query = Position::where($where);
        if (!empty($request->user_name)) {
            $query = $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }
        if (!empty($request->year)) {
            $query = $query->where('year', 'like', '%' . $request->year . '%');
        }
        if (!empty($request->team)) {
            $query = $query->where('team', 'like', '%' . $request->team . '%');
        }
        if (!empty($request->position)) {
            $query = $query->where('position', 'like', '%' . $request->position . '%');
        }
        if (!empty($request->type)) {
            $query = $query->where('type', 'like', '%' . $request->type . '%');
        }
        $positions = $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return view('web.position.index', compact('positions'));
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
            $arr      = Excel::toArray(new PositionsImprot(), $file);
            $position = new Position;
            foreach ($arr[0] as $row) {
                if (
                    empty($row['year']) ||
                    empty($row['type']) ||
                    empty($row['position']) ||
                    empty($row['team']) ||
                    empty($row['user_name'])
                ) {
                    continue;
                }
                $position::create([
                    'year'      => $row['year'] ?? '',
                    'type'      => $row['type'] ?? '',
                    'position'  => $row['position'] ?? '',
                    'team'      => $row['team'] ?? '',
                    'user_name' => $row['user_name'] ?? '',
                    'tel'       => (int)$row['tel'] ?? '',
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
