<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;

class ExampleController extends Controller {
    public function index()
    {
        return view('mobile.example.index');
    }

    public function create()
    {
        return view('mobile.example.create');
    }
    public function store(Request $request)
    {
        dd('store');
    }

    public function show($id)
    {
        dd('show');
    }

     public function edit($id)
    {
        dd('edit');
    }

    public function update(Request $request, $id)
    {
        dd('update');
    }

     public function destroy($id)
    {
        dd('destroy');
    }

}