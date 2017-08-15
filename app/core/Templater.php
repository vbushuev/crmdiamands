<?php
namespace core;
class Templater{
    public $viewFolder = '/views/';
    public function __construct(){
        $this->_params = Config::env();
    }
    public function header($header,$value){
        $this->_headers[$header] = $value;
        return $this;
    }
    public function cookie($header,$value){
        $this->_cookies[$header] = $value;
        return $this;
    }
    public function view($view,$args=[]){
        $viewPath = preg_replace('/\./m','/',$view);
        $viewFile = getcwd().$this->viewFolder.$viewPath.".php";
        // print_r([$viewFile,getcwd()]);exit;
        if(!file_exists($viewFile))throw new Exception("No view {$view} found");
        $this->_content = file_get_contents($viewFile);
        $params = array_merge($this->_params,$args);
        $tut = $this;
        $this->_content = preg_replace_callback("/@(\S+)\([\"']([^\"']+)[\"'],?([^\)]*)\)/im",function($m)use($tut){
        // $this->_content = preg_replace_callback("/@(\S+)\([\"']([^'\"]+)[\"']\)/im",function($m)use($tut){
            // var_dump($m[3]);
            $key = trim($m[1]);
            $vv = $m[2];
            $arguments = ($m[3]=="")?[]:eval("return ".$m[3].";");
            // var_dump($arguments);
            switch($key){
                case "include": return $tut->view($vv,$arguments);
            }
            return $key;
        },$this->_content);
        $this->_content = preg_replace_callback("/\{\{([^\}]+)\}\}/im",function($m)use($params){
            $key = trim($m[1]);
            return isset($params[$key])?$params[$key]:$key;
        },$this->_content);
        $this->_eval($this->_content,$params);
    }
    public function view_old($view,$args=[]){
        $viewPath = preg_replace('/\./m','/',$view);
        $viewFile = getcwd().$this->viewFolder.$viewPath.".php";
        // print_r([$viewFile,getcwd()]);exit;
        if(!file_exists($viewFile))throw new Exception("No view {$view} found");
        $this->_content = file_get_contents($viewFile);
        $params = array_merge($this->_params,$args);
        $this->_content = preg_replace_callback("/\{\{([^\}]+)\}\}/im",function($m)use($params){
            $key = trim($m[1]);
            return isset($params[$key])?$params[$key]:$key;
        },$this->_content);
        $tut = $this;
        $this->_content = preg_replace_callback("/@(\S+)\([\"']([.+?])[\"'],?([^\)]*)\)/im",function($m)use($tut){
            $key = trim($m[1]);
            $arguments = $m[2];
            switch($key){
                case "include": return $tut->view($key,$arguments);
                case "extend": return $tut->view($key,$arguments);
            }
            return $key;
        },$this->_content);

        $this->_flush();
    }
    protected function _eval($code,$args){
        extract($args);
        $tmp = tmpfile ();
        $tmpf = stream_get_meta_data ( $tmp );
        $tmpf = $tmpf ['uri'];
        fwrite ( $tmp, $code );
        $ret = include ($tmpf);
        fclose ( $tmp );
        return $ret;
    }
    protected $_params = [];
    protected $_headers = [];
    protected $_cookies = [];
    protected $_content = '';
    protected function _flush(){
        echo $this->_content;
    }
};
?>
