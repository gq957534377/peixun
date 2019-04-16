<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\UserRequest;
use App\Models\School;
use App\Models\User;
use Clockwork\Storage\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 说明: 人员管理列表页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $where = [];
        if (!empty($request->role)) {
            $where['role'] = $request->role;
        }
        if (!empty($request->school_id)) {
            $where['school_id'] = $request->school_id;
        }
        $query = User::where($where);

        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' . $request->name . '%');
        }

        if (Auth::user()->role == User::Role_Admin) {
            $schools = School::get();
            $roles = [
                [User::Role_Educator, User::roleName(User::Role_Educator)],
                [User::Role_School, User::roleName(User::Role_School)],
                [User::Role_Security, User::roleName(User::Role_Security)],
                [User::Role_Laboratory, User::roleName(User::Role_Laboratory)],
                [User::Role_Teacher, User::roleName(User::Role_Teacher)],
            ];
            $query = $query->where('role', '!=', User::Role_Admin);
            if (!empty($request->school_id)) {
                unset($where['school_id']);
                $query = $query->orWhere('id', School::find($request->school_id)->security_user_id)->where($where);
            }
        } elseif (Auth::user()->role == User::Role_Educator) {
            $schools = School::get();
            $roles = [
                [User::Role_School, User::roleName(User::Role_School)],
                [User::Role_Security, User::roleName(User::Role_Security)],
                [User::Role_Laboratory, User::roleName(User::Role_Laboratory)],
                [User::Role_Teacher, User::roleName(User::Role_Teacher)]
            ];
            $query = $query->where('role', '!=', User::Role_Admin)
                ->where('role', '!=', User::Role_Educator);
            if (!empty($request->school_id)) {
                unset($where['school_id']);
                $query = $query->orWhere('id', School::find($request->school_id)->security_user_id)->where($where);
            }
        } elseif (Auth::user()->role == User::Role_School) {
            $roles = [
                [User::Role_Security, User::roleName(User::Role_Security)],
                [User::Role_Laboratory, User::roleName(User::Role_Laboratory)],
                [User::Role_Teacher, User::roleName(User::Role_Teacher)]
            ];
            $schools = School::where(['security_user_id' => Auth::user()->id])->get();
            $query = $query->whereIn('role', [
                User::Role_Security,
                User::Role_Laboratory,
                User::Role_Teacher
            ]);

            if (empty($request->school_id)){
                $schoolIds = $schools->pluck('id')->toArray();
                $schoolUserIds = $schools->pluck('security_user_id')->unique()->toArray();
                $query = $query->whereIn('school_id', $schoolIds)
                    ->orWhereIn('id', $schoolUserIds);
            }else{
                unset($where['school_id']);
                $query = $query->orWhere('id', School::find($request->school_id)->security_user_id)->where($where);
            }
        } else {
            $roles = [
                [User::Role_Security, User::roleName(User::Role_Security)],
                [User::Role_Laboratory, User::roleName(User::Role_Laboratory)],
                [User::Role_Teacher, User::roleName(User::Role_Teacher)]
            ];
            $schools = collect([School::find(Auth::user()->school_id)]);
            if (empty($request->role)){
                $query = $query->whereIn('role', [
                    User::Role_School,
                    User::Role_Security,
                    User::Role_Laboratory,
                    User::Role_Teacher
                ]);
            }

            if (empty($request->school_id)){
                $where['school_id']=Auth::user()->school_id;
            }
            $query = $query->where($where);

            if (empty($where['role'])){
                $query = $query->orWhere('id',School::find($where['school_id'])->security_user_id);
            }
        }

        $users = $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return view('web.user.index', compact('users', 'schools', 'roles'));
    }

    /**
     * 说明: 创建人员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function create()
    {
        return view('web.user.create');
    }

    /**
     * 说明: 添加人员
     *
     * @param UserRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function store(UserRequest $request)
    {
        if ($request->hasFile('head_img')) {
            $request->head_img = Storage::url($request->file('head_img')->store('public/users'));
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tel' => $request->tel ?? null,
            'head_img' => $request->head_img ?? null,
            'role' => $request->role ?? null,
            'school_id' => $request->school_id ?? null,
            'email_verified' => true,
        ]);
        return redirect()->route('users.index')->withErrors('添加人员成功', 'success');
    }

    /**
     * 说明: 修改视图
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function edit(User $user)
    {
        return view('web.user.edit', ['user' => $user]);
    }

    /**
     * 说明: 修改人员
     *
     * @param User $user
     * @param UserRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function update(User $user, UserRequest $request)
    {
        if ($request->hasFile('head_img')) {
            $request->head_img = Storage::url($request->file('head_img')->store('public/users'));
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tel' => $request->tel ?? '',
            'head_img' => $request->head_img ?? '',
            'role' => $request->role ?? null,
            'school_id' => $request->school_id ?? null,
            'email_verified' => true,
        ];
        $data = collect($data)->only($request->keys())->toArray();
        User::where(['id' => $user->id])->update($data);

        return redirect()->route('users.index')->withErrors('修改人员成功', 'success');
    }

    /**
     * 说明: 删除人员
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @author 郭庆
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['StatusCode' => 200, 'ResultData' => '删除人员成功']);
    }

    /**
     * 说明: 重置密码
     *
     * @param User $user
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function resetPwd(User $user, UserRequest $request)
    {
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['StatusCode' => 200, 'ResultData' => '修改密码成功']);
    }
}
