<?php
$lol = 123;
$hash = password_hash($lol , PASSWORD_BCRYPT);
if(password_verify($lol , $hash)){
    echo "goed";
}else{
    echo "lol";
}
