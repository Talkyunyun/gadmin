<?php
/**
 *  gadmin系统权限判断
 *  @author: Gene
 */
namespace App\Services;

use DB;

class Power {
    private $sessionKey = 'powers';// 权限列表key
    private $powerList = [];// 权限列表

    public function __construct() {
        // 判断缓存中是否有权限列表
        if ($powers = session($this->sessionKey)) {
            $this->powerList = $powers;
        } else {
            $this->_getNodes();
        }
    }

    /**
     * 判断是否有权限
     * @param string $name
     * @return bool
     */
    public function has($name = '') {
        if (!is_array($this->powerList)) {
            return false;
        }

        if (in_array($name, $this->powerList)) {
            return true;
        }

        return false;
    }


    /**
     * 获取用户权限列表
     * @return array|mixed
     */
    public function getPowers() {

       return $this->powerList;
    }


    /**
     *  获取角色权限
     */
    private function _getNodes() {
        if ($roles = session('roles')) {
            $roles = json_decode($roles, true);
            if (is_array($roles)) {
                $nodes = [];
                foreach ($roles as $row) {
                    // 获取节点列表
                    $nodes[] = DB::table('access')->select(['node_id'])->where('role_id', $row)->get();
                }
                $nodeIds = [];
                foreach ($nodes as $row) {
                    foreach ($row as $r) {
                        array_push($nodeIds, $r->node_id);
                    }
                }
                if (is_array($nodeIds)) {
                    $nodeIds = array_unique($nodeIds);
                    $nodes = DB::table('node')->select(['url'])->whereRaw('status=1 AND url<>""', [])->whereIn('id', $nodeIds)->get();
                    foreach ($nodes as $row) {
                        array_push($this->powerList, $row->url);
                    }
                    $this->powerList = array_unique($this->powerList);

                    session([
                        $this->sessionKey => $this->powerList
                    ]);
                }
            }
        }
    }
}