<?php
include 'common.php';
include_once(G5_LIB_PATH.'/latest.lib.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>쿠쿠팡팡</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <div class="container">
        <h2 class="text-center" style="margin-top: 70px; margin-bottom: 30px">검색어를 입력하세요</h2>
        <div class="btn-group mb-3" role="group" aria-label="Basic outlined">
            <a href="./search.php" class="btn btn-outline-primary">쿠팡검색</a>
            <a href="./search2.php" class="btn btn-outline-primary">사이트내검색</a>
        </div>
        <iframe src="https://coupa.ng/bI1dDK" width="100%" height="36" frameborder="0" scrolling="no" style="margin-bottom: 20px"></iframe>
        <?php echo latestNew('theme/search', 'product|식품', 100, 100);?>
        <?php echo latestNew('theme/search', 'product|생활용품', 100, 100);?>
        <?php echo latestNew('theme/search', 'product|주방용품', 100, 100);?>
    </div>
    <div class="text-center" style="margin-bottom: 20px;">
        <hr>
        <small class="text-muted">본사이트는 쿠팡파트너스 api를 이용해 제작 했습니다. <br> 쿠팡파트너스 활동을 통해 일정액의 수수료를 제공받고 있습니다.</small>
    </div>
</body>
</html>