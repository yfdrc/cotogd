<?php

namespace App\Contracts;

interface DrcContract
{
    public function saveKouke();

    public function saveXieyi();

    public function saveXueyuan();

    public function saveJiazhang();

    public function saveKecheng();

    public function saveYonggong();

    public function addKouke();

    public function addXieyi();

    public function addXueyuan();

    public function addJiazhang();

    public function addKecheng();

    public function addYonggong();

    public function exceltodb($xlsFile);

    public function autoCreateform($type);
}