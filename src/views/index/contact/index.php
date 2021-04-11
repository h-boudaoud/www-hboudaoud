<?php

$sent= isset($data['sent'])?$data['sent']:null;

if (!empty($_POST))
{
    include('send.php') ;
}
else{

    include ('form.php') ;
}

