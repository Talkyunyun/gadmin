<?php

namespace App\Http\Controllers\Home;


class TestController extends BaseController {


    public function index() {

        return view('public.msg');
    }
}