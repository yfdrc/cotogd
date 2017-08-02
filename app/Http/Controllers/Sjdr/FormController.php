<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Sjdr;

use App\Http\Controllers\Controller;

class FormController extends Controller {
    public function index()
    {
        return view('sjdr.form.add');
    }

    public function store()
    {
        $cs = request()->get("type");
        return view('sjdr.form.save',['xsnr'=> app('drc')->autoCreateform($cs)])->with('lx',$cs);
    }

    public function test()
    {
        return (new drclib())->test();
    }
 }