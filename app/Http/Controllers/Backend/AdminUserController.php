<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use App\Http\Requests\AdminRequestUser;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    private $user;
    private $role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
    public function index()
    {
        $users = $this->user->orderBy('id', 'desc')->get();
        $data = [
            'users' => $users
        ];
        return view('backend.user.index', $data);
    }

    public function getAdd()
    {
        $roles = $this->role->get();
        $data = [
            'roles' => $roles
        ];
        return view('backend.user.add', $data);
    }

    public function postAdd(AdminRequestUser $request)
    {
        try {
            DB::beginTransaction();
            $id = $this->user->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now()
            ]);
            if ($id) {
                foreach ($request->role as $role) {
                    DB::table('roles_users')->insert([
                        'user_id' => $id,
                        'role_id' => $role
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('admin.user.list');
    }

    public function getUpdate($id)
    {
        $user = $this->user->findOrFail($id);
        $roles = $this->role->all();
        $roleOfUser = $user->roles()->get()->pluck('id');
        $data = [
            'user' => $user,
            'roles' => $roles,
            'roleOfUser' => $roleOfUser
        ];
        return view('backend.user.update', $data);
    }

    public function postUpdate(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:3|max:20',
                'email' => 'required|email|unique:users,email,' . $id,
            ],
            [
                'name.required' => 'Tên đăng nhập không được trống',
                'name.min' => 'Tên đăng nhập có độ dài từ 3 đến 20 kí tự',
                'name.max' => 'Tên đăng nhập có độ dài từ 3 đến 20 kí tự',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại trên hệ thống',
                'email.email' => 'Email chưa đúng định dạng',
            ]
        );
        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->created_at = Carbon::now();
        //Nếu có thay đổi mật khẩu
        if ($request->change_password) {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:6|max:20',
                    'confirm_password' => 'required|same:password'
                ],
                [
                    'password.required' => 'Mật khẩu không được trống',
                    'password.min' => 'Mật khẩu có độ dài từ 6 đến 20 kí tự',
                    'password.max' => 'Mật khẩu có độ dài từ 6 đến 20 kí tự',
                    'confirm_password.required' => 'Mật khẩu không được trống',
                    'confirm_password.same' => 'Mật khẩu nhập lại chưa khớp',
                ]
            );

            $user->password = Hash::make($request->password);
        }
        $user->save();
        //Lưu bảng roles_users
        DB::table('roles_users')->where('user_id', $id)->delete();
        if ($roles = $request->role) {
            foreach ($roles as $role) {
                DB::table('roles_users')->insert([
                    'user_id' => $id,
                    'role_id' => $role
                ]);
            }
        }
        return redirect()->route('admin.user.list');
    }

    public function getDelete($id)
    {
        $user = $this->user->findOrFail($id);
        try {
            DB::beginTransaction();
            $user->roles()->detach();
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('admin.user.list');
    }
}
