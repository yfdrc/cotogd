<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Tongji;

use App\Http\Controllers\Controller;
use Validator;

class MakeController extends Controller {
    public function index()
    {
        return view('tongji.make.add');
    }

    public function store()
    {
        $cs = request()->get("type");
        switch ($cs){
            case 'kouke':
                return view('tongji.make.save', ['xsnr' => app('drc')->sjtjKouke(),'ts'=>'扣课']);
                break;
        }
        return view('tongji.kouke.make', ['xsnr' => "error"]);
    }

}