<?php

namespace App\Http\Controllers\Home;

use App\Models\Client;
use App\Models\Follows;
use App\Models\TalentApply;
use Illuminate\Http\Request;


class ClientController extends BaseController {

    // 达人分享
    public function getMaster(Request $request) {
        $uid = $request->input('uid', 0);
        if (empty($uid)) return msg(trans('msg.not_exist_master'));

        // 获取达人资料
        $master = Client::select([
            'id',
            'first_name',
            'last_name',
            'username',
            'identity',
            'resume',
            'cover',
            'avatar',
            'role'
        ])->whereRaw('status=1 AND role=1 AND id=?', [$uid])->first();

        if (empty($master)) {
            return msg(trans('msg.not_exist_master'));
        }
        if (empty($master->username)) {
            $master->username = $master->first_name .' '.$master->last_name;
        }
        // 处理封面
        if ($master->cover) {
            $cover = json_decode($master->cover, true);
            $master->cover = 'http://tubes.gutplus.com/'.$cover['name'];
        }
        $master->avatar = getFileUrl($master->avatar);// 'http://tubes.gutplus.com/'.$master->avatar.'@1e_0o_1l_80h_80w_100q.src?v=5944';

        // 处理个人介绍
        if (mb_strlen($master->resume, 'utf-8') > 20) {
            $master->resume_dot = mb_substr($master->resume, 0, 20, 'utf-8').'...';
        } else {
            $master->resume_dot = $master->resume;
        }

        // 获取用户关注和粉丝
        $master->follow = Follows::getFollowByUid($master->id);
        $master->fans   = Follows::getFansByUid($master->id);

//        dd($master);
        return view('client.master')
            ->with('result', $master);
    }


    // 申请达人页面
    public function joinMaster(Request $request) {
        if ($request->isMethod('POST')) {
            $data = [];
            $data['name']   = $request->input('name', false);
            $data['mobile'] = $request->input('phone', false);
            $data['social_tools']=$request->input('wechat', false);
            if (!preg_match_all(REG_RULE_PHONE, $data['mobile'])) {
                return response()->json([
                    'code' => 0,
                    'msg'  => '手机号码错误'
                ]);
            }
            if (empty($data['name']) || empty($data['social_tools'])) {
                return response()->json([
                    'code' => 0,
                    'msg'  => '输入参数错误'
                ]);
            }
            $data['status'] = TalentApply::STATUS_PENDING;
            if (TalentApply::create($data)) {
                return response()->json([
                    'code' => 200,
                    'msg'  => '申请成功'
                ]);
            } else {
                return response()->json([
                    'code' => 0,
                    'msg'  => '提交失败'
                ]);
            }
        }

        return view('client.join-master');
    }
}