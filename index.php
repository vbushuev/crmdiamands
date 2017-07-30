<?php
include("autoload.php");
use core\Config;
if(User::login('yanusdnd@inbox.ru','Vampire04')!==false)echo 'loged in'."\n";
else "worng username or password\n";
?>
