<?php
use core\Notification;
use interfaces\Notificatable;
class UserNotifications extends Notification{
    protected static $notifications = [
        "register"=>["type"=>"mail","view"=>"views/mail/register.html"],
        "login"=>["type"=>"mail","view"=>"views/mail/login.html"],
        "reset"=>["type"=>"mail","view"=>"views/mail/reset.html"]
    ];
};
?>
