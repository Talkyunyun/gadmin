<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Power;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NodeController extends BaseController {

    // 节点列表
    public function getNode() {
        // 判断是否有权限
        if (!Power::has('node')) {
            alert('你没有该操作权限', null);
        }

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

        return view($this->module . '.node.list')
            ->with('result', $result);
    }

    // 添加
    public function add(Request $request) {
        // 判断是否有权限
        if (!Power::has('add-node')) {
            alert('你没有该操作权限', null);
        }

        if ($request->isMethod('POST')) {
            $data['url']   = strtolower($request->input('url', false));
            $data['name']  = $request->input('name', false);
            $data['remark']= $request->input('remark', '');
            $data['pid']   = (int)$request->input('pid', 0);
            $data['status']= (int)$request->input('status', 1);

            if (!empty($data['pid']) && !trim($data['url'])) {
                alert('请输入访问地址', $_SERVER['HTTP_REFERER']);
            }
            if (!trim($data['name'])) {
                alert('请输入名称', $_SERVER['HTTP_REFERER']);
            }
            if (Node::create($data)) {
                alert('添加成功', null, 1, true);
            }

            alert('添加失败', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.node.add')
            ->with('node', $this->_getTopLevelNode());
    }

    // 修改
    public function edit(Request $request) {
        // 判断是否有权限
        if (!Power::has('edit-node')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        if (!$result = Node::select(['id', 'name', 'url', 'pid', 'status', 'remark'])->find($id)) {
            alert('不存在该节点', $_SERVER['HTTP_REFERER']);
        }

        if ($request->isMethod('POST')) {
            $data['url']   = strtolower($request->input('url', false));
            $data['name']  = $request->input('name', false);
            $data['remark']= $request->input('remark', '');
            $data['pid']   = (int)$request->input('pid', 0);
            $data['status']= (int)$request->input('status', 1);

            if (!empty($data['pid']) && !trim($data['url'])) {
                alert('请输入访问地址', $_SERVER['HTTP_REFERER']);
            }
            if (!trim($data['name'])) {
                alert('请输入名称', $_SERVER['HTTP_REFERER']);
            }
            if (Node::whereRaw('id=? AND status<>9', [$id])->update($data)) {
                alert('修改成功', null, 1, true);
            }

            alert('修改失败', $_SERVER['HTTP_REFERER']);
        }

        return view($this->module . '.node.edit')
            ->with('result', $result)
            ->with('node', $this->_getTopLevelNode());
    }

    // 删除
    public function delNode(Request $request) {
        // 判断是否有权限
        if (!Power::has('del-node')) {
            alert('你没有该操作权限', null);
        }

        $id = (int)$request->input('id', 0);
        $node = Node::select(['id', 'pid'])->find($id);
        if (!$node) {
            alert('不存在该节点信息', $_SERVER['HTTP_REFERER']);
        }

        DB::beginTransaction();
        if ($node->pid == 0) {// 顶级节点
            $sonNode = Node::getSonNode($id, ['id'], true);
            if (!empty($sonNode)) {
                DB::table('access')->whereIn('node_id', $sonNode)->delete();
                $delSonNode   = DB::table('node')->whereIn('id', $sonNode)->delete();

                // 删除权限数据
                DB::table('access')->where('node_id', $node->id)->delete();
                $delNode   = DB::table('node')->where('id', $node->id)->delete();
                if ($delNode && $delSonNode) {
                    DB::commit();
                    alert('删除成功', $_SERVER['HTTP_REFERER'], 1);
                }

                DB::rollback();
                alert('删除失败', $_SERVER['HTTP_REFERER']);
            }
        }

        // 删除权限数据
        DB::table('access')->where('node_id', $node->id)->delete();
        $delNode   = DB::table('node')->where('id', $node->id)->delete();

        if ($delNode) {
            DB::commit();
            alert('删除成功', $_SERVER['HTTP_REFERER'], 1);
        }

        DB::rollback();
        alert('删除失败', $_SERVER['HTTP_REFERER']);
    }

    /**
     * 获取所有顶级节点
     * @param array $fields
     * @return array
     */
    private function _getTopLevelNode($fields = ['id', 'name']) {
        if (!is_array($fields) || empty($fields)) {
            return [];
        }

        $result = Node::select($fields)->whereRaw('pid=0 AND status=1', [])->get();
        if ($result->isEmpty()) {
            return [];
        }

        return $result;
    }
}