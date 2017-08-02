<?php
namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Model\Excelkkb;
use App\Model\Excelzbjz;
use App\Model\Excelzbxy;
use App\Model\Tempjiazhang;
use App\Model\Tempkecheng;
use App\Model\Tempkouke;
use App\Model\Tempxieyi;
use App\Model\Tempxueyuan;
use App\Model\Tempyonggong;
use Illuminate\Http\Request;

class DelselController extends Controller
{
    public function store(Request $request)
    {
        $cs = $request->get("type");
        $nr = $request->get("nr");
        switch ($cs){
            case 'tempyonggong':
                $nrarr = str_getcsv($nr);
                Tempyonggong::destroy($nrarr);
                return "ok";
                break;
            case 'tempkecheng':
                $nrarr = str_getcsv($nr);
                Tempkecheng::destroy($nrarr);
                return "ok";
                break;
            case 'tempjiazhang':
                $nrarr = str_getcsv($nr);
                Tempjiazhang::destroy($nrarr);
                return "ok";
                break;
            case 'tempxueyuan':
                $nrarr = str_getcsv($nr);
                Tempxueyuan::destroy($nrarr);
                return "ok";
                break;
            case 'tempxieyi':
                $nrarr = str_getcsv($nr);
                Tempxieyi::destroy($nrarr);
                return "ok";
                break;
            case 'tempkouke':
                $nrarr = str_getcsv($nr);
                Tempkouke::destroy($nrarr);
                return "ok";
                break;
            case 'yssjzbjz':
                $nrarr = str_getcsv($nr);
                Excelzbjz::destroy($nrarr);
                return "ok";
                break;
            case 'yssjzbxy':
                $nrarr = str_getcsv($nr);
                Excelzbxy::destroy($nrarr);
                return "ok";
                break;
            case 'yssjkkb':
                $nrarr = str_getcsv($nr);
                Excelkkb::destroy($nrarr);
                return "ok";
                break;
        }

        return 'error';
    }
}