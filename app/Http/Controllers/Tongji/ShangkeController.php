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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Validator;

class ShangkeController extends Controller {

    public function index()
    {
        $sksj = drc_getshangkeshijian();
        $kcs = Kecheng::where('dianpu_id', auth()->user()->dianpu_id)->get();
        $models = new Collection();
        foreach ($kcs as $kc) {
            $skrs = 0;
            $kks = Kouke::where([['dianpu_id', auth()->user()->dianpu_id], ['kecheng_id', $kc->id]])->get();
            foreach ($kks as $kk){
                if( str_contains($kk->studTime, $sksj )){ $skrs++; }
            }
            $kc->skrs = $skrs;
            $models->add($kc);
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