<?php
$sub_menu = "201000";
include_once('./_common.php');

$g5['title'] = "관리권한설정 쓰기";
include_once('./admin.head.php');

$result = sql_query("SELECT * FROM view_auth_menu WHERE id = '$id'");
$auth_name = sql_fetch("SELECT * FROM auth_group WHERE id = '$id'");
?>

<div class="tbl_frm01 tbl_wrap">
    <form action="./auth_group_update.php<?php if(isset($id)){ echo '?id='.$id; }?>" method="POST">
    <div class="btn_fixed_top">
        <a href="./auth_group_form.php" id="mail_add" class="btn btn_02">취소</a>
        <input type="submit" value="저장" class="btn_submit btn" accesskey='s'>
    </div>
        <table>
            <tbody>
                <tr>
                    <th>권한명</th>
                    <td>
                        <input type="text" name="auth_group_name" class="required frm_input" value="<?php echo $auth_name['auth_group_name']?>">
                    </td>
                </tr>
                <tr>
                    <th>허용메뉴</th>
                    <td>
                        <div class="menubox">
                            <?php foreach ($menu as $key => $value) { ?>
                            <div class="menubox__group">
                                <div class="menubox__grouptit clear">
                                    <div class="menubox__grouptxt"><?php echo $value[0][1]?></div>
                                    <div class="menubox__inputbox clear">
                                        <div class="menubox__input">
                                            <input type="checkbox" id="auth_grp_r-<?php echo $key?>" class="menubox__checkbox" value="r" data-type="r">
                                            <label for="auth_grp_r-<?php echo $key?>" class="menubox__label">읽기</label>
                                        </div>
                                        <div class="menubox__input">
                                            <input type="checkbox" id="auth_grp_w-<?php echo $key?>" class="menubox__checkbox" value="w" data-type="w">
                                            <label for="auth_grp_w-<?php echo $key?>" class="menubox__label">쓰기</label>
                                        </div>
                                        <div class="menubox__input">
                                            <input type="checkbox" id="auth_grp_d-<?php echo $key?>" class="menubox__checkbox" value="d" data-type="d">
                                            <label for="auth_grp_d-<?php echo $key?>" class="menubox__label">삭제</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear">
                                    <?php foreach ($value as $k => $v) {
                                         if($k == 0) { continue; }
                                         $row = sql_fetch("SELECT * FROM view_auth_menu WHERE id = '$id' AND au_menu = '$v[0]'");
                                         $active = $row ? "active" : "";
                                    ?>
                                    <div class="menubox__item <?php echo $active?>">
                                        <div class="menubox__tit">
                                            <label for="group_tit-<?php echo $k?>" class="menubox__menutit-label"><?php echo $v[1]?></label>
                                            <input type="checkbox" id="group_tit-<?php echo $k?>" class="menubox__menu-checkbox">
                                        </div>
                                        <div class="menubox__inputbox clear">
                                            <input type="hidden" name="auth_rwd[<?php echo $v[0]?>]" value="" class="menubox__rwd">
                                            <div class="menubox__input">
                                                <input type="checkbox" id="auth_r-<?php echo $v[0]?>" class="menubox__checkbox" value="r" data-type="r" <?php echo strpos($row['au_auth'], 'r') !== false ? "checked" : ""?>>
                                                <label for="auth_r-<?php echo $v[0]?>" class="menubox__label">읽기</label>
                                            </div>
                                            <div class="menubox__input">
                                                <input type="checkbox" id="auth_w-<?php echo $v[0]?>" class="menubox__checkbox" value="w" data-type="w" <?php echo strpos($row['au_auth'], 'w') !== false ? "checked" : ""?>>
                                                <label for="auth_w-<?php echo $v[0]?>" class="menubox__label">쓰기</label>
                                            </div>
                                            <div class="menubox__input">
                                                <input type="checkbox" id="auth_d-<?php echo $v[0]?>" class="menubox__checkbox" value="d" data-type="d" <?php echo strpos($row['au_auth'], 'd') !== false ? "checked" : ""?>>
                                                <label for="auth_d-<?php echo $v[0]?>" class="menubox__label">삭제</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    function setRWD(element){
        var targets = element.find(".menubox__checkbox");
        var ck_array = [];
        var rwd = element.find('.menubox__rwd');
        for (var i=0; i < targets.length; i++) {
            if($(targets).eq(i).prop('checked')){
                ck_array.push($(targets).eq(i).val());
            }
        }

        $(rwd).val(ck_array);

        if($(rwd).val()){
            element.addClass("active");
        } else {
            element.removeClass("active");
        }
    }
    
    $(".menubox__grouptit .menubox__checkbox").click(function(){
        var is_checked = $(this).prop('checked');
        var this_mode = $(this).attr("data-type");
        var targets = $(this).closest(".menubox__group").find($("input[data-type="+this_mode+"]"));
        var items = $(this).closest(".menubox__group").find($(".menubox__item"));
        if(is_checked){
            targets.prop('checked', 'true');
        } else {
            targets.prop('checked', '');
        }

        for(var i=0; i<items.length; i++){
            (function(i){
                var element = $(items).eq(i);
                setRWD(element);
            })(i);
        }
    });

    $(".menubox__menu-checkbox").click(function(){
        var is_checked = $(this).prop('checked');
        var parent = $(this).closest(".menubox__item");
        var targets = parent.find(".menubox__checkbox");
        
        if(is_checked){
            targets.prop('checked', 'true');
        } else {
            targets.prop('checked', '');
        }

        setRWD(parent);
    });

    $(".menubox__item .menubox__checkbox").on("click, change", function(){
        var parent = $(this).closest(".menubox__item");
        setRWD(parent);
    });
</script>
<style>
    .clear:after{
        content: "";
        display: block;
        clear: both;
    }

    .menubox__group{
        padding: 30px 0;
        border-bottom: 1px dashed #ccc;
    }

    .menubox__grouptit{
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .menubox__grouptxt,
    .menubox__grouptit .menubox__inputbox{
        float: left;
    }


    .menubox__grouptit .menubox__inputbox{
        font-size: 12px;
        font-weight: normal;
        border: 1px solid #ccc;
        margin-top: -7px;
        margin-left: 10px;
        border-radius: 10px;
        background: #f9f9f9;
    }

    .menubox__menu-checkbox{
        display: none;
    }

    .menubox__item{
        float: left;
        border: 1px solid #ccc;
        margin: 5px 10px 5px 0px;
    }

    .menubox__tit{
        border-bottom:1px solid #ccc;
        padding: 5px;
        background: #f4f4f4;
    }

    .menubox__menutit-label{
        cursor: pointer;
    }

    .menubox__item.active .menubox__tit{
        background: #d1fbff;
    }

    .menubox__inputbox{
        padding: 5px;
    }

    .menubox__input{
        float: left;
        margin: 0 3px;
    }

    .menubox__checkbox{
        margin-top: 2px;
    }

    .menubox__label{
        margin-top: -2px;
    }
</style>
<?php
include_once ('./admin.tail.php');
?>
