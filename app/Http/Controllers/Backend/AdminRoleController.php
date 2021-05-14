<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestRole;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $roles = $this->role->orderBy('id', 'desc')->get();
        $data = [
            'roles' => $roles
        ];
        return view('backend.role.index', $data);
    }

    public function getAdd()
    {
        $permissions = $this->permission->all();
        $data = [
            'permissions' => $permissions
        ];
        return view('backend.role.add', $data);
    }

    public function postAdd(AdminRequestRole $request)
    {
        try {
            DB::beginTransaction();
            $role = $this->role->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);
            if ($permission = $request->permission)
            {
                $role->permissions()->attach($permission);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('admin.role.list');
    }

    public function getUpdate($id)
    {
        $permissions = $this->permission->all();
        $role = $this->role->find($id);
        $permissionOfRole = $role->permissions()->pluck('permission_id');
        $data = [
            'permissions' => $permissions,
            'role' => $role,
            'permissionOfRole' => $permissionOfRole
        ];
        return view('backend.role.update', $data);
    }

    public function postUpdate(AdminRequestRole $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->role->where('id', $id)->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);
            DB::table('roles_permissions')->where('role_id', $id)->delete();
            $role = $this->role->find($id);
            $role->permissions()->attach($request->permission);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('admin.role.list');
    }

    public function getDelete($id)
    {
        $role = $this->role->findOrFail($id);
        try {
            DB::beginTransaction();
            $role->permissions()->detach();
            $role->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('admin.role.list');

    }
}