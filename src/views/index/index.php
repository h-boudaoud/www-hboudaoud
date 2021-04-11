
<?php

$includeFile=!empty($data["includeFile"])?'/'.$data["includeFile"]:'/_infos.php';

?>

<div  class="radial-gradient" style="
    margin:0;
    padding: 1rem;
    height: 95%;
    overflow: auto;
    "
>
    <?php include (__DIR__.$includeFile);?>

</div>