<?php
define('G5_IS_ADMIN', true);
include_once ('../../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');

$qstr = ''; //관리자에서 쓰이는 기본 쿼리스트팅 제거, 페이지네이션을 사용하기 위해 추가

if(isset($bo_table)){ // 현재 페이지 메뉴 찾기
    foreach ($menu as $key => $value) {
        foreach ($value as $k => $v) {
            if(in_array($bo_table, $v)){
                $sub_menu = $v[0];
                break;
            }
        }
    }
}

// 관리자 스킨 경로 덮어쓰기
$board_skin_path    = get_skin_path('board', $board['bo_adm_skin']);
$board_skin_url     = get_skin_url('board', $board['bo_adm_skin']);
?>