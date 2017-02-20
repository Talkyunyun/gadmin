<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model {

    protected $table = 'role';

    // 设置批量赋值字段
    protected $fillable = ['name', 'remark', 'status', 'created_at', 'updated_at'];

    // 定义status字段取值范围
    public static $statusFieldVal = [0, 1];

    // 获取角色权限列表
    public static function getAccess($roleId = 0) {
        $data = [];
        $roleId = (int)$roleId;
        $access = DB::table('access')->select(['node_id'])->whereRaw('role_id=?', [$roleId])->get();
        foreach ($access as $row) {
            array_push($data, $row->node_id);
        }

        return $data;
    }


    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($time) {
        return $time;
    }
}