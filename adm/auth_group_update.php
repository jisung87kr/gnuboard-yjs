<?php
$sub_menu = "201000";
include_once('./_common.php');

if(isset($id)){
    sql_query("UPDATE auth_group SET auth_group_name = '$auth_group_name' WHERE id = '$id'");
    sql_query("DELETE FROM auth_menu WHERE auth_group_id = '$id'");
    foreach ($auth_rwd as $key => $value) {
        if($value){
            $sql = "INSERT INTO auth_menu SET auth_group_id = '$id',
                                                  au_menu = '$key'";
                sql_query($sql);
                $auth_menu_id = sql_insert_id();
                $sql2 = "INSERT INTO auth_role SET auth_menu_id = '$auth_menu_id',
                                                   au_auth = '$value'";
                sql_query($sql2);
        }
    }
} else {
    sql_query("INSERT INTO auth_group SET auth_group_name = '$auth_group_name'");
    $id = sql_insert_id();
    foreach ($auth_rwd as $key => $value) {
        if($value){
            $sql = "INSERT INTO auth_menu SET auth_group_id = '$id',
                                              au_menu = '$key'";
            sql_query($sql);
            $auth_menu_id = sql_insert_id();
            $sql2 = "INSERT INTO auth_role SET auth_menu_id = '$auth_menu_id',
                                               au_auth = '$value'";
            sql_query($sql2);
        }
    }
}

goto_url('./auth_group_form.php?id='.$id);

?>



