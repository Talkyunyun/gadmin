<?php

namespace App\Http\Controllers\Home;

use App\Models\ClientTicketCode;
use DB;
use Illuminate\Http\Request;

class TicketController extends BaseController {

    // 门票显示
    public function ticketShow(Request $request) {
        $code = $request->input('code', false);
        if (empty($code)) {
            return msg('错误的code码');
        }
        $ticketCode = ClientTicketCode::select(['ticket_id', 'code', 'uid'])->whereRaw('status=1 AND code=?', [$code])->first();
        if (empty($ticketCode)) {
            return msg(trans('msg.ticket_not_exists'));
        }

        // 获取该直播门票
        dd($ticketCode);

        return view('ticket.index');
    }

    // 领取门票
    public function getTicket(Request $request) {
        $liveId = $request->input('live_id', 0);
        $code   = $request->input('code', 0);
    }
}