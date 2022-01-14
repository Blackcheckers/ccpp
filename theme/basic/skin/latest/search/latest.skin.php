<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 500;
$thumb_height = 0;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<style>
    html{
        font-family: 'Noto Sans KR', sans-serif;
    }

    .item a{
        color: #000;
        text-decoration: none;
        word-break: keep-all;
        line-height: 1.3;
    }

    img{
        margin-bottom: 10px;
    }

    .title{
        font-weight: 400;
        color: #333;
    }

    @media(max-width : 560px){
        html{
            font-size: 12px;
        }
    }
</style>
<div class="row" style="margin-top: 30px">
    <?php
    for ($i=0; $i<$list_count; $i++) {
//        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
        ?>
        <div class="col-md-3 col-6 item" style="margin-bottom: 30px;">
            <a href="<?php echo $list[$i]['wr_link1']?>" target="_blank">
                <img src="<?php echo $list[$i]['wr_5']?>" alt="" style="width:100%; border-radius: 5px">
                <div class="title"><?php echo $list[$i]['wr_subject']?></div>
                <div>
                    <b>
                        <small><?php echo number_format($list[$i]['wr_2'])?>원</small>
                    </b>
                </div>
            </a>
        </div>
        <?php
    }
    ?>
</div>