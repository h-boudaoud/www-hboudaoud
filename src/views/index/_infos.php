<?php
$title ="Welcome in my website";
?>
<h2>Welcome in my website</h2>
<div class="primary" style="margin: 0rem 25% 0rem 1rem">
    <?php
    echo
        "<h3 style='text-align: center;'>The used technologies</h3>".
        "<br />Environment    : {$_SERVER["APP_ENV"]}".
        "<br />REQUEST_URI   :{$_SERVER["REQUEST_URI"]}".
        "<br />REDIRECT_URL   :".$_SERVER['REDIRECT_URL'].
        "<br />QUERY_STRING   :".$_SERVER['QUERY_STRING'].
        "<br />DOCUMENT_ROOT   :{$_SERVER["DOCUMENT_ROOT"]}".
        "<br />getcwd    : ".getcwd();
    ?>
</div>
