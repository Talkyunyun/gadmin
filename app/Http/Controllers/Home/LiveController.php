<?php

namespace App\Http\Controllers\Home;

use App\Models\Client;
use App\Models\Live;
use Illuminate\Http\Request;
use DB;


class LiveController extends BaseController {

    // 分享直播
    public function getLive(Request $request) {
        $liveId = intval($request->input('live_id', 0));
        if (empty($liveId)) return msg();

        // 获取该直播信息
        $live = DB::select('SELECT u.username,u.avatar,u.role,l.* FROM pai_clients u,pai_lives l WHERE u.id=l.uid AND u.status=1 AND l.status>0 AND l.id=?', [$liveId]);
        $msg  = trans('msg.live_closed');
        dd($live);
        if (empty($live)) {
            return msg($msg);
        }
        $live = $live[0];
        // 处理头像和封面
        if ($live->cover) {
            $cover = json_decode($live->cover, true);
            $live->cover = 'http://tubes.gutplus.com/'.$cover['name'];
        }
        // 处理图片
        if ($live->photo) {
            $live->photo = json_decode($live->photo);
        }

        if ($live->status == 2) {
            return msg($msg, $live);
        }

        dd($live);
        // 判断直播状态
        switch ($live->period) {
            case 1:// 正在直播
            case 2:// 主播离线
                return view('live.player')
                    ->with('live', $live);
                break;
            case 3:// 直播结束
                return msg(trans('msg.live_closed'), $live);
                break;
            default:// 预告显示
                // 获取评论总数
                $count = DB::select('SELECT count(c.id) count FROM pai_clients u, pai_live_comments c WHERE u.id=c.uid AND u.status=1 AND c.status=1 AND c.live_id=?', [
                    $liveId
                ]);
                $live->comments = $count[0]->count;
                return view('live.index')
                    ->with('live', $live);
                break;
        }
    }


    // 获取预告直播列表
    public function getTrailer(Request $request) {
        $lastDate = $request->input('lastDate', date('Y-m-d'));
        $lastTime = $request->input('lastTime', date('H:i:s'));
        $lastId   = $request->input('lastId', 0);

        // 获取预告直播列表
        $trailer = Live::take(10)
            ->select(['id', 'title', 'cover', 'start_date', 'start_at', 'end_at', 'uid'])
            ->whereRaw('type=2 AND status=1 AND period=0 AND unix_timestamp(start_date)>=unix_timestamp(?)', [$lastDate])
            ->orderBy('start_date', 'asc')
            ->orderBy('start_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();
//        dd($trailer);
        if (empty($trailer)) {
            return response()->json(['code'=>0, 'msg'=>'没有预告信息了']);
        }

        $weeks = ['日', '一', '二', '三', '四', '五', '六'];
        $i     = 0;
        $data  = [];
        foreach ($trailer as $key=>$row) {
            // 排除当前时间以前的数据
            if ($row->start_date == $lastDate) {
                if ($row->id <= $lastId) {
                    continue;
                }
                if (strtotime($row->start_at) < strtotime($lastTime)) {
                    continue;
                }
            }
            // 获取用户信息
            $user = Client::select(['username', 'avatar', 'role'])
                ->whereRaw('status=1 AND id=?', [$row->uid])
                ->first();
            if (empty($user)) continue;

            $data[$i] = $row;
            $cover = json_decode($row->cover, true);
            $data[$i]['cover_url'] = 'http://tubes.gutplus.com/'.$cover['name'];

            $data[$i]['username']  = $user->username;
            $data[$i]['avatar'] = 'http://tubes.gutplus.com/'.$user->avatar.'@1e_0o_1l_80h_80w_100q.src?v=5944';
            $data[$i]['role']   = $user->role;
            $data[$i]['week']   = '星期'.$weeks[date('w', strtotime($row->start_date))];
            if (mb_strlen($row->title, 'utf-8') > 14) {
                $data[$i]['title'] = mb_substr($row->title, 0, 14, 'utf-8').'...';
            }
            $i++;
        }

        return response()->json(['code'=>1, 'msg'=>'获取成功', 'result'=>$data]);
    }


    // 直播评论列表
    public function getComments(Request $request) {
        $liveId = $request->input('live_id', 0);
        $page   = $request->input('p', 1);
        $pageSize= 4;
        if (empty($liveId)) {
            return response()->json([
                'code' => 0,
                'msg'  => '错误的参数'
            ]);
        }
        $page = ($page - 1) * $pageSize;

        $comments = DB::select('SELECT u.username,u.avatar,c.id,c.uid,c.content,c.created FROM pai_clients u, pai_live_comments c WHERE u.id=c.uid AND u.status=1 AND c.status=1 AND c.live_id=? ORDER BY c.created desc LIMIT ?,?', [
            $liveId, $page, $pageSize
        ]);

        if (empty($comments)) {
            return response()->json([
                'code' => 0,
                'msg'  => '没有数据了'
            ]);
        }
        foreach ($comments as $key=>$row) {
            $comments[$key]->putime = date('m-d H:i', $row->created);
            $comments[$key]->avatar = 'http://tubes.gutplus.com/'.$row->avatar.'@1e_0o_1l_40h_40w_100q.src?v=5944';
        }

        return response()->json([
            'code' => 200,
            'msg'  => '获取成功',
            'data' => $comments
        ]);
    }
}