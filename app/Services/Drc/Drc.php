<?php

namespace App\Services\Drc;

use App\Contracts\DrcContract;
use App\Model\Excelkkb;
use App\Model\Excelzbjz;
use App\Model\Excelzbxy;
use App\Model\Gmcp;
use App\Model\Cpfenlei;
use App\Model\Liren;
use App\Model\Tempjiazhang;
use App\Model\Tempyonggong;
use App\Model\Tempkouke;
use App\Model\Tempxieyi;
use App\Model\Tempkecheng;
use App\Model\Tempxueyuan;
use App\Model\Cscp;
use App\Model\Kccp;
use App\Model\Chanpin;
use Carbon\Carbon;

class Drc implements DrcContract
{
    public function saveKouke()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhnr = '';
        $fhz = 0;
        $sheet = Tempkouke::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            $xy = Kccp::where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->first();
            $kc = Cpfenlei::where([['dianpu_id', $dpid], ['name', $item['kcname']]])->first();
            if ($kc != null and $xy != null) {
                $row = [];
                $row['dianpu_id'] = $dpid;
                $row['xueyuan_id'] = $xy->id;
                $row['kecheng_id'] = $kc->id;
                $row['studTime'] = $item['studTime'];
                $row['studKs'] = $item['studKs'];
                $row['kechengQz'] = $kc->quanZhong;
                $model = Liren::where([['dianpu_id', $dpid], ['xueyuan_id', $xy->id], ['kecheng_id', $kc->id]])->first();
                if ($model == null) {
                    Liren::create($row);
                } else {
                    $model->update($row);
                }
                $fhz++;
            } else {
                $fhnr = '错误：<br>' . $item['id'] . '==' . $item['xybh'] . '==' . $item['kcname'];
            }
        }
        return "成功导入扣课数：$fhz<br><br> $fhnr";
    }

    public function saveXieyi()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhnr = '';
        $fhz = 0;
        $sheet = Tempxieyi::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $jz = $this->getJzid($dpid, $item['jzbh']);
                $model = Cscp::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                if ($jz != null) {
                    if ($model == null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['jiazhang_id'] = $jz;
                        $row['name'] = $item['name'];
                        $row['date'] = $item['date'];
                        $row['kebao'] = $item['kebao'];
                        $row['ksZw'] = $item['ksZw'];
                        $row['ksYw'] = $item['ksYw'];
                        $row['jinE'] = $item['jinE'];
                        $row['isZZ'] = $item['isZZ'];
                        $row['guWen1'] = $this->getGwid($dpid, $item['guWen1']);
                        $row['guWen2'] = $this->getGwid($dpid, $item['guWen2']);
                        Cscp::create($row);
                        $item->update(['addFlag' => true]);
                        $fhz++;
                    }
                } else {
                    $fhnr = '错误家长：<br>' . $item['id'] . '-' . $item['jzbh'];
                }
            }
        }
        return "成功导入协议数：$fhz<br><br> $fhnr";
    }

    private function getJzid($dpid, $bh)
    {
        $fhz = null;
        if ($bh != null) {
            $temp = Gmcp::where([['dianpu_id', $dpid], ['bh', $bh]])->first();
            if ($temp != null) {
                $fhz = $temp->id;
            }
        }
        return $fhz;
    }

    private function getGwid($dpid, $name)
    {
        $fhz = null;
        if ($name != null) {
            $temp = Chanpin::where([['dianpu_id', $dpid], ['name', $name]])->first();
            if ($temp != null) {
                $fhz = $temp->id;
            }
        }
        return $fhz;
    }

