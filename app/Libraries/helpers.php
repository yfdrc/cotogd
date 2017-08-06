<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2017/3/2
 * Time: 8:51
 */

if (!function_exists('drc_selectidname')) {
    /**
     * 用途：从数据库指定表中读取id,name字段数据生成数组
     * @return [id=>name] 数组, id增加前缀xxx
     */
    function drc_selectidname($tname = 'jiazhangs', $cxcol = '*', $cxval = '1', $ysf = '=', $fhcol = 'name', $czbz = '')
    {
        $fhz = [];
        if ($czbz == 'kccp') {
            $temp = DB::table('kccps')
                ->where([[$cxcol, $ysf, $cxval], ['cangku_id', $tname]])
                ->join('chanpins', 'chanpins.id', '=', 'kccps.chanpin_id')
                ->select('chanpins.id', 'chanpins.name')
                ->distinct()
                ->get();
        } else {
            if ($cxcol == '*') {
                $temp = DB::table($tname)->orderBy('id', 'asc')->get(['id', $fhcol]);
            } else {
                $temp = DB::table($tname)->orderBy('id', 'asc')->where($cxcol, $ysf, $cxval)->get(['id', $fhcol]);
            }
        }
        foreach ($temp as $item) {
            if ($czbz == 'same') {
                $temp2 = array_combine([$item->$fhcol], [$item->$fhcol]);
            }else {
                $temp2 = array_combine(['TMPPRE' . $item->id], [$item->$fhcol]);
            }
            $fhz = array_merge($fhz, $temp2);
        }
        return $fhz;
    }
}

if (!function_exists('drc_selectremoveidpre')) {
    /**
     * 用途：删除id中由函数drc_selectidname增加的前缀
     * @param string $id
     * @return string
     */
    function drc_selectremoveidpre($id = 'id')
    {
        return str_replace("TMPPRE", "", $id);
    }
}


