<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>

<!-- 메인화면 최신글 시작 -->
<?php
//echo latest('theme/cp_event', 'cp_event', 5, 30);
echo latest('theme/product', 'product', 12, 25);
echo latest('theme/basic', 'sharekey', 12, 25);
?>
<!-- 메인화면 최신글 끝 -->

<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>