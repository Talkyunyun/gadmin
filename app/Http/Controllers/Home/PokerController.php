<?php

namespace App\Http\Controllers\Home;

use DB;

class PokerController extends BaseController {

    // poker显示
    public function getIndex() {
        // 获取达人数据
        $master = DB::select('SELECT c.id,c.username,c.cover,c.identity FROM pai_clients c, pai_client_roles r WHERE r.id=c.role AND r.id=1 AND r.status=1 AND c.status=1 LIMIT 4');
        foreach ($master as $key=>$row) {
            if (mb_strlen($row->username, 'utf-8') > 4) {
                $master[$key]->username = mb_substr($row->username, 0, 4, 'utf-8').'...';
            }
            if (mb_strlen($row->identity, 'utf-8') > 5) {
                $master[$key]->identity = mb_substr($row->identity, 0, 5, 'utf-8').'...';
            }
            if (!empty($row->cover)) {
                $master[$key]->cover = json_decode($row->cover, true);
                $master[$key]->cover_url = 'http://tubes.gutplus.com/'.$master[$key]->cover['name'].'@1e_0o_1l_60h_60w_100q.src?v=5944';
            } else {
                $master[$key]->cover_url = '';
            }
        }

        return view('poker.index')
            ->with('master', $master);
    }
}