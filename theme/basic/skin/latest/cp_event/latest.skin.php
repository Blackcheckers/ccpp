<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 400;
$thumb_height = 0;

$today = date('Y-m-d', time());
$list = array();
$board = get_board_db($bo_table, true);
$bo_subject = get_text($board['bo_subject']);
$tmp_write_table = $g5['write_prefix'] . $bo_table;
$sql = " select * from {$tmp_write_table} where wr_is_comment = 0 and '$today' between wr_1 and wr_2 order by wr_num limit 0, {$rows} ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) { 
    $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
}

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<?php  if($list_count) : ?>
<div class="event-banner-container swiper-container">
    <div class="swiper-wrapper">
        <?php
        for ($i=0; $i<$list_count; $i++) {
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
        if($thumb['src']) {
            $thumb['alt'] = $list[$i]['wr_subject'];
            $img = $thumb['src'];
        } else {
            $img = G5_IMG_URL.'/no_img.png';
            $thumb['alt'] = '이미지가 없습니다.';
        }
        $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
        ?>
        <li class="swiper-slide event-banner-item">
            <a href="<?php echo $list[$i]['wr_link1']?>" target="_blank" class="event-banner-link">
                <div class="image-container">
                    <?php echo $img_content; ?>
                </div>
            </a>
        </li>
        <?php }  ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<script src="https://unpkg.com/fast-average-color/dist/index.min.js"></script>
<script>
    $(document).ready(function(){
        var mySwiper = new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
    window.addEventListener('load', function() {
            var fac = new FastAverageColor();
            var container = document.querySelectorAll('.image-container');
            // console.log(container.length);
            for(i=0; i<container.length; i++){
                var target = container[i];
                var color = fac.getColor(target.querySelector('img'));
                target.style.backgroundColor = color.rgba;
                target.style.color = color.isDark ? '#fff' : '#000';
            }

            // {
            //     error: null,
            //     rgb: 'rgb(255, 0, 0)',
            //     rgba: 'rgba(255, 0, 0, 1)',
            //     hex: '#ff0000',
            //     hexa: '#ff0000ff',
            //     value: [255, 0, 0, 255],
            //     isDark: true,
            //     isLight: false
            // }
        }, false);
</script>
<?php endif; ?>
