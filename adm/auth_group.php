<?php
$sub_menu = "201000";
include_once('./_common.php');

//테이블이 없으면 생성
if(!sql_fetch("SHOW TABLES LIKE 'auth_group'")){
    $sql = "CREATE TABLE IF NOT EXISTS `auth_group` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `auth_group_name` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if(!sql_query($sql)){
        die('auth_group 테이블 생성 오류');
    };
}

if(!sql_fetch("SHOW TABLES LIKE 'auth_menu'")){
    $sql = "CREATE TABLE IF NOT EXISTS `auth_menu` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `auth_group_id` int(11) NOT NULL,
            `au_menu` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `auth_group__auth_menu` FOREIGN KEY (`auth_group_id`) REFERENCES `auth_group`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if(!sql_query($sql)){
        die('auth_menu 테이블 생성 오류');
    }
}

if(!sql_fetch("SHOW TABLES LIKE 'auth_role'")){
    $sql = "CREATE TABLE IF NOT EXISTS `auth_role` (
            `auth_menu_id` int(11) NOT NULL,
            `au_auth` set('r','w','d') NOT NULL,
            PRIMARY KEY (`auth_menu_id`),
            CONSTRAINT `auth_menu__auth_role` FOREIGN KEY (`auth_menu_id`) REFERENCES `auth_menu`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if(!sql_query($sql)){
        die('auth_role 테이블 생성 오류');
    }
}

if(!sql_fetch("SHOW TABLES LIKE 'auth_admin'")){
    $sql = "CREATE TABLE IF NOT EXISTS `auth_admin` (
            `idx` int(11) NOT NULL,
            `mb_id` varchar(255) NOT NULL,
            `auth_group_id` int(11) NOT NULL,
            PRIMARY KEY (`idx`),
            CONSTRAINT `auth_group__auth_admin` FOREIGN KEY (`auth_group_id`) REFERENCES `auth_group`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if(!sql_query($sql, $e=true)){
        var_dump($e);
        die('auth_admin 테이블 생성 오류');
    }
}

//뷰가 없으면 생성
if(!sql_fetch("SHOW TABLES LIKE 'view_auth_menu'")){
    $sql = "CREATE
    ALGORITHM = UNDEFINED
    VIEW `view_auth_menu`
    AS SELECT 
       A.mb_id,
       B.auth_group_name,
       C.au_menu,
       D.au_auth
   FROM 
       auth_admin AS A,
       auth_group AS B,
       auth_menu AS C,
       auth_role AS D
   WHERE
       A.auth_group_id = B.id AND
       B.id = C.auth_group_id AND
       C.id = D.auth_menu_id";
    if(!sql_query($sql)){
        die('뷰생성 에러');
    };
}

$g5['title'] = "관리권한설정";
include_once('./admin.head.php');

// $del이 있으면 삭제
if(isset($del)){
    $sql = "DELETE FROM auth_group WHERE id = $del";
    sql_query($sql);
}

//행가져오기
$sql = "SELECT * FROM auth_group";
$result = sql_query($sql);
?>

<div class="tbl_head01 tbl_wrap">
    <table>
        <thead>
            <tr>
                <th>권한그룹</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sql_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['auth_group_name']?></td>
                <td>
                    <a href="<?php echo G5_ADMIN_URL.'/auth_group_form.php?id='.$row['id']?>" class="btn btn_03">수정</a>
                    <a href="./auth_group.php?del=<?php echo $row['id']?>" class="btn btn_01">삭제</a>
                </td>
            </tr>    
            <?php } ?>
        </tbody>
    </table>
</div>


<?php
include_once ('./admin.tail.php');
?>
