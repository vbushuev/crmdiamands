<?php
namespace http;
class Request{
    public static function data($type="all"){
        $res = [];
        switch($type){
            case "get":$res["get"]=$_GET;
            case "post":$res["post"]=$_POST;
            case "cookie":$res["cookie"]=$_COOKIE;
            case "session":$res["session"]=$_COOKIE;
            default:$res=[
                "get"=>$_GET,
                "post"=>$_POST,
                "cookie"=>$_COOKIE,
                "session"=>$_SESSION
            ];
        }
        return $res;
    }
    public static function ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
};
?>
