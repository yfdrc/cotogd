<?php
namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload.File');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $file = $request->file('fname');
            $file2 = $request->file('fname2');
            if (isset($file)) {
                if ($file->isValid()) {
                    $type = $file->getClientMimeType();              // image/jpeg
                    $originalName = $file->getClientOriginalName();  // 文件原名
                    $ext = $file->getClientOriginalExtension();      // 扩展名
                    $realPath = $file->getRealPath();               //临时文件的绝对路径
                    $filename = 'inzb.csv';
                    if ($ext == 'csv' and $type=="application/vnd.ms-excel") {
                        if (Storage::disk('local')->exists($filename)) {
                            Storage::delete($filename);
                        }
                        $bool = Storage::disk('local')->put($filename, file_get_contents($realPath));
                        if($bool) return view('upload.File',['ts' => "成功上传文件：$originalName"]);
                    }
                }
            }
            if (isset($file2)) {
                if ($file2->isValid()) {
                    $type = $file2->getClientMimeType();              // image/jpeg
                    $originalName = $file2->getClientOriginalName();  // 文件原名
                    $ext = $file2->getClientOriginalExtension();      // 扩展名
                    $realPath = $file2->getRealPath();               //临时文件的绝对路径
                    $filename = 'inkkb.csv';
                    if ($ext == 'csv' and $type=="application/vnd.ms-excel") {
                        if (Storage::disk('local')->exists($filename)) {
                            Storage::delete($filename);
                        }
                        $bool = Storage::disk('local')->put($filename, file_get_contents($realPath));
                        if($bool) return view('upload.File',['ts' => "成功上传文件：$originalName"]);
                    }
                }
                return view('upload.File')->withErrors(["上传文件失败：$originalName"]);
            }
        }
        return view('upload.File')->withErrors(['没有检测到上传文件。']);
    }
}