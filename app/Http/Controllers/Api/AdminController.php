<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    // 返回用户列表
    public function index()
    {
        //3个用户为一页
        $admins = Admin::paginate(3);
        return AdminResource::collection($admins);
    }

    // 返回单一用户信息
    public function show(Admin $admin)
    {
        return $this->success(new AdminResource($admin));
    }

    // 用户注册
    public function store(AdminRequest $request)
    {
        Admin::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    // 用户登录
    public function login(Request $request)
    {
        $token = Auth::attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            return $this->setStatusCode(201)->success(['token' => 'bearer' . $token]);
        }
        return $this->failed('账号或密码错误', 400);
    }

    // 用户退出
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }

    // 返回当前登录用户信息
    public function info()
    {
        // 这里也是 user 方法
        $admin = Auth::user();
        return $this->success(new AdminResource($admin));
    }
}