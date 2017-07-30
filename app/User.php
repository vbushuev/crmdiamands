<?php
use db\Model;
use interfaces\Notificatable;
class User extends Model implements Notificatable{
    protected $fillable = ['name','surname','phone','email','rights_id'];
    protected $loginField = "email";
    public function __construct(){
        parent::__construct('users','id','created_at','updated_at');
    }
    public static function register($a=[]){
        if(!count($a))return false;
        $class = get_called_class();
        $res = new $class;
        try{
            if(isset($a["password"]))$a["password"] = self::_cryptPassword($a["password"]);
            $res->create($a);
            UserNotifications::register($res);
        }
        catch(\Exception $e){
            $res = false;
        }
        return $res;
    }
    public static function login($login,$password){
        if(($user = self::find([self::$loginField=>$login]))!==false){
            if(password_verify($password,$user->password))return $user;
        }
        return false;
    }
    public static function reset($login){
        if(($user = self::find([self::$loginField=>$login]))!==false){
            if(password_verify($password,$user->password))return $user;
        }
        return false;
    }
    protected static function _cryptPassword($s){
        return password_hash($s, PASSWORD_BCRYPT);
    }
};
?>
