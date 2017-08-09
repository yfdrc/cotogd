<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Tongji;

use App\Http\Controllers\Controller;
use App\Model\Kecheng;
use App\Model\Kouke;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;

class ShangkeController extends Controller {

    public function index(Request $request)
    {
        $i = 0;
        $skrs = 0;
        $models = [];
        if( Carbon::now()->minute>30 ) {
            $sksj = Carbon::now()->addHour(1)->format("Y-m-d H");
        } else {
            $sksj = Carbon::now()->format("Y-m-d H");
        }
        $kcs = Kecheng::where('dianpu_id', auth()->user()->dianpu_id)->get();
        foreach ($kcs as $kc) {
            $models[$i]['kecheng_id'] = $kc->name;
            $kks = Kouke::where([['dianpu_id', auth()->user()->dianpu_id], ['kecheng_id', $kc->id]])->get();
            foreach ($kks as $kk){
                if( str_contains($kk->studTime, $sksj )){ $skrs++; }
            }
            $models[$i]['skrs'] = $skrs;
            $i++;
        }
        return view('tongji.shangke.index', [ 'tasks' => $models]);
    }

    public function create()
    {
        $cachename = 'tjjzkoukecx'; $cachevalue = 'tjjzkoukehs';
        $cxnr = Cache::get($cachename);
        $xshs = Cache::get($cachevalue);
        $cxtj = '%' . $cxnr . '%';
        $models = TjKouke::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['isJz', true],['jiazhang_id', 'like', $cxtj]])->paginate($xshs);
        return view('tongji.kouke.create', [ 'tasks' => $models]);
    }
}