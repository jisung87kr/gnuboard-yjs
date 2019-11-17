<?php
function delete_auth_admin($mb_id){
    $row = sql_fetch("SELECT * FROM auth_admin WHERE mb_id = '$mb_id'");
    if ($row){
        sql_query("DELETE FROM auth_admin WHERE mb_id = '$mb_id'");
    }
}
?>