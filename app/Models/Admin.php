<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

    protected $table = 'Admin';

    // 设置批量赋值字段
    protected $fillable = ['roles', 'username', 'password', 'phone', 'email', 'real_name', 'status', 'created_at', 'updated_at'];

    // 定义status字段取值范围
    public static $statusFieldVal = [0, 1];


    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($time) {
        return $time;
    }

    // 获取用户角色信息
    public static function getManagerRoles($id = 0) {

    }
}