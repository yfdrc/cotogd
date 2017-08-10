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
use App\Model\Shangke;
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
            $kcarr = $kc->toArray();
            $shangke = Shangke::where([['dianpu_id', auth()->user()->dianpu_id], ['kecheng_id', $kc->id],['sksj',$sksj]])->first();
            $skrs = 0;
            $skxy = '';
            $kks = Kouke::where([['dianpu_id', auth()->user()->dianpu_id], ['kecheng_id', $kc->id]])->get();
            foreach ($kks as $kk) { if (str_contains($kk->studTime, $sksj)) { $skrs++; $skxy = $skxy . $kk->xueyuan->name . ';'; } }
            if(!$shangke) {
                $shangke = new Shangke();
                $shangke ->fill($kcarr);
                $shangke->kecheng_id = $kc->id;
                $shangke->sksj = $sksj;
                $shangke->skxy = $skxy;
                Shangke::create($shangke->toArray());
            } else {
                $shangke->skrs = $skrs;
                $shangke->skxy = $skxy;
                $shangke->update(['skrs'=> $skrs]);
            }
        }
        $models = Shangke::where([['dianpu_id', auth()->user()->dianpu_id],['sksj',$sksj]])->get();

        return view('tongji.shangke.index', [ 'tasks' => $models]);
    }

    public function show($id)
    {
        $model = Shangke::find($id);
        return view('tongji.shangke.show', [ 'task' => $model]);
    }
}