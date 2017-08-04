<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;

class showmenuController extends Controller
{
    public function index()
    {
        $menu = request()->get("fname");
        $bt = request()->get("bt");
        return view('weixin.showmenu',['menu'=>$menu,'bt'=>$bt]);
    }
}