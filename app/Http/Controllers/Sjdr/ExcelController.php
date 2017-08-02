<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Sjdr;

use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function create()
    {
        return view('sjdr.excel.create');
    }

    public function index()
    {
        return view('sjdr.excel.add');
    }

    public function store()
    {
        $cs = request()->get("type");
        $flag = false;
        switch ($cs){
            case  'dbtoout':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->dbtoout()]);
                break;
            case  'dbtozb':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->dbtozb('storage/app/new.xls', $flag)]);
                break;
            case  'dbtokkb':
                $flag = true;
                return view('sjdr.excel.save', ['xsnr' => app('drc')->dbtokkb('storage/app/new.xls', $flag)]);
                break;

            case 'etodbzb':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->csvtodb('inzb.csv', $flag)]);
                break;
            case  'etodbkkb':
                $flag = true;
                return view('sjdr.excel.save', ['xsnr' => app('drc')->csvtodb('inkkb.csv', $flag)]);
                break;

            case  'dballadd':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->dballadd()]);
                break;
            case  'dballsave':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->dballsave()]);
                break;

            case  'addyonggong':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addYonggong()]);
                break;
            case  'addkecheng':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addKecheng()]);
                break;
            case  'addjiazhang':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addJiazhang()]);
                break;
            case  'addxieyi':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addXieyi()]);
                break;
            case  'addxueyuan':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addXueyuan()]);
                break;
            case  'addkouke':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->addKouke()]);
                break;

            case  'saveyonggong':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveYonggong()]);
                break;
            case  'savekecheng':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveKecheng()]);
                break;
            case  'savejiazhang':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveJiazhang()]);
                break;
            case  'savexieyi':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveXieyi()]);
                break;
            case  'savexueyuan':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveXueyuan()]);
                break;
            case  'savekouke':
                return view('sjdr.excel.save', ['xsnr' => app('drc')->saveKouke()]);
                break;
        }
        return view('sjdr.excel.save', ['xsnr' => app('drc')->exceltodb('storage/app/in.xls', $flag)]);
    }
}