<?php
namespace core;
class Templater{
    public $viewFolder = '/views/';
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
        $params = array_merge(Config::env(),$args);
        $this->_content = preg_replace_callback("/\{\{([^\}]+)\}\}/",function($m)use($params){},$this->_content);
        $this->_flush();
    }
    protected $_headers = [];
    protected $_cookies = [];
    protected $_content = '';
    protected function _flush(){
        echo $this->_content;
    }
};
?>
