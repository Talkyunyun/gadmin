<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Power;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class ManagerController extends BaseController {

    // 管理员列表
    public function getManager() {
        // 判断是否有权限
        if (!Power::has('manager')) {
            alert('你没有该操作权限', null);
        }

        $result = Admin::select([
            'id', 'username', 'email', 'phone', 'real_name', 'status', 'created_at', 'roles'
        ])->orderBy('created_at', 'desc')->paginate(20);
        foreach ($result as $key => $row) {
            if ($row->roles) {
                $roles = json_decode($row->roles, true);
                $roleData = Role::select(['name'])->whereIn('id', $roles)->get();
                $result[$key]->roles = $roleData;
            } else {
                $result[$key]->roles = [];
            }
        }

        return view($this->module . '.manager.list')
            ->with('result', $result);
    }

    // 添加管理员
    public function add(Request $request) {
        // 判断是否有权限
        if (!Power::has('add-manager')) {
            alert('你没有该操作权限', null);
        }

        if ($request->isMethod('POST')) {
            $data['username']   = $request->input('username', false);
            $data['real_name']  = $request->input('real_name', false);
            $data['phone']      = $request->input('phone', false);
            $data['email']      = $request->input('email', false);
            $data['password']   = $request->input('password', '');
            $data['notpassword']= $request->input('notpassword', '');
            $data['status']     = $request->input('status', 1);

            if (!preg_match_all(REG_RULE_NAME, $data['username'])) {
                alert('请输入合法的用户名', $_SERVER['HTTP_REFERER']);
            }
            if (!trim($data['real_name'])) {
                alert('请输入真实姓名', $_SERVER['HTTP_REFERER']);
            }
            if (!preg_match_all(REG_RULE_PASSWORD, $data['password'])) {
                alert('请输入六位以上的密码', $_SERVER['HTTP_REFERER']);
            }
            if ($data['password'] !== $data['notpassword']) {
                alert('两次密码输入不一样', $_SERVER['HTTP_REFERER']);
            }
            if ($data['phone'] && !preg_match_all(REG_RULE_PHONE, $data['phone'])) {
                alert('请输入正确的手机号码', $_SERVER['HTTP_REFERER']);
            }
            if ($data['email'] && !preg_match_all(REG_RULE_EMAIL, $data['email'])) {
                alert('请输入正确的邮箱格式', $_SERVER['HTTP_REFERER']);
            }
            $data['password'] = adminEncrypt($data['password']);
            if (Admin::create($data)) {
                alert('添加成功', null, 1, true);
            }

            alert('添加失败', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.manager.add');
    }

    // 修改管理员
    public function edit(Request $request) {
        // 判断是否有权限
        if (!Power::has('edit-manager')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        if (!$result = Admin::select(['id', 'username', 'real_name', 'phone', 'email', 'status'])->find($id)) {
            alert('不存在该用户', $_SERVER['HTTP_REFERER']);
        }

        if ($request->isMethod('POST')) {
            $data['real_name']  = $request->input('real_name', false);
            $data['phone']      = $request->input('phone', false);
            $data['email']      = $request->input('email', false);
            $data['status']     = $request->input('status', 1);

            if (!trim($data['real_name'])) {
                alert('请输入真实姓名', $_SERVER['HTTP_REFERER']);
            }
            if ($data['phone'] && !preg_match_all(REG_RULE_PHONE, $data['phone'])) {
                alert('请输入正确的手机号码', $_SERVER['HTTP_REFERER']);
            }
            if ($data['email'] && !preg_match_all(REG_RULE_EMAIL, $data['email'])) {
                alert('请输入正确的邮箱格式', $_SERVER['HTTP_REFERER']);
            }
            if (Admin::whereRaw('status<>9 AND id=?', [$id])->update($data)) {
                alert('修改成功', null, 1, true);
            }
            alert('修改失败', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.manager.edit')
            ->with('result', $result);
    }

    // 开启和关闭
    public function onOff(Request $request) {
        // 判断是否有权限
        if (!Power::has('manager-on-off')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        if (!$result = Admin::find($id)) {
            alert('不存在该用户', $_SERVER['HTTP_REFERER']);
        }
        if ($result->id == session('uid')) {
            alert('自己禁用该操作', $_SERVER['HTTP_REFERER']);
        }

        switch($result->status){
            case 0:
                $result->status = 1;
                $msg = '开启';
                break;
            case 1:
                $result->status = 0;
                $msg = '关闭';
                break;
            default:
                alert('该用户不允许操作', $_SERVER['HTTP_REFERER']);
        }
        if ($result->save()) {
            alert($msg . '成功!', $_SERVER['HTTP_REFERER'], 1);
        }

        alert($msg . '失败!', $_SERVER['HTTP_REFERER']);
    }

    // 修改密码
    public function updatePassword(Request $request) {
        // 判断是否有权限
        if (!Power::has('update-password-manager')) {
            alert('你没有该操作权限', null);
        }

        $uid = (int)$request->input('id', 0);
        if (empty($uid)) alert('不存在该用户', $_SERVER['HTTP_REFERER']);

        // 验证是否存在该用户
        $result = Admin::select(['id', 'username'])->whereRaw('id=?', $uid)->first();
        if (!$result) {
            alert('不存在该用户', $_SERVER['HTTP_REFERER']);
        }

        // 修改密码
        if ($request->isMethod('POST')) {
            $password    = adminEncrypt($request->input('password', ''));
            $notpassword = adminEncrypt($request->input('notpassword', ''));
            if ($password != $notpassword) {
                alert('两次密码输入不一样', $_SERVER['HTTP_REFERER']);
            }

            // 保存密码
            if (Admin::whereRaw('status<>9 AND id=?', [$uid])->update(['password'=>$password])) {
                alert('修改成功!', '', 1, true);
            }

            alert('修改失败!', $_SERVER['HTTP_REFERER']);
        }


        return view($this->module . '.manager.update_password')
            ->with('result', $result);
    }

    // 角色编辑
    public function role(Request $request) {
        // 判断是否有权限
        if (!Power::has('role-manager')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        $user = Admin::select(['id', 'username', 'roles'])->find($id);
        if (!$user) {
            alert('不存在该用户', $_SERVER['HTTP_REFERER']);
        }
        if ($request->isMethod('POST')) {
            $roles = (array)$request->input('roles', []);
            if (Admin::whereRaw('id=?', [$id])->update([
                'roles' => json_encode($roles)
            ])) {
                alert('操作成功', $_SERVER['HTTP_REFERER'], 1);
            }

            alert('操作失败', $_SERVER['HTTP_REFERER']);
        }

        // 获取角色列表
        $roles = Role::select(['id', 'name'])->whereRaw('status<>9')->get();
        if ($user->roles) {
            $user->roles = json_decode($user->roles, true);
        } else {
            $user->roles = [];
        }
        return view($this->module . '.manager.role')
            ->with('result', $user)
            ->with('roles', $roles);
    }
}