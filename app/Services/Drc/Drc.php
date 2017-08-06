<?php

namespace App\Services\Drc;

use App\Contracts\DrcContract;
use App\Model\Excelkkb;
use App\Model\Exceloutkkb;
use App\Model\Exceloutzb;
use App\Model\Excelzbjz;
use App\Model\Excelzbxy;
use App\Model\Jiazhang;
use App\Model\Kecheng;
use App\Model\Kouke;
use App\Model\Tempjiazhang;
use App\Model\Tempyonggong;
use App\Model\Tempkouke;
use App\Model\Tempxieyi;
use App\Model\Tempkecheng;
use App\Model\Tempxueyuan;
use App\Model\Tjkouke;
use App\Model\Xieyi;
use App\Model\Xueyuan;
use App\Model\Yonggong;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Drc implements DrcContract
{
    public function dbtoout()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::table('exceloutzbs')->truncate();
        DB::table('exceloutkkbs')->truncate();
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Jiazhang::where('dianpu_id', $dpid)->get();

            foreach ($sheet as $item) {
                $row = [];
                $row['dianpu_id'] = $item['dianpu_id'];
                $row['jzbh'] = $item['bh'];
                $row['moname'] = $item['name'];
                $row['motele'] = $item['tele'];
                $row['faname'] = $item['name2'];
                $row['fatele'] = $item['tele2'];

                $xueyuans = Xueyuan::orderBy('id', 'asc')->where([['dianpu_id', $dpid], ['jiazhang_id', $item['id']]])->get();
                if (count($xueyuans) > 0) {
                    $row['xhname1'] = $xueyuans[0]['name'];
                    $row['xhbirth1'] = $xueyuans[0]['birthday'];
                    $row['xhsex1'] = $xueyuans[0]['sexboy'];
                } else {
                    $row['xhname1'] = '';
                    $row['xhbirth1'] = '';
                    $row['xhsex1'] = '';
                }
                if (count($xueyuans) > 1) {
                    $row['xhname2'] = $xueyuans[1]['name'];
                    $row['xhbirth2'] = $xueyuans[1]['birthday'];
                    $row['xhsex2'] = $xueyuans[1]['sexboy'];
                } else {
                    $row['xhname2'] = '';
                    $row['xhbirth2'] = '';
                    $row['xhsex2'] = '';
                }
                if (count($xueyuans) > 2) {
                    $row['xhname3'] = $xueyuans[2]['name'];
                    $row['xhbirth3'] = $xueyuans[2]['birthday'];
                    $row['xhsex3'] = $xueyuans[2]['sexboy'];
                } else {
                    $row['xhname3'] = '';
                    $row['xhbirth3'] = '';
                    $row['xhsex3'] = '';
                }
                if (count($xueyuans) > 3) {
                    $cs1++;
                    $cw1 = $cw1 . '小孩过多，家长编号：' . $row['jzbh'] . "<br>";
                }
                $row['addr'] = $item['hAddress'];
                $row['hqqd'] = $item['howGet'];
                $row['quyu'] = $item['region'];
                $row['pksj'] = $item['whenStud'];
                $xieyis = Xieyi::orderBy('id', 'asc')->where([['dianpu_id', $dpid], ['jiazhang_id', $item['id']]])->get();
                if (count($xieyis) > 0) {
                    $row['xybh1'] = $xieyis[0]['name'];
                    $row['qysj1'] = $xieyis[0]['date'];
                    $row['kebao1'] = $xieyis[0]['kebao'];
                    $row['kszw1'] = $xieyis[0]['ksZw'];
                    $row['ksyw1'] = $xieyis[0]['ksYw'];
                    $row['jine1'] = $xieyis[0]['jinE'];
                    $row['zffs1'] = $xieyis[0]['isZZ'];
                    $row['gw11'] = $xieyis[0]['guWen1'];
                    $row['gw21'] = $xieyis[0]['guWen2'];
                } else {
                    $row['xybh1'] = '';
                    $row['qysj1'] = '';
                    $row['kebao1'] = '';
                    $row['kszw1'] = '';
                    $row['ksyw1'] = '';
                    $row['jine1'] = '';
                    $row['zffs1'] = '';
                    $row['gw11'] = '';
                    $row['gw21'] = '';
                }
                if (count($xieyis) > 1) {
                    $row['xybh2'] = $xieyis[1]['name'];
                    $row['qysj2'] = $xieyis[1]['date'];
                    $row['kebao2'] = $xieyis[1]['kebao'];
                    $row['kszw2'] = $xieyis[1]['ksZw'];
                    $row['ksyw2'] = $xieyis[1]['ksYw'];
                    $row['jine2'] = $xieyis[1]['jinE'];
                    $row['zffs2'] = $xieyis[1]['isZZ'];
                    $row['gw12'] = $xieyis[1]['guWen1'];
                    $row['gw22'] = $xieyis[1]['guWen2'];
                } else {
                    $row['xybh2'] = '';
                    $row['qysj2'] = '';
                    $row['kebao2'] = '';
                    $row['kszw2'] = '';
                    $row['ksyw2'] = '';
                    $row['jine2'] = '';
                    $row['zffs2'] = '';
                    $row['gw12'] = '';
                    $row['gw22'] = '';
                }
                if (count($xieyis) > 2) {
                    $row['xybh3'] = $xieyis[2]['name'];
                    $row['qysj3'] = $xieyis[2]['date'];
                    $row['kebao3'] = $xieyis[2]['kebao'];
                    $row['kszw3'] = $xieyis[2]['ksZw'];
                    $row['ksyw3'] = $xieyis[2]['ksYw'];
                    $row['jine3'] = $xieyis[2]['jinE'];
                    $row['zffs3'] = $xieyis[2]['isZZ'];
                    $row['gw13'] = $xieyis[2]['guWen1'];
                    $row['gw23'] = $xieyis[2]['guWen2'];
                } else {
                    $row['xybh3'] = '';
                    $row['qysj3'] = '';
                    $row['kebao3'] = '';
                    $row['kszw3'] = '';
                    $row['ksyw3'] = '';
                    $row['jine3'] = '';
                    $row['zffs3'] = '';
                    $row['gw13'] = '';
                    $row['gw23'] = '';
                }
                if (count($xieyis) > 3) {
                    $row['xybh4'] = $xieyis[3]['name'];
                    $row['qysj4'] = $xieyis[3]['date'];
                    $row['kebao4'] = $xieyis[3]['kebao'];
                    $row['kszw4'] = $xieyis[3]['ksZw'];
                    $row['ksyw4'] = $xieyis[3]['ksYw'];
                    $row['jine4'] = $xieyis[3]['jinE'];
                    $row['zffs4'] = $xieyis[3]['isZZ'];
                    $row['gw14'] = $xieyis[3]['guWen1'];
                    $row['gw24'] = $xieyis[3]['guWen2'];
                } else {
                    $row['xybh4'] = '';
                    $row['qysj4'] = '';
                    $row['kebao4'] = '';
                    $row['kszw4'] = '';
                    $row['ksyw4'] = '';
                    $row['jine4'] = '';
                    $row['zffs4'] = '';
                    $row['gw14'] = '';
                    $row['gw24'] = '';
                }
                if (count($xieyis) > 4) {
                    $cs1++;
                    $cw1 = $cw1 . '协议过多，家长编号：' . $row['jzbh'] . "<br>";
                }
                DB::table("exceloutzbs")->insert($row);
                $fhz++;
            }

            foreach ($sheet as $item){
                $xueyuans = Xueyuan::orderBy('id', 'asc')->where([['dianpu_id', $dpid], ['jiazhang_id', $item['id']]])->get();
                $xueyshu = count($xueyuans);
                $skcs = 0;
                foreach ($xueyuans as $xy){
                    $xytem = Kouke::where('xueyuan_id',$xy['id'])->first();
                    if($xytem != null) $skcs = $skcs + $xytem->studKs;
                }
                if($skcs>0) {
                    $xieyis = Xieyi::orderBy('id', 'asc')->where([['dianpu_id', $dpid], ['jiazhang_id', $item['id']]])->get();
                    $xieyshu = count($xieyis);
                    if ($xueyshu > 3) {
                        $cs2++;
                        $cw2 = $cw2 . "该家长小孩数过多，家长编号：" . $item['bh'] . "<br>";
                    }
                    if ($xieyshu > 4) {
                        $cs2++;
                        $cw2 = $cw2 . "该家长协议数过多，家长编号：" . $item['bh'] . "<br>";
                    }
                    for ($i = 0; $i < 6 * $xueyshu; $i++) {
                        $row = [];
                        $row['dianpu_id'] = $item['dianpu_id'];
                        if ($i == 0) {
                            $row['jzbh'] = $item['bh'];
                            $row['jzname'] = $item['moname'] . $item['faname'];
                            $row['xhshu'] = $xueyshu;
                        } else {
                            $row['jzbh'] = '';
                            $row['jzname'] = '';
                            $row['xhshu'] = '';
                        }
                        if ($i % 6 == 0) {
                            $kkbrows = [];
                            $kkbrows[0] = ',,';
                            $kkbrows[1] = ',,';
                            $kkbrows[2] = ',,';
                            $kkbrows[3] = ',,';
                            $kkbrows[4] = ',,';
                            $kkbrows[5] = ',,';
                            $row['xybh'] = $xueyuans[$i / 6]['bh'];
                            $row['xyname'] = $xueyuans[$i / 6]['name'];
                            $kkbs = Kouke::orderBy('id', 'asc')->where([['dianpu_id', $dpid], ['xueyuan_id', $xueyuans[$i / 6]['id']]])->get();
                            $kkbi = 0;
                            foreach ($kkbs as $kkb) {
                                if ($kkb['studKs'] <= 50) {
                                    $kkbrows[$kkbi] = $kkb['kcQz'] . ',' . Kecheng::find($kkb['kecheng_id'])->name . ',' . $kkb['studTime'];
                                    $kkbi++;
                                } else {
                                    if ($kkb['studKs'] > 100) {
                                        $cs2++;
                                        $cw2 = $cw2 . "行中的上课次数超100，家长编号：" . $item['bh'] . "<br>";
                                    }
                                    $arrtemp = mb_split(';', $kkb['studTime']);
                                    $strtemp = '';
                                    for ($ti = 0; $ti < 50; $ti++) {
                                        $strtemp = $strtemp . $arrtemp[$ti] . ';';
                                    }
                                    $kkbrows[$kkbi] = $kkb['kcQz'] . ',' . Kecheng::find($kkb['kecheng_id'])->name . ',' . $strtemp;
                                    $strtemp = '';
                                    for ($ti = 50; $ti < 100; $ti++) {
                                        $strtemp = $strtemp . $arrtemp[$ti] . ';';
                                    }
                                    $kkbrows[$kkbi + 1] = $kkb['kcQz'] . ',' . Kecheng::find($kkb['kecheng_id'])->name . ',' . $strtemp;
                                    $kkbi = $kkbi + 2;
                                }
                            }
                            if ($kkbi > 6) {
                                $cw2 = $cw2 . "上课时间超过6行，家长编号：" . $item['bh'] . "<br>";
                            }
                        } else {
                            $row['xybh'] = '';
                            $row['xyname'] = '';
                        }
                        if ($xieyshu > $i) {
                            $row['htbh'] = $xieyis[$i]['name'];
                            $row['htsm'] = $xieyis[$i]['name'];
                            if (str_contains('短', $xieyis[$i]['name']) or str_contains('寒', $xieyis[$i]['name']) or str_contains('暑', $xieyis[$i]['name'])) {
                                $row['htds'] = $xieyis[$i]['ksZw'] + $xieyis[$i]['ksYw'];
                                $row['htzw'] = 0;
                                $row['htyw'] = 0;
                            } else {
                                $row['htds'] = 0;
                                $row['htzw'] = $xieyis[$i]['ksZw'];
                                $row['htyw'] = $xieyis[$i]['ksYw'];
                            }
                        } else {
                            $row['htbh'] = '';
                            $row['htsm'] = '';
                            $row['htds'] = '';
                            $row['htzw'] = '';
                            $row['htyw'] = '';
                        }
                        $skqk = str_getcsv($kkbrows[$i % 6]);
                        if (count($skqk) > 2) {
                            $row['kcqz'] = $skqk[0];
                            $row['kcname'] = $skqk[1];
                            $row['sksj'] = $skqk[2];
                        } else {
                            $row['kcqz'] = '';
                            $row['kcname'] = '';
                            $row['sksj'] = '';
                        }
                        DB::table("exceloutkkbs")->insert($row);
                        $fhz++;
                    }
                }
            }
        });

        return "成功写入用于输出的Excel表信息数：$fhz<br><br>总表错误($cs1)：<br>$cw1<br>扣课表错误($cs2)：<br>$cw2";

    }

    public function dbtozb($xlsFile, $iskkb = false)
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $dpid = auth()->user()->dianpu_id;
        $zbs = Exceloutzb::where('dianpu_id', $dpid)->get();
        $excel = app('excel');
        $sheetid = 0; if($iskkb) $sheetid = 1;
        $excel->selectSheetsByIndex($sheetid)->load($xlsFile,function ($sheets) use ($sheetid,$zbs) {
            $startrow = 13; $startcol = 3; $allcol = 54;
            $sheet = $sheets->getSheet($sheetid);
            for ($i=$startrow; $i<$startrow+count($zbs); $i++) {
                $zbrows = $zbs[$i-$startrow]['original'];
                unset($zbrows['id']); unset($zbrows['dianpu_id']);
                $zbrows = array_values($zbrows);
                for ($j=$startcol; $j<$startcol+$allcol; $j++) {
                    if ($zbrows[$j - $startcol] !='') {
                        for($k=7; $k<=$startrow; $k=$k+$startcol) {
                            if ($zbrows[$k] == 0) { $zbrows[$k] = '女'; }
                            if ($zbrows[$k] == 1) { $zbrows[$k] = '男'; }
                        }
                        $sheet->setCellValueByColumnAndRow($j, $i, $zbrows[$j - $startcol]);  //Column从0开始  Row从1开始
                    }
                }
            }
        })->export('xls');

        return "成功输出的Excel总表。";  //不会执行
    }

    public function dbtokkb($xlsFile, $iskkb = false)
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $dpid = auth()->user()->dianpu_id;
        $kkbs = Exceloutkkb::where('dianpu_id', $dpid)->get();
        $excel = app('excel');
        $sheetid = 0; if($iskkb) $sheetid = 1;
        $excel->selectSheetsByIndex($sheetid)->load($xlsFile,function ($sheets) use ($sheetid,$kkbs) {
            $startrow = 14; $startcol = 7; $startcol2 = 19;
            $sheet = $sheets->getSheet($sheetid);
            for ($i=$startrow; $i<$startrow+count($kkbs); $i++) {
                $kkbrows = $kkbs[$i-$startrow]['original'];
                unset($kkbrows['id']); unset($kkbrows['dianpu_id']);
                $kkbrows = array_values($kkbrows);
                for ($j=$startcol; $j<$startcol2; $j++) {
                    if ($kkbrows[$j - $startcol] !='') {
                        $sheet->setCellValueByColumnAndRow($j, $i, $kkbrows[$j - $startcol]);  //Column从0开始  Row从1开始
                    }
                }
                $sksjarr = mb_split(';',$kkbrows[12]);
                for ($j=$startcol2; $j<$startcol2+count($sksjarr); $j++) {
                    if ($sksjarr[$j - $startcol2] !='') {
                        $sheet->setCellValueByColumnAndRow($j, $i, $sksjarr[$j - $startcol2]);  //Column从0开始  Row从1开始
                    }
                }
            }
        })->export('xls');

        return "成功输出的Excel扣课表。";  //不会执行
    }

    public function sjtjKouke()
    {
        $fhz = 0;
        DB::transaction(function() use (&$fhz) {
            $dpid = auth()->user()->dianpu_id;
            Tjkouke::where('dianpu_id', $dpid)->forceDelete();
            $sheet = Xueyuan::where('dianpu_id', $dpid)->get(['id','jiazhang_id']);
            foreach ($sheet as $item) {
                $nrskqk = '';
                $sjks = 0;
                $zhks = 0;
                $kks = Kouke::where([['dianpu_id', $dpid], ['xueyuan_id', $item['id']]])->get();
                foreach ($kks as $kk) {
                    $kc = Kecheng::find($kk['kecheng_id']);
                    $nrskqk = ';' . $kc->name . '：' . $kk['studKs'] . $nrskqk;
                    $zhks = $zhks + $kc->quanZhong * $kk['studKs'];
                    $sjks = $sjks + $kk['studKs'];
                }
                if ($zhks > 0) {
                    $nrskqk = substr($nrskqk, 1);
                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['jiazhang_id'] = $item['jiazhang_id'];
                    $row['xueyuan_id'] = $item['id'];
                    $row['studQk'] = $nrskqk;
                    $row['studKs'] = $sjks;
                    $row['zeheKs'] = $zhks;
                    $row['isJz'] = false;
                    $model = Tjkouke::where([['dianpu_id', $dpid], ['xueyuan_id', $item['id']]])->first();
                    if ($model == null and $row['studKs']>0) {
                        DB::table("tjkoukes")->insert($row);
                        $fhz++;
                    }
                }
            }
            unset($sheet);
            $sheet = Jiazhang::where('dianpu_id', $dpid)->get(['id']);
            foreach ($sheet as $item) {
                $row = [];
                $row['dianpu_id'] = $dpid;
                $row['jiazhang_id'] = $item['id'];
                $row['isJz'] = true;
                $row['xhqk'] = '';
                $row['studQk'] = '';
                $row['studKs'] = 0;
                $row['zeheKs'] = 0;
                $tjkks = Tjkouke::where([['dianpu_id', $dpid], ['isJz', false], ['jiazhang_id', $item['id']]])->get();
                foreach ($tjkks as $tjkk) {
                    $row['xhqk'] = $row['xhqk'] . Xueyuan::find($tjkk['xueyuan_id'])->name . ';';
                    $row['studQk'] = $row['studQk'] . $tjkk['studQk'] . ';';
                    $row['studKs'] = $row['studKs'] + $tjkk['studKs'];
                    $row['zeheKs'] = $row['zeheKs'] + $tjkk['zeheKs'];
                }
                if ($row['studKs'] > 0) {
                    DB::table("tjkoukes")->insert($row);
                }
            }
        });

        return "成功增加全部统计扣课信息数：" . $fhz;
    }

    public function dballsave(){
        $fhz = $this->saveYonggong();
        $fhz = $fhz . '<br><hr /><br>' . $this->saveKecheng();
        $fhz = $fhz . '<br><hr /><br>' . $this->saveJiazhang();
        $fhz = $fhz . '<br><hr /><br>' . $this->saveXueyuan();
        $fhz = $fhz . '<br><hr /><br>' . $this->saveXieyi();
        $fhz = $fhz . '<br><hr /><br>' . $this->saveKouke();
        return $fhz;
    }

    public function dballadd(){
        $fhz = $this->addYonggong();
        $fhz = $fhz . '<br><hr /><br>' . $this->addKecheng();
        $fhz = $fhz . '<br><hr /><br>' . $this->addJiazhang();
        $fhz = $fhz . '<br><hr /><br>' . $this->addXueyuan();
        $fhz = $fhz . '<br><hr /><br>' . $this->addXieyi();
        $fhz = $fhz . '<br><hr /><br>' . $this->addKouke();
        return $fhz;
    }

    public function saveKouke()
    {

        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $allkk = Kouke::where('dianpu_id', $dpid)->get(['dianpu_id', 'xueyuan_id', 'kecheng_id'])->toArray();
            $sheet = Tempkouke::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $xy = Xueyuan::where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->first();
                    $kc = Kecheng::where([['dianpu_id', $dpid], ['name', $item['kcname']]])->first();
                    if ($kc != null and $xy != null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['xueyuan_id'] = $xy->id;
                        $row['kecheng_id'] = $kc->id;
                        $row['studTime'] = $item['studTime'];
                        $row['studKs'] = $item['studKs'];
                        $row['kcQz'] = $kc->quanZhong;

                        $arrtem = ['dianpu_id' => $row['dianpu_id'], 'xueyuan_id' => $row['xueyuan_id'], 'kecheng_id' => $row['kecheng_id']];
                        if (!in_array($arrtem, $allkk)) {
                            $allkk = array_merge($arrtem, $allkk);
                            DB::table("koukes")->insert($row);
                            $xyzw = $xy['studKssj'] + $row['studKs'];
                            $xyyw = $xy['studKszh'] + $row['studKs'] * $row['kcQz'];
                            DB::table("xueyuans")->where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->update(['studKssj'=>$xyzw, 'studKszh'=>$xyyw]);
                            DB::table("tempkoukes")->where('id', $item['id'])->update(['addFlag' => true]);
                        } else {
                            $model = Kouke::where([['dianpu_id', $dpid], ['xueyuan_id', $xy->id], ['kecheng_id', $kc->id]])->first();
                            if ($model['studTime'] != $item['studTime']) {
                                DB::table("koukes")->where([['dianpu_id', $dpid], ['xueyuan_id', $xy->id], ['kecheng_id', $kc->id]])->update($row);
                                $xyzw = $xy['studKssj'] + $row['studKs'] - $model['studKs'];
                                $xyyw = $xy['studKszh'] + ($row['studKs'] - $model['studKs'])*$row['kcQz'];
                                DB::table("xueyuans")->where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->update(['studKssj'=>$xyzw, 'studKszh'=>$xyyw]);
                                DB::table("tempkoukes")->where('id', $item['id'])->update(['addFlag' => true]);
                            }
                        }
                        $fhz++;
                    } else {
                        if ($kc != null) {
                            $cw1 = $cw1 . 'ID：' . $item['id'] . ' 学员编号：' . $item['xybh'] . ' 课程名称：' . $item['kcname'] . '<br>';
                            $cs1++;
                        } else {
                            $cw2 = $cw2 . 'ID：' . $item['id'] . ' 学员编号：' . $item['xybh'] . ' 课程名称：' . $item['kcname'] . '<br>';
                            $cs2++;
                        }
                    }
                }
            }
        });
        //将所有家长的扣课 剩余课时更新
        return "成功导入扣课数：$fhz<br><br>学员编号不存在($cs1)：<br>$cw1<br>课程名称不存在($cs2)：<br>$cw2";
    }

    public function saveXieyi()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');
        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Tempxieyi::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $jzid = $this->getJzid($dpid, $item['jzbh']);
                    $model = Xieyi::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                    if ($jzid != null) {
                        if ($model == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jiazhang_id'] = $jzid;
                            $row['name'] = $item['name'];
                            $row['date'] = $item['date'];
                            $row['kebao'] = $item['kebao'];
                            $row['ksZw'] = $item['ksZw'];
                            $row['ksYw'] = $item['ksYw'];
                            $row['jinE'] = $item['jinE'];
                            $row['isZZ'] = $item['isZZ'];
                            $row['guWen1'] = $this->getGwid($dpid, $item['guWen1']);
                            $row['guWen2'] = $this->getGwid($dpid, $item['guWen2']);
                            DB::table("xieyis")->insert($row);
                            $jztem = Jiazhang::find($jzid);
                            $jzzw = $jztem->buyZw + $row['ksZw'];
                            $jzyw = $jztem->buyYw + $row['ksYw'];
                            $jzmoney = $jztem->buyMoney + $row['jinE'];
                            $jzleft = $jzyw * 2 + $jzzw - $jztem->studKszh;
                            DB::table("jiazhangs")->where('id', $jzid)->update(['buyZw' => $jzzw, 'buyYw' => $jzyw, 'buyMoney' => $jzmoney, 'leftKeshi' => $jzleft]);
                            DB::table("tempxieyis")->where('id', $item['id'])->update(['addFlag' => true]);
                            $fhz++;
                        } else {
                            $cw2 = $cw2 . 'ID：' . $item['id'] . ' 家长编号：' . $item['jzbh'] . ' 家长姓名：' . $item['name'] . '<br>';
                            $cs2++;
                        }
                    } else {
                        $cw1 = $cw1 . 'ID：' . $item['id'] . ' 家长编号：' . $item['jzbh'] . ' 家长姓名：' . $item['name'] . '<br>';
                        $cs1++;
                    }
                }
            }
        });
        return "成功导入协议数：$fhz<br><br>家长不存在($cs1)：<br>$cw1<br>重复协议($cs2)：<br>$cw2";
    }

    public function saveXueyuan()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Tempxueyuan::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $model = Xueyuan::where([['dianpu_id', $dpid], ['bh', $item['bh']]])->first();
                    $jzid = $this->getJzid($dpid, $item['jzbh']);
                    if ($jzid != null) {
                        if ($model == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jiazhang_id'] = $jzid;
                            $row['bh'] = $item['bh'];
                            $row['name'] = $item['name'];
                            $row['sexboy'] = $item['sex'] == '男' ? true : false;
                            $row['birthday'] = $item['birth'];
                            DB::table("xueyuans")->insert($row);
                            DB::table("tempxueyuans")->where('id', $item['id'])->update(['addFlag' => true]);
                            $fhz++;
                        } else {
                            $cw1 = $cw1 . 'ID：' . $item['id'] . ' 学员编号：' . $item['jzbh'] . ' 学员姓名：' . $item['name'] . '<br>';
                            $cs1++;
                        }
                    }else {
                        $cw2 = $cw2 . '家长编号：' . $item['jzbh'] . ' 学员编号：' . $item['jzbh'] . ' 学员姓名：' . $item['name'] . '<br>';
                        $cs2++;
                    }
                }
            }
        });
        return "成功导入学员数：$fhz<br><br>重复学员错误($cs1)：<br>$cw1<br>家长编号不存在错误($cs2)：<br>$cw2";
    }

    public function saveJiazhang()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');
        $fhz = 0;
        $cs = 0;
        $cf = '';
        DB::transaction(function() use (&$fhz, &$cf, &$cs) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Tempjiazhang::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $model = Jiazhang::where([['dianpu_id', $dpid], ['bh', $item['bh']]])->first();
                    if ($model == null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['bh'] = $item['bh'];
                        $row['name'] = $item['name'];
                        $row['tele'] = $item['tele'];
                        $row['name2'] = $item['name2'];
                        $row['tele2'] = $item['tele2'];

                        $row['hAddress'] = $item['hAddress'];
                        $row['howGet'] = $item['howGet'];
                        $row['region'] = $item['region'];
                        $row['whenStud'] = $item['whenStud'];
                        DB::table("jiazhangs")->insert($row);
                        DB::table("tempjiazhangs")->where('id', $item['id'])->update(['addFlag' => true]);
                        $fhz++;
                    } else {
                        $cf = $cf . '家长姓名：' . $item['name'] . '<br>';
                        $cs++;
                    }
                }
            }
        });
        return "成功导入家长数：$fhz<br><br>重复家长错误($cs)：<br>$cf" ;
    }

    public function saveKecheng()
    {
        $fhz = 0;
        $cs = 0;
        $cf = '';
        DB::transaction(function() use (&$fhz, &$cf, &$cs) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Tempkecheng::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $model = Kecheng::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                    if ($model == null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['name'] = $item['name'];
                        $row['boach'] = $item['boach'];
                        $row['ageMin'] = $item['ageMin'];
                        $row['ageMax'] = $item['ageMax'];
                        $row['quanZhong'] = $item['quanZhong'];
                        DB::table("kechengs")->insert($row);
                        DB::table("tempkechengs")->where('id', $item['id'])->update(['addFlag' => true]);
                        $fhz++;
                    }else{
                        $cf = $cf . '课程名称：' . $item['name'] . '<br>';
                        $cs++;
                    }
                }
            }
        });
        return "成功导入课程数：$fhz<br><br>重复课程错误($cs)：<br>$cf" ;
    }

    public function saveYonggong()
    {
        $fhz = 0;
        $cs = 0;
        $cf = '';
        DB::transaction(function() use (&$fhz, &$cf, &$cs) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Tempyonggong::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $model = Yonggong::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                    if ($model == null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['name'] = $item['name'];
                        $row['tele'] = $item['tele'];
                        $row['job'] = $item['job'];
                        $row['birthday'] = $item['birthday'];
                        DB::table("yonggongs")->insert($row);
                        DB::table("tempyonggongs")->where('id', $item['id'])->update(['addFlag' => true]);
                        $fhz++;
                    }else{
                        $cf = $cf . '员工姓名：' . $item['name'] . '<br>';
                        $cs++;
                    }
                }
            }
        });
        return "成功导入员工数：$fhz<br><br>重复员工错误($cs)：<br>$cf" ;
    }

    public function addKouke()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');
        $fhz1 = 0;
        $fhz2 = 0;
        $cw1 = '';
        $cw2 = '';
        $cs1 = 0;
        $cs2 = 0;
        DB::transaction(function() use (&$fhz1, &$fhz2, &$cw1, &$cw2, &$cs1, &$cs2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Excelkkb::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if(!$item->addFlag) {
//            $txy = Tempxueyuan::where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->first();
                    $txy = Tempxueyuan::where([['dianpu_id', $dpid], ['name', $item['xyname']]])->first();
                    if ($txy == null) {
                        if (strpos($cw1, $item['xyname'] . '<br>') === FALSE) {
                            $cw1 = $cw1 . $item['xybh'] . '-' . $item['xyname'] . '<br>';
                            $cs1++;
                        }
                    } else {
                        if (strpos($cw2, $item['xyname'] . '<br>') === FALSE) {
                            $cw2 = $cw2 . $txy['bh'] . '-' . $txy['name'] . '!=' . $item['xybh'] . '-' . $item['xyname'] . '<br>';
                            $cs2++;
                        }
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['xybh'] = $txy['bh'];
                        $row['kcname'] = $item['kcname'];
                        $sksjs = explode(';', $item['sksj']);
                        $row['studKs'] = count($sksjs);
                        $row['studTime'] = '';
                        foreach ($sksjs as $sj) {
                            $row['studTime'] = $row['studTime'] . $this->toDatetime($sj, false) . ';';
                        }
                        $model = Tempkouke::where([['dianpu_id', $row['dianpu_id']], ['xybh', $row['xybh']], ['kcname', $row['kcname']]])->first();
                        if ($model == null) {
                            DB::table("tempkoukes")->insert($row);
                            DB::table("excelkkbs")->where('id', $item['id'])->update(['addFlag' => true]);
                            $fhz1++;
                        } else {
                            if ($row['studTime'] != $model['studTime']) {
                                DB::table("tempkoukes")->where([['dianpu_id', $row['dianpu_id']], ['xybh', $row['xybh']], ['kcname', $row['kcname']]])->update($row);
                                DB::table("excelkkbs")->where('id', $item['id'])->update(['addFlag' => true]);
                                $fhz1++;
                            } else {
                                $fhz2++;
                            }
                        }
                    }
                }
            }
        });

        return "成功导入临时扣课信息数：$fhz1 （未更新的相同内容信息数为：$fhz2 ） <br><br>学员不存在($cs1)：<br>$cw1<br>学员编号不匹配($cs2)：<br>$cw2";
    }

    public function addXieyi()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $cs = 0;
        $cf = '';
        $fhz = 0;
        DB::transaction(function() use (&$fhz, &$cf, &$cs) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Excelzbxy::where('dianpu_id',$dpid)->get();
            foreach ($sheet as $item) {
                if(!$item->addFlag) {
                    $model = Tempxieyi::where([['dianpu_id', $dpid], ['name', $item['xybh']]])->first();
                    if ($model == null) {
                        $item['kszw'] = intval($item['kszw']);
                        $item['ksyw'] = intval($item['ksyw']);

                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['name'] = $item['xybh'];
                        $row['jzbh'] = $item['jzbh'];
                        $row['date'] = $this->toDatetime($item['qysj']);
                        $row['kebao'] = $item['kebao'];
                        $row['ksZw'] = $item['kszw']==''?0:$item['kszw'];
                        $row['ksYw'] = $item['ksyw']==''?0:$item['ksyw'];
                        $row['isZZ'] = $item['zffs']=='现金'?false:true;
                        $row['jinE'] = $item['jine']==null?0:$item['jine'];
                        $row['guWen1'] = $item['gw1'];
                        $row['guWen2'] = $item['gw2'];
                        DB::table("tempxieyis")->insert($row);
                        DB::table("excelzbxies")->where('id', $item['id'])->update(['addFlag' => true]);
                        $fhz++;
                    }else{
                        $cs++;
                        $cf = $cf . '家长编号：' . $item['jzbh'] . ' 学员编号：' . $item['xybh'] . '<br>';
                    }
                }
            }
        });

        return "成功导入临时协议信息数：$fhz <br><br>重复协议错误($cs):<br>$cf" ;
    }

    public function addXueyuan()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Excelzbjz::where('dianpu_id',$dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addxyFlag) {
                    if ($item['xhname1'] != null) {
                        $modelname = Tempxueyuan::where([['dianpu_id', $dpid], ['name', $item['xhname1']]])->first();
                        $modelbh = Tempxueyuan::where([['dianpu_id', $dpid], ['bh', $item['jzbh'] . '1']])->first();
                        if ($modelname == null and $modelbh == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $item['jzbh'];
                            $row['bh'] = $item['jzbh'] . '1';
                            $row['name'] = $item['xhname1'];
                            $row['sex'] = $item['xhsex1'];
                            $row['birth'] = $this->toDatetime($item['xhbirth1']);
                            DB::table("tempxueyuans")->insert($row);
                            DB::table("excelzbjzs")->where('id', $item['id'])->update(['addxyFlag' => true]);
                            $fhz++;
                        } else {
                            if ($modelbh == null) {
                                $cs1++;
                                $cw1 = $cw1 . '家长编号：' . $item['jzbh'] . ' 学员1姓名：' . $item['xhname1'] . '<br>';
                            }else{
                                $cs2++;
                                $cw2 = $cw2 . '家长编号：' . $item['jzbh'] . ' 学员1姓名：' . $item['xhname1'] . '<br>';
                            }
                        }
                    }
                    if ($item['xhname2'] != null) {
                        $modelname = Tempxueyuan::where([['dianpu_id', $dpid], ['name', $item['xhname2']]])->first();
                        $modelbh = Tempxueyuan::where([['dianpu_id', $dpid], ['bh', $item['jzbh'] . '2']])->first();
                        if ($modelname == null and $modelbh == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $item['jzbh'];
                            $row['bh'] = $item['jzbh'] . '2';
                            $row['name'] = $item['xhname2'];
                            $row['sex'] = $item['xhsex2'];
                            $row['birth'] = $this->toDatetime($item['xhbirth2']);
                            DB::table("tempxueyuans")->insert($row);
                            DB::table("excelzbjzs")->where('id', $item['id'])->update(['addxyFlag' => true]);
                            $fhz++;
                        } else {
                            if ($modelbh == null) {
                                $cs1++;
                                $cw1 = $cw1 . '家长编号：' . $item['jzbh'] . ' 学员2姓名：' . $item['xhname2'] . '<br>';
                            }else{
                                $cs2++;
                                $cw2 = $cw2 . '家长编号：' . $item['jzbh'] . ' 学员2姓名：' . $item['xhname2'] . '<br>';
                            }
                        }
                    }
                    if ($item['xhname3'] != null) {
                        $modelname = Tempxueyuan::where([['dianpu_id', $dpid], ['name', $item['xhname3']]])->first();
                        $modelbh = Tempxueyuan::where([['dianpu_id', $dpid], ['bh', $item['jzbh'] . '3']])->first();
                        if ($modelname == null and $modelbh == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $item['jzbh'];
                            $row['bh'] = $item['jzbh'] . '3';
                            $row['name'] = $item['xhname3'];
                            $row['sex'] = $item['xhsex3'];
                            $row['birth'] = $this->toDatetime($item['xhbirth3']);
                            DB::table("tempxueyuans")->insert($row);
                            DB::table("excelzbjzs")->where('id', $item['id'])->update(['addxyFlag' => true]);
                            $fhz++;
                        } else {
                            if ($modelbh == null) {
                                $cs1++;
                                $cw1 = $cw1 . '家长编号：' . $item['jzbh'] . ' 学员3姓名：' . $item['xhname3'] . '<br>';
                            }else{
                                $cs2++;
                                $cw2 = $cw2 . '家长编号：' . $item['jzbh'] . ' 学员3姓名：' . $item['xhname3'] . '<br>';
                            }
                        }
                    }
                }
            }
        });

        return "成功导入临时学员数：$fhz<br><br>>学员姓名重复($cs1)：<br>$cw1<br>>学员编号重复($cs2)：<br>$cw2";
    }

    public function addJiazhang()
    {
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');

        $fhz = 0;
        $cs1 = 0;
        $cs2 = 0;
        $cw1 = '';
        $cw2 = '';
        DB::transaction(function() use (&$fhz, &$cs1, &$cs2, &$cw1, &$cw2) {
            $dpid = auth()->user()->dianpu_id;
            $sheet = Excelzbjz::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addFlag) {
                    $row = [];
                    if ($item['moname'] == null) {
                        if ($item['faname'] == null) {
                            $row['name'] = $item['xhname1'] . "家长";
                        } else {
                            if (strpos($item['faname'], '小姐') === FALSE and strpos($item['faname'], '先生') === FALSE) {
                                $row['name'] = $item['faname'];
                            } else {
                                $row['name'] = $item['xhname1'] . "家长";
                            }
                        }
                    } else {
                        if (strpos($item['moname'], '小姐') === FALSE and strpos($item['moname'], '先生') === FALSE) {
                            $row['name'] = $item['moname'];
                        } else {
                            $row['name'] = $item['xhname1'] . "家长";
                        }
                        if ($item['faname'] != null) {
                            if (strpos($item['faname'], '小姐') === FALSE and strpos($item['faname'], '先生') === FALSE) {
                                $row['name2'] = $item['faname'];
                            } else {
                                $row['name2'] = $item['xhname1'] . "家长2";
                            }
                        }
                    }
                    if ($item['motele'] == null) {
                        if ($item['fatele'] == null) {
                            $row['tele'] = $row['name'] . "电话";
                        } else {
                            $row['tele'] = $item['fatele'];
                        }
                    } else {
                        $row['tele'] = $item['motele'];
                        $row['tele2'] = $item['fatele'];
                    }
                    $model = Tempjiazhang::where([['dianpu_id', $dpid], ['bh', $item['jzbh']]])->first();
                    $modelname = Tempjiazhang::where([['dianpu_id', $dpid], ['name', $row['name']]])->first();
                    $modeltele = Tempjiazhang::where([['dianpu_id', $dpid], ['tele', $row['tele']]])->first();
                    if ($model == null) {
                        if ($modelname == null and $modeltele == null) {
                            $row['dianpu_id'] = $dpid;
                            $row['bh'] = $item['jzbh'];
                            $row['hAddress'] = $item['addr'];
                            $row['howGet'] = $item['hqqd'];
                            $row['region'] = $item['quyu'];
                            $row['whenStud'] = $item['pksj'];
                            DB::table("tempjiazhangs")->insert($row);
                            DB::table("excelzbjzs")->where('id', $item['id'])->update(['addFlag' => true]);
                            $fhz++;
                        } else {
                            if ($modeltele == null) {
                                $cw1 = $cw1 . $item['jzbh'] . '-' . $row['name'] . '-' . $row['tele'] . '<br>';
                                $cs1++;
                            } else {
                                $cw2 = $cw2 . $item['jzbh'] . '-' . $row['name'] . '-' . $row['tele'] . '<br>';
                                $cs2++;
                            }
                        }
                    }
                }
            }
        });

        return "成功导入临时家长数：$fhz<br><br>姓名重复错误($cs1):<br>$cw1<br>手机号码重复错误($cs2):<br>$cw2";
    }

    public function addKecheng()
    {
        $fhz = 0;
        DB::transaction(function() use (&$fhz) {
            $dpid = auth()->user()->dianpu_id;
            $temp = ";";
            $sheet = Excelkkb::where('dianpu_id', $dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addkcFlag) {
                    $item['kcname'] = trim($item['kcname']);
                    if ($item['kcname'] != '' and strpos($temp, ';' . $item['kcname'] . ';') === FALSE) {
                        $temp = $temp . $item['kcname'] . ';';
                        $model = Tempkecheng::where([['dianpu_id', $dpid], ['name', $item['kcname']]])->first();
                        if ($model == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['name'] = $item['kcname'];
                            $row['ageMin'] = 3;
                            $row['ageMax'] = 15;
                            $row['quanZhong'] = 1;
                            DB::table("tempkechengs")->insert($row);
                            $fhz++;
                        }
                    }
                    DB::table("excelkkbs")->where('id', $item['id'])->update(['addkcFlag' => true]);
                }
            }
        });

        return "成功导入临时课程信息数：" . $fhz;
    }

    public function addYonggong()
    {
        $fhz = 0;
        DB::transaction(function() use (&$fhz) {
            $dpid = auth()->user()->dianpu_id;
            $temp = ";";
            $sheet = Excelzbxy::where('dianpu_id',$dpid)->get();
            foreach ($sheet as $item) {
                if (!$item->addygFlag){
                    $item['gw1'] = trim($item['gw1']);
                    if ($item['gw1']!='' and strpos($temp, ';' . $item['gw1'] . ';') === FALSE) {
                        $temp = $temp . $item['gw1'] . ';';
                        $model = Tempyonggong::where([['dianpu_id',$dpid],['name', $item['gw1']]])->first();
                        if ($model == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['name'] = $item['gw1'];
                            DB::table("tempyonggongs")->insert($row);
                            $fhz++;
                        }
                    }
                    $item['gw2'] = trim($item['gw2']);
                    if ($item['gw2']!='' and strpos($temp, ';' . $item['gw2'] . ';') === FALSE) {
                        $temp = $temp . $item['gw2'] . ';';
                        $model = Tempyonggong::where([['dianpu_id',$dpid],['name', $item['gw2']]])->first();
                        if ($model == null) {
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['name'] = $item['gw2'];
                            DB::table("tempyonggongs")->insert($row);
                            $fhz++;
                        }
                    }
                    DB::table("excelzbxies")->where('id', $item['id'])->update(['addygFlag' => true]);
                }
            }
        });

        return "成功导入临时员工信息数：" . $fhz;
    }

    public function csvtodb($fname, $iskkb = false)
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz1 = 0;
        $fhz2 = 0;
        if($iskkb) {
            DB::table('excelkkbs')->truncate();
            if(Storage::disk('local')->exists($fname)) {
                $fnr = $this->toUtf8(Storage::disk('local')->get($fname));
                $nrarr = explode("\r\n", $fnr);
                unset($fnr);
                DB::transaction(function() use ($nrarr, $dpid, &$fhz1, &$fhz2) {
                    $startRow = 14;   //11、12表头 13统计信息 14输入内容
                    $jzid = '';
                    $xyid = '';
                    $xyname = '';

                    for($rowint = $startRow-1; $rowint<count($nrarr); $rowint++) {
                        $item = str_getcsv($nrarr[$rowint]);
                        if(count($item)>18){
                            $sksjtem = '';
                            $sks = 0;
                            for ($i = 0; $i < count($item); $i++) {
                                $item[$i] = trim($item[$i]);
                            }
                            if ($item[7] != '') {
                                $jzid = $item[7];
                            }
                            if ($item[10] != '') {
                                $xyid = $item[10];
                            }
                            if ($item[11] != '') {
                                $xyname = $item[11];
                            }
                            for ($i = 19; $i < count($item); $i++) {
                                if ($item[$i] != null) {
                                    $fhz2++;
                                    $sks++;
                                    $sksjtem = $sksjtem . $item[$i] . ';';
                                } else {
                                    $i = count($item); //退出
                                }
                            }
                            if ($sksjtem != null) {
                                $fhz1++;
                                $row = [];
                                $row['dianpu_id'] = $dpid;
                                $row['jzbh'] = $jzid;
                                $row['xybh'] = $xyid;
                                $row['xyname'] = $xyname;
                                $row['kcname'] = $item[18];
                                $row['sksj'] = rtrim($sksjtem, ';');
                                $row['sks'] = $sks;
                                $row['kcQz'] = $item[17];
                                DB::table("excelkkbs")->insert($row);
                            }
                        }
                    }
                });
                return "成功导入Excel内容，已学课程数：" . $fhz1 . ' 已学课时数：' . $fhz2;
            }
        } else {
            DB::table('excelzbjzs')->truncate();
            DB::table('excelzbxies')->truncate();
            if(Storage::disk('local')->exists($fname)) {
                $fnr = iconv('CP936','utf-8', Storage::disk('local')->get($fname));
                $nrarr = explode("\r\n", $fnr);
                unset($fnr);
                DB::transaction(function() use ($nrarr, $dpid, &$fhz1, &$fhz2) {
                    $startRow = 13;   //11、12表头  13输入内容
                    for($rowint = $startRow-1; $rowint<count($nrarr); $rowint++) {
                        $item = explode(',', $nrarr[$rowint]);
                        if(count($item)>55){
                            for ($i = 0; $i < count($item); $i++) {
                                $item[$i] = trim($item[$i]);
                            }
                            if ($item[3] != null) {
                                $fhz1++;
                                $row = [];
                                $row['dianpu_id'] = $dpid;
                                $row['jzbh'] = $item[3];
                                $row['moname'] = $item[4];
                                $row['motele'] = $item[5];
                                $row['faname'] = $item[6];
                                $row['fatele'] = $item[7];
                                $row['xhname1'] = $item[8];
                                $row['xhbirth1'] = $item[9];
                                $row['xhsex1'] = $item[10];
                                $row['xhname2'] = $item[11];
                                $row['xhbirth2'] = $item[12];
                                $row['xhsex3'] = $item[13];
                                $row['xhname3'] = $item[14];
                                $row['xhbirth3'] = $item[15];
                                $row['xhsex2'] = $item[16];
                                $row['addr'] = $item[17];
                                $row['hqqd'] = $item[18];
                                $row['quyu'] = $item[19];
                                $row['pksj'] = $item[20];
                                DB::table("excelzbjzs")->insert($row);


                                if ($item[21] != '') {
                                    $fhz2++;
                                    $rowxy = [];
                                    $rowxy['dianpu_id'] = $dpid;
                                    $rowxy['jzbh'] = $item[3];
                                    $rowxy['xybh'] = $item[21];
                                    $rowxy['qysj'] = $item[22];
                                    $rowxy['kebao'] = $item[23];
                                    $rowxy['kszw'] = $item[24];
                                    $rowxy['ksyw'] = $item[25];
                                    $rowxy['jine'] = $item[26];
                                    $rowxy['zffs'] = $item[27];
                                    $rowxy['gw1'] = $item[28];
                                    $rowxy['gw2'] = $item[29];
                                    DB::table("excelzbxies")->insert($rowxy);
                                }
                                if ($item[30] != '') {
                                    $fhz2++;
                                    $rowxy = [];
                                    $rowxy['dianpu_id'] = $dpid;
                                    $rowxy['jzbh'] = $item[3];
                                    $rowxy['xybh'] = $item[30];
                                    $rowxy['qysj'] = $item[31];
                                    $rowxy['kebao'] = $item[32];
                                    $rowxy['kszw'] = $item[33];
                                    $rowxy['ksyw'] = $item[34];
                                    $rowxy['jine'] = $item[35];
                                    $rowxy['zffs'] = $item[36];
                                    $rowxy['gw1'] = $item[37];
                                    $rowxy['gw2'] = $item[38];
                                    DB::table("excelzbxies")->insert($rowxy);
                                }
                                if ($item[39] != '') {
                                    $fhz2++;
                                    $rowxy = [];
                                    $rowxy['dianpu_id'] = $dpid;
                                    $rowxy['jzbh'] = $item[3];
                                    $rowxy['xybh'] = $item[39];
                                    $rowxy['qysj'] = $item[40];
                                    $rowxy['kebao'] = $item[41];
                                    $rowxy['kszw'] = $item[42];
                                    $rowxy['ksyw'] = $item[43];
                                    $rowxy['jine'] = $item[44];
                                    $rowxy['zffs'] = $item[45];
                                    $rowxy['gw1'] = $item[46];
                                    $rowxy['gw2'] = $item[47];
                                    DB::table("excelzbxies")->insert($rowxy);
                                }
                                if ($item[45] != '') {
                                    $fhz2++;
                                    $rowxy = [];
                                    $rowxy['dianpu_id'] = $dpid;
                                    $rowxy['jzbh'] = $item[3];
                                    $rowxy['xybh'] = $item[48];
                                    $rowxy['qysj'] = $item[49];
                                    $rowxy['kebao'] = $item[50];
                                    $rowxy['kszw'] = $item[51];
                                    $rowxy['ksyw'] = $item[52];
                                    $rowxy['jine'] = $item[53];
                                    $rowxy['zffs'] = $item[54];
                                    $rowxy['gw1'] = $item[55];
                                    $rowxy['gw2'] = $item[56];
                                    DB::table("excelzbxies")->insert($rowxy);
                                }
                            }
                        }
                    }
                });
                return "成功导入Excel内容，家长数：" . $fhz1 . ' 协议数：' . $fhz2;
            }

        };

        return "没有导入Excel内容";
    }

    public function exceltodb($xlsFile, $iskkb = false)
    {
//        $excelnr = $excel->load($xlsFile, 'UTF-8') ->convert('csv');  乱码时使用编码加载，加载后可以输出
//        $excelnr = $excel->load($xlsFile)->remember(10)->get(); or ->all()         返回所有sheet remember(10)缓存10分钟
//        $reader = $excel->selectSheetsByIndex(0)->select([1,2,3])->takeRows(2000)->load($xlsFile)->get(); takeRows()实际少则按实际
//        dd($worksheets->getSheet($sheetid)->getTitle());
//        $maxcols = \PHPExcel_Cell::columnIndexFromString($worksheets->getSheet($sheetid)->getHighestColumn());
//        dd('Sid:' . $sheetid . ' C:' . $maxcols. ' R:' . $maxrows);
//        $sheets = $excel->selectSheetsByIndex($sheetid)->load($xlsFile)->get();
//        dd((new \DateTime())->diff($d1)->format('%s'));        $d1 = new \DateTime();
        ini_set('max_execution_time', '1200');
        ini_set('memory_limit', '1024M');
        $excel = app('excel');
        $sheetid = 0;
        if($iskkb) $sheetid = 1;
        $worksheets = $excel->selectSheetsByIndex($sheetid)->load($xlsFile);
        $maxrows = $worksheets->getSheet($sheetid)->getHighestRow();

        $dpid = auth()->user()->dianpu_id;
        $fhz1 = 0;
        $fhz2 = 0;
        $rowint = 0;

        if ($sheetid == 0) {
            Excelzbjz::where('dianpu_id', $dpid)->forceDelete();
            Excelzbxy::where('dianpu_id', $dpid)->forceDelete();
            $startRow = 13;   //11、12表头  13输入内容
            $mcdq = 500;
            for($rs=0; $rs<=$maxrows/$mcdq; $rs++) {
                $sheets = $worksheets->skipRows($mcdq * $rs)->takeRows($mcdq)->get();
                foreach ($sheets[0] as $item) {
                    $rowint++;
                    if ($rowint >= $startRow) {
                        for ($i = 0; $i < count($item); $i++) {
                            $item[$i] = trim($item[$i]);
                        }
                        if ($item[3] != null) {
                            $fhz1++;
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $item[3];
                            $row['moname'] = $item[4];
                            $row['motele'] = $item[5];
                            $row['faname'] = $item[6];
                            $row['fatele'] = $item[7];
                            $row['xhname1'] = $item[8];
                            $row['xhbirth1'] = $item[9];
                            $row['xhsex1'] = $item[10];
                            $row['xhname2'] = $item[11];
                            $row['xhbirth2'] = $item[12];
                            $row['xhsex3'] = $item[13];
                            $row['xhname3'] = $item[14];
                            $row['xhbirth3'] = $item[15];
                            $row['xhsex2'] = $item[16];
                            $row['addr'] = $item[17];
                            $row['hqqd'] = $item[18];
                            $row['quyu'] = $item[19];
                            $row['pksj'] = $item[20];
                            $model = Excelzbjz::where([['dianpu_id', $dpid], ['jzbh', $row['jzbh']]])->first();
                            if ($model == null) {
                                Excelzbjz::create($row);
                            } else {
                                $model->update($row);
                            }

                            if ($item[21] != '') {
                                $fhz2++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[3];
                                $rowxy['xybh'] = $item[21];
                                $rowxy['qysj'] = $item[22];
                                $rowxy['kebao'] = $item[23];
                                $rowxy['kszw'] = $item[24];
                                $rowxy['ksyw'] = $item[25];
                                $rowxy['jine'] = $item[26];
                                $rowxy['zffs'] = $item[27];
                                $rowxy['gw1'] = $item[28];
                                $rowxy['gw2'] = $item[29];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $rowxy['jzbh']], ['xybh', $rowxy['xybh']]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[30] != '') {
                                $fhz2++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[3];
                                $rowxy['xybh'] = $item[30];
                                $rowxy['qysj'] = $item[31];
                                $rowxy['kebao'] = $item[32];
                                $rowxy['kszw'] = $item[33];
                                $rowxy['ksyw'] = $item[34];
                                $rowxy['jine'] = $item[35];
                                $rowxy['zffs'] = $item[36];
                                $rowxy['gw1'] = $item[37];
                                $rowxy['gw2'] = $item[38];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $rowxy['jzbh']], ['xybh', $rowxy['xybh']]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[39] != '') {
                                $fhz2++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[3];
                                $rowxy['xybh'] = $item[39];
                                $rowxy['qysj'] = $item[40];
                                $rowxy['kebao'] = $item[41];
                                $rowxy['kszw'] = $item[42];
                                $rowxy['ksyw'] = $item[43];
                                $rowxy['jine'] = $item[44];
                                $rowxy['zffs'] = $item[45];
                                $rowxy['gw1'] = $item[46];
                                $rowxy['gw2'] = $item[47];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $rowxy['jzbh']], ['xybh', $rowxy['xybh']]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[45] != '') {
                                $fhz2++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[3];
                                $rowxy['xybh'] = $item[48];
                                $rowxy['qysj'] = $item[49];
                                $rowxy['kebao'] = $item[50];
                                $rowxy['kszw'] = $item[51];
                                $rowxy['ksyw'] = $item[52];
                                $rowxy['jine'] = $item[53];
                                $rowxy['zffs'] = $item[54];
                                $rowxy['gw1'] = $item[55];
                                $rowxy['gw2'] = $item[56];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $rowxy['jzbh']], ['xybh', $rowxy['xybh']]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                        }
                    }
                }
                $startRow = 0;
            }
            return "成功导入Excel内容，家长数：" . $fhz1 . ' 协议数：' . $fhz2;
        }else {     //扣课表
            Excelkkb::where('dianpu_id', $dpid)->forceDelete();
            $startRow = 14;   //11、12表头 13统计信息 14输入内容
            $jzid = '';
            $xyid = '';
            $xyname = '';
            $mcdq = 500;
            for($rs=0; $rs<=$maxrows/$mcdq; $rs++){
                $sheets = $worksheets->skipRows($mcdq * $rs)->takeRows($mcdq)->get();
                foreach ($sheets[0] as $item) {
                    $rowint++;
                    if ($rowint >= $startRow) {
                        $sksjtem = '';
                        $sks = 0;

                        if ($item[7] != '') {
                            $jzid = trim($item[7]);
                        }
                        if ($item[10] != '') {
                            $xyid = trim($item[10]);
                        }
                        if ($item[11] != '') {
                            $xyname = trim($item[11]);
                        }
                        for ($i = 19; $i < count($item); $i++) {
                            $item[$i] = trim($item[$i]);
                            if ($item[$i] != null) {
                                $fhz2++;
                                $sks++;
                                $sksjtem = $sksjtem . $item[$i] . ';';
                            } else {
                                $i = count($item); //退出
                            }
                        }
                        if ($sksjtem != null) {
                            $fhz1++;
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $jzid;
                            $row['xybh'] = $xyid;
                            $row['xyname'] = $xyname;
                            $row['kcname'] = $item[18];
                            $row['sksj'] = rtrim($sksjtem, ';');
                            $row['sks'] = $sks;
                            $row['kcQz'] = $item[17];

                            $model = Excelkkb::where([['dianpu_id', $dpid], ['xybh', $xyid], ['kcname', $row['kcname']]])->first();
                            if ($model == null) {
                                Excelkkb::create($row);
                            } else {
                                $model->update($row);
                            }
                        }
                    }
                }
                $startRow = 0;
            }
            return "成功导入Excel内容，已学课程数：" . $fhz1 . ' 已学课时数：' . $fhz2;
        }

        return "没有导入Excel内容";
    }

    public function autoCreateform($type)
    {
        switch ($type) {
            case "wxqr":
                $lbroute = "wechatapiqr";
                $path = "weixin/qr";
                $title = "微信二维码";
                $cxun = "";
                $qxcreate = 'create';
                $qxedit = 'create';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.wx.wx04\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.wx.wx04\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.wx.wx04\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.wx.wx04\")";
                $create = [];
                $showname = [];
                $bx = ['scene_str' => '名称', 'ticket' => '票据', 'url' => '获取地址'];
                $qt = [];
                $lb = ['scene_str' => '名称', 'ticket' => '票据', 'url' => '获取地址'];
                $xq = [];
                break;
            case "dianpu":
                $lbroute = "dianpu";
                $path = "dianpu";
                $title = "店铺";
                $cxun = "";
                $qxcreate = 'manage';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = [];
                $showname = [];
                $bx = ['name' => '店铺名称', 'description' => '店铺说明', 'telephone' => '店铺电话', 'email' => 'Email地址', 'address' => '店铺地址'];
                $qt = [];
                $lb = ['name' => '店铺名称', 'description' => '店铺说明', 'telephone' => '店铺电话', 'address' => '店铺地址'];
                $xq = [];
                break;
            case "user":
                $lbroute = "user";
                $path = "user";
                $title = "账户";
                $cxun = "";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = ['dianpu_id' => '店铺名称','role_id' => '用户权限'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '账户名称', 'email' => '电子邮件', 'password' => '账户密码', 'password_confirmation' => '确认密码', 'yzm' => '验证码'];
                $qt = [];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '账户名称', 'email' => '电子邮件'];
                $xq = [];
                break;
            case "yonggong":
                $lbroute = "yonggong";
                $path = "yonggong";
                $title = "员工";
                $holder = "员工姓名";
                $nrname = "ygcx";
                $hsname = "yghs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = ['dianpu_id' => '店铺名称'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '员工姓名'];
                $qt = ['tele' => '联系电话', 'job' => '职位', 'birthday' => '出生日期'];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '员工姓名', 'tele' => '联系电话', 'job' => '职位', 'birthday' => '出生日期'];
                $xq = [];
                break;
            case "kecheng":
                $lbroute = "kecheng";
                $path = "kecheng";
                $title = "课程";
                $holder = "课程名称";
                $nrname = "kccx";
                $hsname = "kchs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = ['dianpu_id' => '店铺名称'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '课程名称', 'ageMin' => '年龄下限', 'ageMax' => '年龄上限', 'quanZhong' => '课程权重'];
                $qt = ['boach' => '老师姓名'];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '课程名称', 'ageMin' => '年龄下限', 'ageMax' => '年龄上限', 'quanZhong' => '课程权重'];
                $xq = ['boach' => '老师姓名'];
                break;
            case "jiazhang":
                $lbroute = "jiazhang";
                $path = "jiazhang";
                $title = "家长";
                $holder = "家长编号姓名电话";
                $nrname = "jzcx";
                $hsname = "jzhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = [];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['bh' => '家长编号', 'name' => '家长姓名', 'tele' => '家长手机'];
                $qt = ['name2' => '家长2姓名', 'tele2' => '家长2手机', 'hAddress' => '家庭住址', 'howGet' => '获取渠道', 'region' => '所在区域', 'whenStud' => '上课时间'];
                $lb = ['dianpu->name' => '店铺名称', 'bh' => '家长编号', 'name' => '家长姓名', 'tele' => '家长手机', 'leftKeshi' => '剩余课时', 'whenStud' => '上课时间'];
                $xq = ['leftKeshi' => '剩余课时', 'buyZw' => '买中文课', 'buyYw' => '买英文课', 'studKssj' => '学中文课', 'studKszh' => '学英文课', 'buyMoney' => '购买金额'];
                break;
            case "xueyuan":
                $lbroute = "xueyuan";
                $path = "xueyuan";
                $title = "学员";
                $holder = "学员编号或学员姓名";
                $nrname = "xueycx";
                $hsname = "xueyhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['jiazhang_id' => '家长编号'];
                $showname = ['dianpu->name' => '店铺名称', 'jiazhang->name' => '家长姓名'];
                $bx = ['bh' => '学员编号', 'name' => '学员姓名'];
                $qt = ['sexboy' => '男孩', 'birthday' => '出生日期'];
                $lb = ['dianpu->name' => '店铺名称', 'jiazhang->name' => '家长姓名', 'bh' => '学员编号', 'name' => '学员姓名', 'studKssj' => '学中文课', 'studKszh' => '学英文课', 'birthday' => '出生日期'];
                $xq = ['studKssj' => '学中文课', 'studKszh' => '学英文课'];
                break;
            case "xieyi":
                $lbroute = "xieyi";
                $path = "xieyi";
                $title = "协议";
                $holder = "协议编号";
                $nrname = "xieycx";
                $hsname = "xieyhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['jiazhang_id' => '家长编号'];
                $showname = ['dianpu->name' => '店铺名称', 'jiazhang->name' => '家长姓名'];
                $bx = ['name' => '协议编号', 'ksZw' => '中文课时', 'ksYw' => '英文课时', 'jinE' => '协议金额'];
                $qt = ['date' => '签约日期', 'kebao' => '课包', 'isZZ' => '是否转账', 'guWen1' => '顾问1', 'guWen2' => '顾问2'];
                $lb = ['dianpu->name' => '店铺名称', 'jiazhang->name' => '家长姓名', 'name' => '协议编号', 'ksZw' => '中文课时', 'ksYw' => '英文课时', 'jinE' => '协议金额', 'date' => '签约日期'];
                $xq = ['kebao' => '课包', 'isZZ' => '是否转账', 'guWen1' => '顾问1', 'guWen2' => '顾问2'];
                break;
            case "kouke":
                $lbroute = "kouke";
                $path = "kouke";
                $title = "扣课";
                $holder = "上课日期";
                $nrname = "koukcx";
                $hsname = "koukhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['xueyuan_id' => '学员姓名'];
                $showname = ['dianpu_id' => '店铺名称', 'xueyuan->jiazhang->name' => '家长姓名', 'xueyuan->name' => '学员姓名'];
                $bx = ['studTime' => '上课日期', 'studKs' => '上课时数', 'kcQz' => '课程权重'];
                $qt = [];
                $lb = ['xueyuan->jiazhang->name' => '家长姓名', 'xueyuan->name' => '学员姓名', 'studKs' => '上课时数', 'zeheKs' => '折合课数'];
                $xq = [];
                break;
            case "tmyonggong":
                $lbroute = "tempyonggong";
                $path = "temp/yonggong";
                $title = "临时员工";
                $holder = "员工姓名";
                $nrname = "tmygcx";
                $hsname = "tmyghs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = ['dianpu_id' => '店铺名称'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '员工姓名'];
                $qt = ['tele' => '联系电话', 'job' => '职位', 'birthday' => '出生日期'];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '员工姓名', 'tele' => '联系电话', 'job' => '职位', 'birthday' => '出生日期'];
                $xq = [];
                break;
            case "tmkecheng":
                $lbroute = "tempkecheng";
                $path = "temp/kecheng";
                $title = "临时课程";
                $holder = "课程名称";
                $nrname = "tmkccx";
                $hsname = "tmkchs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'manage';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = ['dianpu_id' => '店铺名称'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '课程名称', 'ageMin' => '年龄下限', 'ageMax' => '年龄上限', 'quanZhong' => '课程权重'];
                $qt = ['boach' => '老师姓名'];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '课程名称', 'ageMin' => '年龄下限', 'ageMax' => '年龄上限', 'quanZhong' => '课程权重'];
                $xq = ['boach' => '老师姓名'];
                break;
            case "tmjiazhang":
                $lbroute = "tempjiazhang";
                $path = "temp/jiazhang";
                $title = "临时家长";
                $holder = "家长编号姓名电话";
                $nrname = "tmjzcx";
                $hsname = "tmjzhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = [];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['bh' => '家长编号', 'name' => '家长姓名', 'tele' => '家长手机'];
                $qt = ['name2' => '家长2姓名', 'tele2' => '家长2手机', 'hAddress' => '家庭住址', 'howGet' => '获取渠道', 'region' => '所在区域', 'whenStud' => '上课时间'];
                $lb = ['dianpu->name' => '店铺名称', 'bh' => '家长编号', 'name' => '家长姓名', 'tele' => '家长手机', 'leftKeshi' => '剩余课时', 'whenStud' => '上课时间'];
                $xq = ['leftKeshi' => '剩余课时', 'buyZw' => '买中文课', 'buyYw' => '买英文课', 'studKssj' => '学中文课', 'studKszh' => '学英文课', 'buyMoney' => '购买金额'];
                break;
            case "tmxueyuan":
                $lbroute = "tempxueyuan";
                $path = "temp/xueyuan";
                $title = "临时学员";
                $holder = "学员编号或学员姓名";
                $nrname = "tmxueycx";
                $hsname = "tmxueyhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = ['jiazhang_id' => '家长编号'];
                $showname = ['dianpu->name' => '店铺名称', 'getJzname()' => '家长姓名'];
                $bx = ['bh' => '学员编号', 'name' => '学员姓名'];
                $qt = ['sexboy' => '男孩', 'birthday' => '出生日期'];
                $lb = ['dianpu->name' => '店铺名称', 'getJzname()' => '家长姓名', 'bh' => '学员编号', 'name' => '学员姓名', 'studKssj' => '学中文课', 'studKszh' => '学英文课', 'birthday' => '出生日期'];
                $xq = ['studKssj' => '学中文课', 'studKszh' => '学英文课'];
                break;
            case "tmxieyi":
                $lbroute = "tempxieyi";
                $path = "temp/xieyi";
                $title = "临时协议";
                $holder = "协议编号";
                $nrname = "tmxieycx";
                $hsname = "tmxieyhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = ['jiazhang_id' => '家长编号'];
                $showname = ['dianpu->name' => '店铺名称', 'getJzname()' => '家长姓名'];
                $bx = ['name' => '协议编号', 'ksZw' => '中文课时', 'ksYw' => '英文课时', 'jinE' => '协议金额'];
                $qt = ['date' => '签约日期', 'kebao' => '课包', 'isZZ' => '是否转账', 'guWen1' => '顾问1', 'guWen2' => '顾问2'];
                $lb = ['dianpu->name' => '店铺名称', 'getJzname()' => '家长姓名', 'name' => '协议编号', 'ksZw' => '中文课时', 'ksYw' => '英文课时', 'jinE' => '协议金额', 'date' => '签约日期'];
                $xq = ['kebao' => '课包', 'isZZ' => '是否转账', 'guWen1' => '顾问1', 'guWen2' => '顾问2'];
                break;
            case "tmkouke":
                $lbroute = "tempkouke";
                $path = "temp/kouke";
                $title = "临时扣课";
                $holder = "上课日期";
                $nrname = "tmkoukcx";
                $hsname = "tmkoukhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut21\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut21\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut21\")";
                $create = ['xueyuan_id' => '学员姓名'];
                $showname = ['dianpu->name' => '店铺名称', 'getXyname()' => '学员姓名'];
                $bx = ['studTime' => '上课日期', 'studKs' => '上课时数', 'zeheKs' => '折合课数'];
                $qt = [];
                $lb = ['dianpu->name' => '店铺名称', 'getXyname()' => '学员姓名', 'studTime' => '上课日期', 'studKs' => '上课时数', 'zeheKs' => '折合课数'];
                $xq = [];
                break;
            case "yssjkkb":
                $lbroute = "yssjkkb";
                $path = "sjdr/kkb";
                $title = "原始资料 - 总表 - 课程扣课";
                $holder = "家长编号";
                $nrname = "yssjkkbcx";
                $hsname = "yssjkkbhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut31\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut31\")";
                $create = [];
                $showname = [];
                $bx = ['dianpu_id' => '店铺编号','jzbh' => '家长编号', 'xybh' => '学员编号', 'xyname' => '学员姓名', 'kcname' => '课程名称','sksj' => '上课时间', 'sks' => '上课时数','kcQz' => '课程权重'];
                $qt = [];
                $lb = ['dianpu_id' => '店铺编号','jzbh' => '家长编号', 'xyname' => '学员姓名', 'kcname' => '课程名称','sksj' => '上课时间', 'sks' => '上课时数','kcQz' => '课程权重'];
                $xq = [];
                break;
            case "yssjzbjz":
                $lbroute = "yssjzbjz";
                $path = "sjdr/zbjz";
                $title = "原始资料 - 总表 - 家长学员";
                $holder = "家长编号";
                $nrname = "yssjzbjzcx";
                $hsname = "yssjzbjzhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut31\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut31\")";
                $create = [];
                $showname = [];
                $bx = ['dianpu_id' => '店铺编号','jzbh' => '家长编号', 'moname' => '妈妈姓名', 'motele' => '妈妈电话','pksj' => '排课时间', 'xhname1' => '小孩1姓名','xhbirth1' => '小孩1生日', 'xhsex1' => '小孩1性别'];
                $qt = ['xhname2' => '小孩2姓名','xhbirth2' => '小孩2生日', 'xhsex2' => '小孩2性别', 'xhname3' => '小孩3姓名','xhbirth3' => '小孩3生日', 'xhsex3' => '小孩3性别','faname' => '爸爸姓名', 'fatele' => '爸爸电话', 'addr' => '地址','quyu' => '区域', 'hqqd' => '获取渠道'];
                $lb = ['jzbh' => '家长编号', 'moname' => '妈妈姓名', 'motele' => '妈妈电话','pksj' => '排课时间', 'xhname1' => '小孩1姓名','xhname2' => '小孩2姓名','xhname3' => '小孩3姓名'];
                $xq = [];
                break;
            case "yssjzbxy":
                $lbroute = "yssjzbxy";
                $path = "sjdr/zbxy";
                $title = "原始资料 - 总表 - 员工协议";
                $holder = "家长编号";
                $nrname = "yssjzbxycx";
                $hsname = "yssjzbxyhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutedit = "快捷方式：{!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut31\")";
                $shortcutindex = "快捷方式：@include(\"layouts.shortcut31\")";
                $shortcutshow = "快捷方式：@can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut31\")";
                $create = [];
                $showname = [];
                $bx = ['dianpu_id' => '店铺编号','jzbh' => '家长编号', 'xybh' => '协议编号', 'qysj' => '签约时间','kszw' => '中文课时', 'ksyw' => '英文课时'];
                $qt = ['jine' => '金额', 'kebao' => '课包','zffs' => '是否转账','gw1' => '顾问1', 'gw2' => '顾问2'];
                $lb = ['jzbh' => '家长编号', 'xybh' => '协议编号', 'qysj' => '签约时间','kszw' => '中文课时', 'ksyw' => '英文课时','jine' => '金额', 'kebao' => '课包','gw1' => '顾问1'];
                $xq = [];
                break;
            case "koukekc":
                $lbroute = "koukekc";
                $path = "koukekc";
                $title = "按课程扣课";
                $holder = "上课日期";
                $nrname = "kkkccx";
                $hsname = "kkkchs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title"."详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['xueyuan_id' => '学员姓名', 'kecheng_id' => '课程名称'];
                $showname = ['dianpu->name' => '店铺名称', 'xueyuan->name' => '学员姓名', 'kecheng->name' => '课程名称', 'zeheKs' => '折合课数'];
                $bx = ['studTime' => '上课日期', 'studKs' => '上课时数', 'kcQz' => '课程权重'];
                $qt = [];
                $lb = ['dianpu->name' => '店铺名称', 'xueyuan->name' => '学员姓名', 'kecheng->name' => '课程名称', 'studTime' => '上课日期', 'studKs' => '上课时数', 'zeheKs' => '折合课数'];
                $xq = [];
                break;
            default:
                break;
        }
        if(true) {
            $dd = "</div>\n";
            $p = "<div class='panel panel-primary'>\n";
            $h = "<div class='panel-heading'>\n";
            $b = "<div class='panel-body'>\n";
            $g = "<div class='form-group'>\n";
            $cl = "['class'=>'col-sm-3 control-label']";
            $d = "<div class='col-sm-6'>\n";
            $nr1 = $p . $h . "必填项目\n" . $dd . $b;;  //begin 必填项目
            $nr2 = '';  //create
            $nr3 = '';  //update
            $nr4 = $dd . $dd;  //end 必填项目
            $nr5 = '';  //qt
            $nrshow = "@extends('layouts.app')\n\n@section('content')\n@include('common.errors')\n\n<div class=\"panel panel-success\">\n<div class=\"panel-heading\">\n$shortcutshow\n</div>\n<div class=\"panel-body\">\n<div class=\"panel panel-primary\">\n<div class=\"panel-heading\">\n$title" . "详情\n</div>\n<div class=\"panel-body\">\n{!!  Form::model(\$task, ['url'=>\"$lbroute/\$task->id\", \"method\" => \"DELETE\", \"class\" => \"form-horizontal\"]) !!}\n";
            $nrindex = "@extends('layouts.app')\n\n@section('content')\n@include('common.errors')\n\n<div class=\"panel panel-default\">\n<div class=\"panel-heading\">\n$shortcutindex\n</div>\n<div class=\"panel-body\">\n$cxun@if (count(\$tasks) > 0)\n<div class=\"panel panel-info\">\n<div class=\"panel-heading\">\n$title" . "列表\n</div>\n<div class=\"panel-body\">\n<table class='table table-striped task-table'>\n<thead>\n";
            foreach ($lb as $key => $value) {
                $nrindex = $nrindex . "<th>" . $value . "</th>\n";
            }
            $nrindex = $nrindex . "<th></th>\n</thead>\n<tbody>\n@foreach (" . '$tasks as $task' . ")\n<tr>\n";
            foreach ($lb as $key => $value) {
                if ($key == 'studTime') {
                    $nrindex = $nrindex . "<td class='table-text col-sm-4'>\n<div>{{ " . '$task->' . $key . " }}</div>\n</td>\n";
                } else {
                    $nrindex = $nrindex . "<td class='table-text'>\n<div>{{ " . '$task->' . $key . " }}</div>\n</td>\n";
                }
            }
            $nrindex = $nrindex . "<td>\n<a href=\"$lbroute\{{ " . "$" . "task->id }}\">详情</a> @can(\"$qxedit\", new \App\Model\Role) | <a href=\"$lbroute\{{ " . "$" . "task->id }}\\edit\">编辑</a> @endcan @can(\"$qxdelete\", new \App\Model\Role) | <a href=\"$lbroute\{{ " . "$" . "task->id }}\">删除</a>@endcan\n</td>\n";
            $nrindex = $nrindex . "</tr>\n@endforeach\n</tbody>\n</table>\n{!! \$tasks->links() !!}\n</div>\n</div>\n@endif\n</div>\n</div>\n\n@endsection\n";

            if (array_merge($create, $bx) != []) {
                foreach ($create as $key => $value) {
                    $nr2 = $nr2 . $g;
                    $nr2 = $nr2 . "{{ Form::label('" . $key . "', '" . $value . "'," . $cl . ") }}\n";
                    $nr2 = $nr2 . $d . "{{ Form::select('" . $key . "', " . '$dp, ' . "null, ['class'=>'form-control']) }}\n" . $dd . $dd;
                }
                foreach ($bx as $key => $value) {
                    $nr3 = $nr3 . $g;
                    $nr3 = $nr3 . "{{ Form::label('" . $key . "', '" . $value . "'," . $cl . ") }}\n";
                    if ($key == 'studTime') {
                        $nr3 = $nr3 . $d . "{{ Form::textarea('" . $key . "', null, ['class'=>'form-control']) }}\n" . $dd . $dd;
                    } else {
                        $nr3 = $nr3 . $d . "{{ Form::text('" . $key . "', null, ['class'=>'form-control']) }}\n" . $dd . $dd;
                    }
                }
            }
            foreach ($qt as $key => $value) {
                $nr5 = $nr5 . $g;
                $nr5 = $nr5 . "{{ Form::label('" . $key . "', '" . $value . "'," . $cl . ") }}\n";
                $nr5 = $nr5 . $d . "{{ Form::text('" . $key . "', null, ['class'=>'form-control']) }}\n" . $dd . $dd;
            }
            $nrcreate = "@extends('layouts.app')\n\n@section('content')\n@include('common.errors')\n\n<div class=\"panel panel-success\">\n<div class=\"panel-heading\">\n$shortcutcreate\n</div>\n<div class=\"panel-body\">\n<div class=\"panel panel-success\">\n<div class=\"panel-heading\">\n新建$title\n</div>\n<div class=\"panel-body\">\n{!! Form::open([\"url\"=>\"$lbroute\",\"method\"=>\"POST\",\"class\"=>\"form-horizontal\"]) !!}\n" . $nr1 . $nr2 . $nr3 . $nr4 . $nr5 . "<div class='form-group'>\n<div class='col-sm-offset-3 col-sm-6'>\n<button type='submit' class='btn btn-success'>确定增加</button>\n</div>\n</div>\n{!! Form::close() !!}\n</div>\n</div>\n</div>\n</div>\n\n@endsection\n";
            $nrupdate = "@extends('layouts.app')\n\n@section('content')\n@include('common.errors')\n\n<div class=\"panel panel-success\">\n<div class=\"panel-heading\">\n$shortcutedit\n</div>\n<div class=\"panel-body\">\n<div class=\"panel panel-primary\">\n<div class=\"panel-heading\">\n编辑$title\n</div>\n<div class=\"panel-body\">\n{{ Form::model(\$task, [\"url\"=>\"$lbroute/\$task->id\", \"method\" => \"PUT\", \"class\" => \"form-horizontal\"]) }}\n" . $nr1 . $nr3 . $nr4 . $nr5 . "<div class='form-group'>\n<div class='col-sm-offset-3 col-sm-6'>\n<button type='submit' class='btn btn-warning'>确定修改</button>\n</div>\n</div>\n{!! Form::close() !!}\n</div>\n</div>\n</div>\n</div>\n\n@endsection\n";

            foreach ($showname as $key => $value) {
                $nrshow = $nrshow . $g;
                $nrshow = $nrshow . "{{ Form::label('" . $key . "', '" . $value . "'," . $cl . ") }}\n";
                $nrshow = $nrshow . $d . "{{ \$task->$key }}\n" . $dd . $dd;
            }
            $xqall = array_merge($bx, $qt, $xq);
            foreach ($xqall as $key => $value) {
                $nrshow = $nrshow . $g;
                $nrshow = $nrshow . "{{ Form::label('" . $key . "', '" . $value . "'," . $cl . ") }}\n";
                $nrshow = $nrshow . $d . "{{ \$task->$key }}\n" . $dd . $dd;
            }
            $nrshow = $nrshow . "@can(\"$qxdelete\", new App\Model\Role)\n<div class='form-group'>\n<div class='col-sm-offset-3 col-sm-6'>\n<button type='submit' class='btn btn-danger'>确定删除</button>\n</div>\n</div>\n@endcan\n{!! Form::close() !!}\n</div>\n</div>\n</div>\n</div>\n\n@endsection";

            $ff = fopen("resources/views/$path/create.blade.php", 'w');
            fwrite($ff, $nrcreate);
            fclose($ff);

            $ff = fopen("resources/views/$path/edit.blade.php", 'w');
            fwrite($ff, $nrupdate);
            fclose($ff);

            $ff = fopen("resources/views/$path/show.blade.php", 'w');
            fwrite($ff, $nrshow);
            fclose($ff);

            $ff = fopen("resources/views/$path/index.blade.php", 'w');
            fwrite($ff, $nrindex);
            fclose($ff);
        }
        return $nrindex;
    }

    private function toUtf8($nrin){
        $fhz = '';
        try {
            $encode_arr = array('UTF-8', 'ASCII', 'GBK', 'GB2312', 'BIG5', 'JIS', 'eucjp-win', 'sjis-win', 'EUC-JP');
            $encoded = mb_detect_encoding($nrin, $encode_arr);
            $fhz = iconv($encoded, 'utf-8', $nrin);
        }catch (\Exception $e)
        {}
        return $fhz;
    }

    private function toDatetime($str, $tonull = true)
    {
        $sj = strtotime($str);
        if($sj){
            return Carbon::parse($str);
        }else{
            if($tonull){ $sj = null; } else { $sj = $str; }
        }
        return $sj;
    }

    private function getGwid($dpid, $name)
    {
        $fhz = null;
        if ($name != null) {
            $temp = Yonggong::where([['dianpu_id', $dpid], ['name', $name]])->first();
            if ($temp != null) {
                $fhz = $temp->id;
            }
        }
        return $fhz;
    }

    private function getJzid($dpid, $bh)
    {
        $fhz = null;
        if ($bh != null) {
            $temp = Jiazhang::where([['dianpu_id', $dpid], ['bh', $bh]])->first();
            if ($temp != null) {
                $fhz = $temp->id;
            }
        }
        return $fhz;
    }
}