<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model {

    protected $table = 'node';

    // 设置批量赋值字段
    protected $fillable = ['url', 'name', 'remark', 'status', 'pid', 'created_at', 'updated_at'];

    // 定义status字段取值范围
    public static $statusFieldVal = [0, 1];


    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($time) {
        return $time;
    }

    // 获取子节点
    public static function getSonNode($id = 0, $fields = ['id'], $isId = false) {
        $id = (int)$id;
        if (!is_array($fields) || empty($fields)) {
            return [];
        }
        $data = [];
        $node = self::select($fields)->where('pid', $id)->get();
        if ($node->isEmpty()) {
            return [];
        }

        foreach ($node as $key=>$row) {
            if ($isId) {
                array_push($data, $row->id);
                continue;
            }

            foreach ($fields as $r) {
                $data[$key][$r] = $row->$r;
            }
        }

        return $data;
    }
}