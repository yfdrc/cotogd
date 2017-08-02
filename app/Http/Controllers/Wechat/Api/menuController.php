<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;

class menuController extends Controller
{
    public function index()
    {
        return view('weixin.menu');
    }

    public function edit()
    {
        $txt = '菜单没有内容。';
        try {
            $wechat = app('wechat');
            $menu = $wechat->menu;
            $txt = $menu->all();
        }catch (\Exception $ex)
        {
            $txt = '显示菜单失败。';
        }
        return view('weixin.menu', ['ts' => $txt]);
    }

    public function show()
    {
        $wechat = app('wechat');
        $menu = $wechat->menu;
        $txt = $menu->destroy();
        return view('weixin.menu', ['ts' => '删除菜单：' . $txt]);
    }

    public function create()
    {
        $wechat = app('wechat');
        $menu = $wechat->menu;
        $buttons = [
            [
                "name"       => "点击跳转",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "自然推荐几款",
                        "key"  => "V1002_TJ"
                    ],
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "weui",
                        "url"  => "http://112.74.161.57/cotogd/example"
                    ],
                ],
            ],
            [
                "name"=> "扫码拍照",
                "sub_button"=> [
                    [
                        "type"=> "scancode_waitmsg",
                        "name"=> "扫码带提示",
                        "key"=> "rselfmenu_0_0",
                        "sub_button"=> [ ]
                    ],
                    [
                        "type"=> "scancode_push",
                        "name"=> "扫码推事件",
                        "key"=> "rselfmenu_0_1",
                        "sub_button"=> [ ]
                    ],
                    [
                        "type"=> "pic_sysphoto",
                        "name"=> "系统拍照发图",
                        "key"=> "rselfmenu_1_0",
                        "sub_button"=> [ ]
                    ],
                    [
                        "type"=> "pic_photo_or_album",
                        "name"=> "拍照或者相册发图",
                        "key"=> "rselfmenu_1_1",
                        "sub_button"=> [ ]
                    ],
                    [
                        "type"=> "pic_weixin",
                        "name"=> "微信相册发图",
                        "key"=> "rselfmenu_1_2",
                        "sub_button"=> [ ]
                    ],
                ]
            ],
            [
                "name"=> "上报资料",
                "sub_button"=> [
                    [
                        "type"=> "location_select",
                        "name"=> "上报位置",
                        "key"=> "telllaca"
                    ]
                ]
            ]
        ];
        $txt = $menu->add($buttons);
        return view('weixin.menu', ['ts' => '新建菜单：'.$txt]);
    }
}