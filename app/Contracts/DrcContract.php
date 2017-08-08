<?php

namespace App\Contracts;

interface DrcContract
{
    public function dbtoout();

    public function dbtozb($xlsFile, $iskkb = false);

    public function dbtokkb($xlsFile, $iskkb = false);

    public function sjtjKouke($dpid=0);

    public function dballsave();

    public function saveKouke();

    public function saveXieyi();

    public function saveXueyuan();

    public function saveJiazhang();

    public function saveKecheng();

    public function dballadd();

    public function saveYonggong();

    public function addKouke();

    public function addXieyi();

    public function addXueyuan();

    public function addJiazhang();

    public function addKecheng();

    public function addYonggong();

    public function csvtodb($fname, $iskkb = false);

    public function exceltodb($xlsFile);

    public function autoCreateform($type);
}