<?php
include("autoload.php");
include("kernel.php");

route();

exit;
use core\Config;
if(User::login('yanusdnd@inbox.ru','Vampire04')!==false)echo 'loged in'."\n";
else "worng username or password\n";
?>
