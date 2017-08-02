<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Model\Dianpu;

class HomeController extends Controller {
    public function index()
    {
        return view('home.index');
    }

    public function about()
    {
        return view('home.about');
    }
    public function contact()
    {
        if(auth()->check()){
            $models = Dianpu::find(auth()->user()->dianpu_id);
        }else{
            $models = Dianpu::find(1);
        }
        return view('home.contact', [ 'tasks' => $models]);
    }
}