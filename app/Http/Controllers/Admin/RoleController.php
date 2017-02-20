<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Power;
use App\Models\Role;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController {

    // 角色列表
    public function getRole() {
        // 判断是否有权限
        if (!Power::has('role')) {
            alert('你没有该操作权限', null);
        }

        $result = Role::whereRaw('status<>9', [])->orderBy('created_at', 'desc')->paginate(10);

        return view($this->module . '.role.list')
            ->with('result', $result);
    }

    // 权限操作
    public function roleAccess(Request $request) {
        // 判断是否有权限
        if (!Power::has('role-access')) {
            alert('你没有该操作权限', null);
        }

        $roleId = (int)$request->input('id', 0);
        if ($request->isMethod('POST')) {
            $ids = $request->input('ids', false);
            if (empty($ids)) {
                alert('修改成功', $_SERVER['HTTP_REFERER'], 1);
            }

            $data = [];
            foreach ($ids as $key=>$row) {
                $data[$key]['role_id'] = $roleId;
                $data[$key]['node_id'] = $row;
            }
            // 1.开启事物
            DB::beginTransaction();
            DB::table('access')->whereRaw('role_id=?', [$roleId])->delete();
            $inl = DB::table('access')->insert($data);
            if ($inl) {
                DB::commit();
                alert('修改成功!', $_SERVER['HTTP_REFERER'], 1);
            }

            DB::rollback();
            alert('修改失败!', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.role.access')
            ->with('node', $this->_getNodeData())
            ->with('role_id', $roleId)
            ->with('access', Role::getAccess($roleId));
    }

    // 添加
    public function add(Request $request) {
        // 判断是否有权限
        if (!Power::has('add-role')) {
            alert('你没有该操作权限', null);
        }

        if ($request->isMethod('POST')) {
            $data['name']  = $request->input('name', false);
            $data['remark']= $request->input('remark', '');
            $data['status']= (int)$request->input('status', 1);

            if (!trim($data['name'])) {
                alert('请输入名称', $_SERVER['HTTP_REFERER']);
            }
            if (Role::create($data)) {
                alert('添加成功', null, 1, true);
            }

            alert('添加失败', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.role.add');
    }

    // 修改
    public function edit(Request $request) {
        // 判断是否有权限
        if (!Power::has('edit-role')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        if (!$result = Role::select(['id', 'name', 'remark', 'status'])->find($id)) {
            alert('该角色不存在', $_SERVER['HTTP_REFERER']);
        }

        if ($request->isMethod('POST')) {
            $data['name']  = $request->input('name', false);
            $data['remark']= $request->input('remark', '');
            $data['status']= (int)$request->input('status', 1);

            if (!trim($data['name'])) {
                alert('请输入名称', $_SERVER['HTTP_REFERER']);
            }
            if (Role::whereRaw('id=? AND status<>9', [$id])->update($data)) {
                alert('修改成功', null, 1, true);
            }

            alert('修改失败', $_SERVER['HTTP_REFERER']);

        }

        return view($this->module . '.role.edit')
            ->with('result', $result);
    }


    // 开启和关闭
    public function onOff(Request $request) {
        // 判断是否有权限
        if (!Power::has('role-on-off')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        if (!$result = Role::find($id)) {
            alert('不存在该角色', $_SERVER['HTTP_REFERER']);
        }
        if ($result->id == 1) {
            alert('该角色不允许操作', $_SERVER['HTTP_REFERER']);
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
                alert('该角色不允许操作', $_SERVER['HTTP_REFERER']);
        }
        if ($result->save()) {
            alert($msg . '成功!', $_SERVER['HTTP_REFERER'], 1);
        }

        alert($msg . '失败!', $_SERVER['HTTP_REFERER']);
    }


    // 获取节点列表
    private function _getNodeData() {
        $result   = [];
        $topLevel = Node::select(['id', 'name', 'remark'])->orderBy('created_at', 'desc')->whereRaw('pid=0', [])->get();
        foreach ($topLevel as $row) {
            $sonLevel = Node::select(['id', 'name', 'remark'])->orderBy('created_at', 'desc')->whereRaw('pid=?', [$row->id])->get()->toArray();
            $result[$row->id] = [
                'son' => $sonLevel,
                'id'  => $row->id,
                'name'=> $row->name
            ];
        }

        return $result;
    }
}