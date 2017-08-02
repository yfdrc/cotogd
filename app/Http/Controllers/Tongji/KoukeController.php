<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Tongji;

use App\Http\Controllers\Controller;
use App\Model\Tjkouke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class KoukeController extends Controller {

    public function index(Request $request)
    {
        $cachename = 'tjxykoukecx'; $cachevalue = 'tjxykoukehs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = TjKouke::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['isJz', false],['xueyuan_id', 'like', $cxtj]])->paginate($xshs);
        return view('tongji.kouke.index', [ 'tasks' => $models]);
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

    public function store(Request $request)
    {
        $cachename = 'tjjzkoukecx'; $cachevalue = 'tjjzkoukehs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs);
        $cxtj = '%' . $cxnr . '%';
        $models = TjKouke::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['isJz', true],['jiazhang_id', 'like', $cxtj]])->paginate($xshs);
        return view('tongji.kouke.create', [ 'tasks' => $models]);
    }

}