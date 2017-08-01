<?php
namespace controllers;
use core\Controller;
use http\Request;
class TestController extends Controller{
    public function data($p1,$p2){
        echo __FILE__.":".__LINE__."\t".__METHOD__."<br />";
        echo $p1."<br>".$p2;
        print_r(Request::data());
    }
};
?>