//    public function tjKouke()
//    {
//        $dpid = auth()->user()->dianpu_id;
//        $fhz = 0;
//        $sheet = Excelkkb::where('dianpu_id',$dpid)->get();
//        foreach ($sheet as $item) {
//            $nrtemp = '';
//            $sjks = 0;
//            $zhks = 0;
//            $row = [];
//            $kkbs = Tempyonggong::where([['dianpu_id', '=', $item['dianpu_id']], ['xueyuan_id', '=', $item['id']]])->get();
//            foreach ($kkbs as $kkb) {
//                $kc = Kecheng::find($kkb['kecheng_id']);
//                $nrtemp = $kc->name . '(' . $kc->quanZhong . ' X ' . $kkb['studKs'] . ')' . $kkb['studTime'] . '==' . $nrtemp;
//                $zhks = $zhks + $kc->quanZhong * $kkb['studKs'];
//                $sjks = $sjks + $kkb['studKs'];
//            }
//            if ($zhks > 0) {
//                $row = [];
//                $row['dianpu_id'] = $item['dianpu_id'];
//                $row['xueyuan_id'] = $item['id'];
//                $row['studTime'] = $nrtemp;
//                $row['studKs'] = $sjks;
//                $row['zeheKs'] = $zhks;
//                $model = Kouke::where([['dianpu_id', '=', $item['dianpu_id']], ['xueyuan_id', '=', $item['id']]])->first();
//                if ($model == null) {
//                    Kouke::create($row);
//                    $fhz++;
//                } else {
//                    $model->update($row);
//                    $fhz++;
//                }
//            }
//        }
//
//        return "成功增加全部扣课信息数：" . $fhz;
//    }

    public function saveXueyuan()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhnr = '家长编号错误：<br>';
        $fhz = 0;
        $sheet = Tempxueyuan::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $model = Kccp::where([['dianpu_id', $dpid], ['bh', $item['bh']]])->first();
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
                        Kccp::create($row);
                        $item->update(['addFlag' => true]);
                        $fhz++;
                    }
                } else {
                    $fhnr = $fhnr . $item['id'] . '-' . $item['jzbh'] . '-' . $item['name'] . '<br>';
                }
            }
        }
        return "成功导入学员数：$fhz<br><br> $fhnr";
    }

    public function saveJiazhang()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $sheet = Tempjiazhang::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $model = Gmcp::where([['dianpu_id', $dpid], ['bh', $item['bh']]])->first();
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
                    Gmcp::create($row);
                    $item->update(['addFlag' => true]);

                    $fhz++;
                }
            }
        }
        return "成功导入家长数：" . $fhz;
    }

    public function saveKecheng()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $sheet = Tempkecheng::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $model = Cpfenlei::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                if ($model == null) {
                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['name'] = $item['name'];
                    $row['boach'] = $item['boach'];
                    $row['ageMin'] = $item['ageMin'];
                    $row['ageMax'] = $item['ageMax'];
                    $row['quanZhong'] = $item['quanZhong'];
                    Cpfenlei::create($row);
                    $fhz++;
                }
            }
        }
        return "成功导入课程数：" . $fhz;
    }

    public function saveYonggong()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $sheet = Tempyonggong::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $model = Chanpin::where([['dianpu_id', $dpid], ['name', $item['name']]])->first();
                if ($model == null) {
                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['name'] = $item['name'];
                    $row['tele'] = $item['tele'];
                    $row['job'] = $item['job'];
                    $row['birthday'] = $item['birthday'];
                    Chanpin::create($row);
                    $fhz++;
                }
            }
        }
        return "成功导入员工数：" . $fhz;
    }

    public function addKouke()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $sheet = Excelkkb::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            $row = [];
            $row['dianpu_id'] = $dpid;
            $row['xybh'] = $item['xybh'];
            $row['kcname'] = $item['kcname'];
            $sksjs = explode(';', $item['sksj']);
            $row['studKs'] = count($sksjs);
            $row['studTime'] = '';
            foreach ($sksjs as $sj) {
                $row['studTime'] = $row['studTime'] . $this->getDatetime($sj) . ';';
            }
            $model = Tempkouke::where([['dianpu_id', $dpid], ['xybh', $item['xybh']], ['kcname', $item['kcname']]])->first();
            if ($model == null) {
                Tempkouke::create($row);
            } else {
                $model->update($row);
            }
            $fhz++;
        }

        return "成功导入临时扣课信息数：" . $fhz;
    }

    private function getDatetime($str)
    {
        $sj = strtotime($str);
        if ($sj) {
            return Carbon::parse($str);
        } else {
            return $str;
        }
    }

    public function addXieyi()
    {
        $dpid = auth()->user()->dianpu_id;
        $cf = 0;
        $cfname = '';
        $fhz = 0;
        $sheet = Excelzbxy::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                $model = Tempxieyi::where([['dianpu_id', $dpid], ['name', $item['xybh']]])->first();
                if ($model == null) {
                    $item['kszw'] = intval($item['kszw']);
                    $item['ksyw'] = intval($item['ksyw']);

                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['name'] = $item['xybh'];
                    $row['jzbh'] = $item['jzbh'];
                    $row['date'] = $this->getBirthday($item['qysj']);
                    $row['kebao'] = $item['kebao'];
                    $row['ksZw'] = $item['kszw'] == '' ? 0 : $item['kszw'];
                    $row['ksYw'] = $item['ksyw'] == '' ? 0 : $item['ksyw'];
                    $row['isZZ'] = $item['zffs'] == '现金' ? false : true;
                    $row['jinE'] = $item['jine'] == null ? 0 : $item['jine'];
                    $row['guWen1'] = $item['gw1'];
                    $row['guWen2'] = $item['gw2'];
                    Tempxieyi::create($row);
                    $item->update(['addFlag' => true]);
                    $fhz++;
                } else {
                    $cf++;
                    $cfname = $cfname . $item['jzbh'] . '-' . $item['xybh'] . '<br>';
                }
            }
        }

        return "成功导入临时协议信息数：$fhz <br><br>重复协议($cf):<br>$cfname";
    }

    private function getBirthday($str)
    {
        $sj = strtotime($str);
        if ($sj) {
            return Carbon::parse($str);
        } else {
            return null;
        }
    }

    public function addXueyuan()
    {
        $fhz = 0;
        $wpp = 0;
        $cf = 0;
        $cfname = '';
        $wppname = '';
        $tempcf = ';';
        $tempwpp = ';';
        $dpid = auth()->user()->dianpu_id;
        $sheet = Excelkkb::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            if (!$item->addFlag) {
                if (strpos($tempcf, ';' . $item['xyname'] . $item['kcname'] . ';') === FALSE) {
                    $tempcf = $tempcf . $item['xyname'] . $item['kcname'] . ';';
                    $model = Tempxueyuan::where([['dianpu_id', $dpid], ['bh', $item['xybh']]])->first();
                    if ($model == null) {
                        $row = [];
                        $row['dianpu_id'] = $dpid;
                        $row['bh'] = $item['xybh'];
                        $row['name'] = $item['xyname'];

                        $xxfj = Excelzbjz::where([['dianpu_id', $dpid], ['xhname1', $item['xyname']]])->first();
                        if ($xxfj != null) {
                            $row['jzbh'] = $xxfj['jzbh'];
                            $row['sex'] = $xxfj['xhsex1'];
                            $row['birth'] = $this->getBirthday($xxfj['xhbirth1']);
                            Tempxueyuan::create($row);
                            $item->update(['addFlag' => true]);
                            $fhz++;
                        } else {
                            $xxfj = Excelzbjz::where([['dianpu_id', $dpid], ['xhname2', $item['xyname']]])->first();
                            if ($xxfj != null) {
                                $row['jzbh'] = $xxfj['jzbh'];
                                $row['sex'] = $xxfj['xhsex2'];
                                $row['birth'] = $this->getBirthday($xxfj['xhbirth2']);
                                Tempxueyuan::create($row);
                                $item->update(['addFlag' => true]);
                                $fhz++;
                            } else {
                                if (strpos($tempwpp, ';' . $item['xyname'] . ';') === FALSE) {
                                    $tempwpp = $tempwpp . $item['xyname'] . ';';
                                    $wpp++;
                                    $jz = Excelzbjz::where('jzbh', $item['jzbh'])->first();
                                    if ($jz != null) {
                                        $wppname = $wppname . $item['jzbh'] . '-' . $item['xyname'] . '===' . $jz->jiazhang_id . '-' . $jz->xhname1 . '-' . $jz->xhname2 . '<br>';
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $cf++;
                    $cfname = $cfname . $item['jzbh'] . '-' . $item['xybh'] . '-' . $item['xyname'] . '-' . '<br>';
                }
            }
        }
        return "成功导入临时学员数：$fhz<br><br>未匹配学员：$wpp<br>$wppname <br>重复学员：$cf<br>$cfname<br>";
    }

    public function addJiazhang()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $fhnr = '错误:<br>';
        $jzname = ';';
        $jztele = ';';
        $sheet = Excelzbjz::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
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
            if (!$item->addFlag) {
                $model = Tempjiazhang::where([['dianpu_id', $dpid], ['bh', $item['jzbh']]])->first();
                if ($model == null) {
                    $row['dianpu_id'] = $dpid;
                    $row['bh'] = $item['jzbh'];
                    $row['hAddress'] = $item['addr'];
                    $row['howGet'] = $item['hqqd'];
                    $row['region'] = $item['quyu'];
                    $row['whenStud'] = $item['pksj'];
                    if (strpos($jzname, ';' . $row['name'] . ';') === FALSE and strpos($jztele, ';' . $row['tele'] . ';') === FALSE) {
                        $jzname = $jzname . $row['name'] . ';';
                        $jztele = $jztele . $row['tele'] . ';';
                        Tempjiazhang::create($row);
                        $item->update(['addFlag' => true]);
                        $fhz++;
                    } else {
                        $fhnr = $fhnr . $item['id'] . '-' . $item['jzbh'] . '-' . $row['name'] . '-' . $row['tele'] . '<br>';
                    }
                }
            } else {
                $jzname = $jzname . $row['name'] . ';';
                $jztele = $jztele . $row['tele'] . ';';
            }
        }
        return "成功导入临时家长数：$fhz<br><br> $fhnr";
    }

    public function addKecheng()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $temp = ";";
        $sheet = Excelkkb::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
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
                    Tempkecheng::create($row);
                    $fhz++;
                }
            }
        }

        return "成功导入临时课程信息数：" . $fhz;
    }

    public function addYonggong()
    {
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $temp = ";";
        $sheet = Excelzbxy::where('dianpu_id', $dpid)->get();
        foreach ($sheet as $item) {
            $item['gw1'] = trim($item['gw1']);
            if ($item['gw1'] != '' and strpos($temp, ';' . $item['gw1'] . ';') === FALSE) {
                $temp = $temp . $item['gw1'] . ';';
                $model = Tempyonggong::where([['dianpu_id', $dpid], ['name', $item['gw1']]])->first();
                if ($model == null) {
                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['name'] = $item['gw1'];
                    Tempyonggong::create($row);
                    $fhz++;
                }
            }
            $item['gw2'] = trim($item['gw2']);
            if ($item['gw2'] != '' and strpos($temp, ';' . $item['gw2'] . ';') === FALSE) {
                $temp = $temp . $item['gw2'] . ';';
                $model = Tempyonggong::where([['dianpu_id', $dpid], ['name', $item['gw2']]])->first();
                if ($model == null) {
                    $row = [];
                    $row['dianpu_id'] = $dpid;
                    $row['name'] = $item['gw2'];
                    Tempyonggong::create($row);
                    $fhz++;
                }
            }
        }

        return "成功导入临时员工信息数：" . $fhz;
    }

    public function exceltodb($xlsFile)
    {
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '1024M');
        $rowint = 0;
        $dpid = auth()->user()->dianpu_id;
        $fhz = 0;
        $excel = app('excel');
        $excelnr = $excel->load($xlsFile)->get();
        foreach ($excelnr as $sheet) {
            if ($sheet->getTitle() == '会员总表') {
                $startRow = 11;
                foreach ($sheet as $item) {
                    $rowint++;
                    if ($rowint >= $startRow) {
                        for ($i = 0; $i < count($item); $i++) {
                            $item[$i] = trim($item[$i]);
                        }
                        if ($item[0] != null) {
                            $fhz++;
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $item[0];
                            $row['moname'] = $item[1];
                            $row['motele'] = $item[2];
                            $row['faname'] = $item[3];
                            $row['fatele'] = $item[4];
                            $row['xhname1'] = $item[5];
                            $row['xhbirth1'] = $item[6];
                            $row['xhsex1'] = $item[7];
                            $row['xhname2'] = $item[8];
                            $row['xhbirth2'] = $item[9];
                            $row['xhsex2'] = $item[10];
                            $row['addr'] = $item[11];
                            $row['hqqd'] = $item[12];
                            $row['quyu'] = $item[13];
                            $row['pksj'] = $item[14];
                            $model = Excelzbjz::where([['dianpu_id', $dpid], ['jzbh', $item[0]]])->first();
                            if ($model == null) {
                                Excelzbjz::create($row);
                            } else {
                                $model->update($row);
                            }

                            if ($item[18] != '') {
                                $fhz++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[0];
                                $rowxy['xybh'] = $item[18];
                                $rowxy['qysj'] = $item[19];
                                $rowxy['kebao'] = $item[20];
                                $rowxy['kszw'] = $item[21];
                                $rowxy['ksyw'] = $item[22];
                                $rowxy['jine'] = $item[23];
                                $rowxy['zffs'] = $item[24];
                                $rowxy['gw1'] = $item[25];
                                $rowxy['gw2'] = $item[26];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $item[0]], ['xybh', $item[18]]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[27] != '') {
                                $fhz++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[0];
                                $rowxy['xybh'] = $item[27];
                                $rowxy['qysj'] = $item[28];
                                $rowxy['kebao'] = $item[29];
                                $rowxy['kszw'] = $item[30];
                                $rowxy['ksyw'] = $item[31];
                                $rowxy['jine'] = $item[32];
                                $rowxy['zffs'] = $item[33];
                                $rowxy['gw1'] = $item[34];
                                $rowxy['gw2'] = $item[35];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $item[0]], ['xybh', $item[27]]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[36] != '') {
                                $fhz++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[0];
                                $rowxy['xybh'] = $item[36];
                                $rowxy['qysj'] = $item[37];
                                $rowxy['kebao'] = $item[38];
                                $rowxy['kszw'] = $item[39];
                                $rowxy['ksyw'] = $item[40];
                                $rowxy['jine'] = $item[41];
                                $rowxy['zffs'] = $item[42];
                                $rowxy['gw1'] = $item[43];
                                $rowxy['gw2'] = $item[44];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $item[0]], ['xybh', $item[36]]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                            if ($item[45] != '') {
                                $fhz++;
                                $rowxy = [];
                                $rowxy['dianpu_id'] = $dpid;
                                $rowxy['jzbh'] = $item[0];
                                $rowxy['xybh'] = $item[45];
                                $rowxy['qysj'] = $item[46];
                                $rowxy['kebao'] = $item[47];
                                $rowxy['kszw'] = $item[48];
                                $rowxy['ksyw'] = $item[49];
                                $rowxy['jine'] = $item[50];
                                $rowxy['zffs'] = $item[51];
                                $rowxy['gw1'] = $item[52];
                                $rowxy['gw2'] = $item[53];
                                $modelxy = Excelzbxy::where([['dianpu_id', $dpid], ['jzbh', $item[0]], ['xybh', $item[45]]])->first();
                                if ($modelxy == null) {
                                    Excelzbxy::create($rowxy);
                                } else {
                                    $modelxy->update($rowxy);
                                }
                            }
                        }
                    }
                }
            } else {     //扣课表
                $startRow = 7;
                $jzid = '';
                $xyid = '';
                $xyname = '';
                foreach ($sheet as $item) {
                    $rowint++;
                    if ($rowint >= $startRow) {
                        if ($item[0] != '') {
                            $jzid = trim($item[0]);
                        }
                        if ($item[1] != '') {
                            $xyid = trim($item[1]);
                        }
                        if ($item[2] != '') {
                            $xyname = trim($item[2]);
                        }
                        $sktem = '';
                        for ($i = 15; $i < count($item); $i++) {
                            $item[$i] = trim($item[$i]);
                            if ($item[$i] != null) {
                                $sktem = $sktem . $item[$i] . ';';
                            } else {
                                $i = count($item);
                            }
                        }
                        if ($sktem != null) {
                            $fhz++;
                            $row = [];
                            $row['dianpu_id'] = $dpid;
                            $row['jzbh'] = $jzid;
                            $row['xybh'] = $xyid;
                            $row['xyname'] = $xyname;
                            $row['kcname'] = $item[14];
                            $row['sksj'] = rtrim($sktem, ';');
                            $model = Excelkkb::where([['dianpu_id', $dpid], ['xybh', $xyid], ['kcname', $item[14]]])->first();
                            if ($model == null) {
                                Excelkkb::create($row);
                            } else {
                                $model->update($row);
                            }
                        }
                    }
                }
            }
        }

        return "成功导入Excel内容：" . $fhz;
    }

    public function autoCreateForm($type)
    {
        switch ($type) {
            case "wxuser":
                $lbroute = "wechatapiuser";
                $path = "weixin/user";
                $title = "微信用户";
                $cxun = "";
                $qxcreate = 'create';
                $qxedit = 'create';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.wx.wx04\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->openid\",\"$title" . "详情\") !!} ||  @include(\"layouts.wx.wx04\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.wx.wx04\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->openid/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.wx.wx04\")";
                $create = ['openid' => '识别号'];
                $showname = [];
                $bx = ['nickname' => '昵称','remark' => '手机号','address' => '地址','xh1name' => '小孩1','xh2name' => '小孩2','xh3name' => '小孩3'];
                $qt = ['groupid' => '用户组号'];
                $lb = ['nickname' => '昵称','remark' => '手机号','address' => '地址','xh1name' => '小孩1','xh2name' => '小孩2','xh3name' => '小孩3','subtime' => '加入日期'];
                $xq = ['subtime' => '加入日期'];
                break;
            case "cangku":
                $lbroute = "cangku";
                $path = "cangku";
                $title = "仓库";
                $cxun = "";
                $qxcreate = 'manage';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['dianpu_id' => '店铺名称'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '仓库名称'];
                $qt = ['desc' => '仓库说明'];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '仓库名称', 'desc' => '仓库说明'];
                $xq = [];
                break;
            case "dianpu":
                $lbroute = "dianpu";
                $path = "dianpu";
                $title = "店铺";
                $cxun = "";
                $qxcreate = 'manage';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = [];
                $showname = [];
                $bx = ['name' => '店铺名称', 'description' => '店铺说明', 'isme' => '自营店铺'];
                $qt = ['telephone' => '店铺电话', 'weixin' => '微信'];
                $lb = ['name' => '店铺名称', 'description' => '店铺说明', 'telephone' => '店铺电话', 'weixin' => '微信', 'isme' => '自营店铺'];
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
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = ['dianpu_id' => '店铺名称', 'role_id' => '用户权限'];
                $showname = ['dianpu->name' => '店铺名称'];
                $bx = ['name' => '账户名称', 'email' => '电子邮件', 'password' => '账户密码', 'password_confirmation' => '确认密码', 'yzm' => '验证码'];
                $qt = [];
                $lb = ['dianpu->name' => '店铺名称', 'name' => '账户名称', 'email' => '电子邮件'];
                $xq = [];
                break;
            case "cplx":
                $lbroute = "cplx";
                $path = "cplx";
                $title = "产品分类";
                $holder = "名称";
                $nrname = "cplxcx";
                $hsname = "cplxhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut11\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut11\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut11\")";
                $create = [];
                $showname = [];
                $bx = ['name' => '产品分类', 'isshow' => '是否显示'];
                $qt = [];
                $lb = ['name' => '产品分类', 'isshow' => '是否显示'];
                $xq = [];
                break;
            case "chanpin":
                $lbroute = "chanpin";
                $path = "chanpin";
                $title = "产品";
                $holder = "产品名称";
                $nrname = "cpcx";
                $hsname = "cphs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'dianzhang';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = ['cpfenlei_id' => '产品分类'];
                $showname = ['cpfenlei->name' => '产品分类'];
                $bx = ['name' => '产品名称'];
                $qt = ['desc' => '产品说明', 'born' => '产地', 'isshow' => '是否显示'];
                $lb = ['name' => '产品名称', 'desc' => '产品说明', 'born' => '产地', 'isshow' => '是否显示'];
                $xq = [];
                break;
            case "kehu":
                $lbroute = "kehu";
                $path = "kehu";
                $title = "客户";
                $holder = "姓名或手机";
                $nrname = "kehucx";
                $hsname = "kehuhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut12\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut12\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut12\")";
                $create = [];
                $showname = [];
                $bx = ['name' => '姓名', 'telephone' => '手机', 'address' => '地址'];
                $qt = ['weixin' => '微信'];
                $lb = ['name' => '姓名', 'telephone' => '手机', 'address' => '地址', 'weixin' => '微信'];
                $xq = [];
                break;
            case "gmcp":
                $lbroute = "gmcp";
                $path = "gmcp";
                $title = "购买产品";
                $holder = "产品编号";
                $nrname = "gmcpcx";
                $hsname = "gmcphs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut13\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut13\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $create = ['dianpu_id' => '店铺', 'cpfenlei_id' => '产品分类', 'chanpin_id' => '产品'];
                $showname = ['dianpu->name' => '店铺', 'cpfenlei->name' => '产品分类', 'chanpin->name' => '产品'];
                $bx = ['pricein' => '进货价', 'priceput' => '出货价', 'packages' => '件数', 'date' => '购买日期'];
                $qt = ['dategq' => '过期时间'];
                $lb = ['dianpu->name' => '店铺', 'chanpin->name' => '产品', 'pricein' => '进货价', 'priceput' => '出货价', 'packages' => '件数', 'date' => '购买日期', 'dategq' => '过期时间'];
                $xq = [];
                break;
            case "kccp":
                $lbroute = "kccp";
                $path = "kccp";
                $title = "库存产品";
                $holder = "";
                $nrname = "kccpcx";
                $hsname = "kccphs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut13\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut13\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $create = [];
                $showname = ['dianpu->name' => '店铺', 'chanpin->name' => '产品'];
                $bx = ['packages' => '件数', 'date' => '购买日期'];
                $qt = ['dategq' => '过期时间'];
                $lb = ['dianpu->name' => '店铺名称', 'chanpin->name' => '产品', 'packages' => '件数', 'date' => '购买日期', 'dategq' => '过期时间'];
                $xq = [];
                break;
            case "cscp":
                $lbroute = "cscp";
                $path = "cscp";
                $title = "出售产品";
                $holder = "";
                $nrname = "cscpcx";
                $hsname = "cscphs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut13\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut13\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $create = ['kehu_id' => '客户', 'dianpu_id' => '店铺', 'chanpin_id' => '产品'];
                $showname = ['kehu->name' => '客户', 'dianpu->name' => '店铺', 'chanpin->name' => '产品'];
                $bx = ['priceout' => '出货价', 'packages' => '件数', 'date' => '出货日期', 'dategq' => '过期时间'];
                $qt = ['qtzkz' => '其他支出'];
                $lb = ['dianpu->name' => '店铺', 'chanpin->name' => '产品', 'priceout' => '出货价', 'packages' => '件数', 'date' => '出货日期', 'dategq' => '过期时间'];
                $xq = [];
                break;
            case "liren":
                $lbroute = "liren";
                $path = "liren";
                $title = "产品利润";
                $holder = "";
                $nrname = "lirencx";
                $hsname = "lirenhs";
                $cxun = "<div>\n{!! Form::open( [\"method\"=>\"put\", \"class\"=>\"form-inline\"]) !!}\n<div class=\"form-group\">\n每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$hsname\") !!}\">\n</div>\n<div class=\"form-group\">\n查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"$nrname\") !!}\" placeholder=\"$holder\">\n</div>\n<button type=\"submit\" class=\"btn btn-default\">确定</button>\n{!! Form::close() !!}\n</div>\n";
                $qxcreate = 'create';
                $qxedit = 'update';
                $qxdelete = 'delete';
                $shortcutcreate = "快捷方式：@include(\"layouts.shortcut13\")";
                $shortcutedit = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan {!! link_to(\"$lbroute/\$task->id\",\"$title" . "详情\") !!} ||  @include(\"layouts.shortcut13\")";
                $shortcutindex = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $shortcutshow = "快捷方式：@can(\"$qxcreate\", new \App\Model\Role){!! link_to(\"$lbroute/create\",\"增加$title\") !!} | @endcan @can(\"$qxedit\", new \App\Model\Role){!! link_to(\"$lbroute/\$task->id/edit\",\"编辑$title\") !!} || @endcan @include(\"layouts.shortcut13\")";
                $create = [];
                $showname = ['dianpu->name' => '店铺', 'chanpin->name' => '产品'];
                $bx = ['pricein' => '进货价', 'priceout' => '出货价', 'packages' => '件数', 'date' => '出售日期', 'dzlr' => '店主利润', 'dllr' => '代理利润'];
                $qt = ['dategq' => '过期时间', 'qtzkz' => '其他支出'];
                $lb = ['dianpu->name' => '店铺', 'chanpin->name' => '产品', 'pricein' => '进货价', 'priceout' => '出货价', 'packages' => '件数', 'date' => '出售日期', 'dzlr' => '店主利润', 'dllr' => '代理利润'];
                $xq = ['dategq' => '过期时间', 'qtzkz' => '其他支出'];
                break;
            default:
                return '';
        }

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

        return $nrindex;
    }

    public function autoCreateScript($type)
    {
        switch ($type) {
            case "cprk":
                $path = "Rcsj";
                $model = "Gmcp";
                $name = ucfirst($type);
                $dllb = "use App\Http\Controllers\Controller;\nuse App\Model\Role;\nuse Carbon\Carbon;\nuse Illuminate\Support\Facades\Cache;\nuse Illuminate\Support\Facades\DB;\nuse Validator;\nuse Illuminate\Http\Request;\n";
                $fjlb = "use App\Model\Gmcp;\n";

                $qxcreate = 'create';
                $qxedit = 'dianzhang';
                $qxdelete = 'admin';

                $selectcreate = ["'dianpus'" => "'dianpu_id','auth()->user()->dianpu_id'"];
                $selectedit = [];
                $selectdelete = [];
                break;

            default:
                return 'error';
        }

        $fhz = "<?php\n\nnamespace App\Http\Controllers\\$path;\n\n";
        $fhz = $fhz . $dllb . $fjlb . "\n";
        $fhz = $fhz . "class $name" . "Controller extends Controller {\n\n";
        //index
        $fhz = $fhz . "public function index(Request \$request)\n{\n";
        $fhz = $fhz . "\$cachename = 'gmcpcx'; \$cachevalue = 'gmcphs';\n \$cxnr = \$request['cxnr']; \$xshs = \$request['xshs']; is_numeric(\$xshs)?null:\$xshs=10;\n if(\$request['_method']){ Cache::forever(\$cachename, \$cxnr); Cache::forever(\$cachevalue, \$xshs); } else{ \$cxnr = Cache::get(\$cachename); \$xshs = Cache::get(\$cachevalue);}\n \$cxtj = '%' . \$cxnr . '%';\n";
        $fhz = $fhz . "if(auth()->user()->can('manage',new Role)) {\n\$models = $model::orderBy('id', 'desc')->where('name', 'like', \$cxtj)->paginate(\$xshs);\n";
        $fhz = $fhz . "}else{\n\$models = $model::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', \$cxtj]])->paginate(\$xshs);\n";
        $fhz = $fhz . "}\nreturn view('" . "$model.index', [ 'tasks' => \$models]);\n}\n\n";
        //create
        $fhz = $fhz . "public function create()\n{\nif(auth()->user()->can('" . "$qxcreate" . "',new Role)){\n";
        $i = 0;
        $cs = '';
        foreach ($selectcreate as $item => $value) {
            $i++;
            $fhz = $fhz . "\$cs$i" . " = drc_selectidname($item, $value);\n";
            $cs = $cs . "'cs$i" . "',";
        }
        $cs = trim($cs, ',');
        $fhz = $fhz . "return view('Gmcp.create',compact($cs));\n}\n return redirect(url('" . "$model.index" . "'))->withErrors(['你没有新建权限。']);\n}\n";
        //end
        $fhz = $fhz . "}\n";

        $ff = fopen("app/http/controllers/$path/" . $name . "Controller.php", 'w');
        fwrite($ff, $fhz);
        fclose($ff);

        return $fhz;
    }
}