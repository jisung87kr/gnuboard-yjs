<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');

if( isset($token) ){
    $token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}


// adm/bbs 상수추가
define('G5_ADM_BBS_URL', G5_ADMIN_URL.'/bbs');
define('G5_ADM_BBS_PATH', G5_ADMIN_PATH.'/bbs');
?>