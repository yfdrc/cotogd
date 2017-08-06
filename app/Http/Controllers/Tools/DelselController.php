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
use App\Model\Wxgroup;
use App\Model\Wxuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DelselController extends Controller
{
    public function store(Request $request)
    {
        $cs = $request->get("type");
        $nr = $request->get("nr");
        Log::error($nr);
        switch ($cs){
            case 'tomove':
                $gid = $request->get("gid");
                $nrarr = str_getcsv($nr);
                $wechat = app('wechat');
                $groupService = $wechat->user_group;
                $groupService->moveUsers($nrarr, $gid);
                foreach ($nrarr as $nr){
                    $user = Wxuser::find($nr);
                    $oldgid = $user->group_id;
                    $user->update(['group_id'=>$gid]);
                    $group = Wxgroup::find($oldgid); $group->count += -1;  $group->save();
                    $group = Wxgroup::find($gid); $group->count += 1;  $group->save();
                }
                return "ok";
                break;
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