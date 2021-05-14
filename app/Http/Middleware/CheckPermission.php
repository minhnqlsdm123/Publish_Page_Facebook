<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        //B1: lấy ra danh sách roles (vai trò) của user đang đăng nhập
        $user = Auth::user();
        $roleOfUser = $user->roles->pluck('id')->toArray();
        //dd($roles);
        //B2: lấy ra danh sách permission(quyền) của user đang đăng nhập
        $permissionOfUser = DB::table('roles')
            ->join('roles_permissions', 'roles.id', '=', 'roles_permissions.role_id')
            ->join('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
            ->select('permissions.*')
            ->whereIn('roles.id', $roleOfUser)
            ->pluck('id')
            ->unique();
        //b3: lấy ra id của quyền đang truy nhập trên screen
        $idPermissionCheck = Permission::where('name', $permission)->value('id');
        if ($permissionOfUser->contains($idPermissionCheck)) {
            return $next($request);
        }
        return abort(401);
    }
}