<link rel="stylesheet" href="https://www.coupang.com/resources/20220215104055/np/css/productReview.ko_KR.css">
<style>
    .content-block{
        text-align: left;
        margin-bottom: 30px;
        padding: 0 15px;
        font-size: 16px;
        line-height: 1.5;
        color: #000;
    }

    .content-block p{
        color: #333;
    }

    .content-block.summary{
        font-size: 20px;
    }

    .block-title{
        margin-bottom: 10px;
    }

    .text-center{
        text-align: center;
    }

    .imagebox{
        margin-bottom: 20px;
    }

    .content-block ul{
        padding: 0 !important;
    }

    .content-block li{
        list-style: none;
    }

    .content-block .sdp-review__average__gallery__list li{
        display: inline-block !important;
        list-style: none !important;
    }

    .content-block .product-review img{
        max-width: none !important;
    }

    .sdp-review__highlight__positive,
    .sdp-review__highlight__critical{
        width: 50%;
        margin-right: 0 !important;
        padding-right: 50px !important;
        padding-top: 50px;
    }

    .sdp-review__average__summary__section{
        width: 50%;
        margin-right: 0 !important;
        padding-right: 30px;
        margin-top: 20px;
        float: left;
    }

    .sdp-review__article__list{
        padding-bottom: 30px;
    }

    .sdp-review__article__order,
    .sdp-review__average__gallery,
    .sdp-review__article__page,
    .sdp-review__article__list__help,
    .sdp-review__highlight__positive__helpful,
    .sdp-review__highlight__critical__helpful{
        display: none !important;
    }

    .essentialinfo table{
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
    }

    .essentialinfo table td,
    .essentialinfo table th{
        border: 1px solid #ccc;
        padding: 5px;
        padding: 5px 10px;
        word-break: keep-all;
    }

</style>

<div class="content-block image">
    <div class="text-center imagebox">
        <a href="">
            <img src="<?= $view['wr_5']?>" alt="">
        </a>
    </div>
</div>
<div class="content-block summary text-center">
    쿠팡 인기상품 <strong><?= $view['subject']?></strong> 입니다.<br>
    이 상품은 쿠팡 <?= $view['ca_name']?>카테고리 <?= $view['wr_6']?>위 입니다.<br>
    <strong><?= $view['subject']?></strong>의 상세정보는 아래 본문에서 확인 가능합니다.<br>
    상품별 추천순위, 판매가격, 배송비, 로켓배송 가능여부, 상품사진을 확인 하실 수 있습니다.<br>
</div>
<div class="content-block price">
    <h3 class="block-title">판매가격</h3>
    <hr>
    <p>
        가격은 <b><?= number_format($view['wr_2']) ?></b>원 입니다.<br>
        (아래 링크에서 현재 가격을 확인 하세요.)<br>
        <a href="<?= ($view['wr_link1']) ?>" target="_blank">현재 가격보기</a>
    </p>
</div>
<div class="content-block roket">
    <h3 class="block-title">배송비, 로켓배송</h3>
    <hr>
    <p>
        <?php
        $strRokect = $view['wr_3'] ? '로켓배송이 가능합니다.' : '아쉽게도 로켓배송을 하지 않습니다.';
        $strFreeShipping = $view['wr_4'] ? '무료배송' : '유료배송';
        ?>
        <?= $strFreeShipping ?> 상품이며 <?= $strRokect ?><br>
        배송비, 로켓배송 가능 여부가 변경될 수 있으니 아래 링크에서 확인하세요.<br>
        <a href="<?= ($view['wr_link1']) ?>" target="_blank">배송비, 로켓배송보기</a>
    </p>
</div>
<!--<div class="content-block detail">-->
<!--    <h3 class="block-title">상품 상세정보</h3>-->
<!--    <hr>-->
<!--    <p>-->
<!--        추가적인 상품정보, 상품사진 및 구매후기는 아래 상품정보 상세보기에서 확인 가능합니다.<br>-->
<!--        <a href="--><?//= ($view['wr_link1']) ?><!--" target="_blank">상품정보 상세보기</a>-->
<!--    </p>-->

<!--</div>-->
<div class="content-block review">
<!--    <h3 class="block-title">구매후기</h3>-->
<!--    <hr>-->
<!--    <p>-->
<!--        추가적인 상품정보, 상품사진 및 구매후기는 아래 상품정보 상세보기에서 확인 가능합니다.<br>-->
<!--        <a href="--><?//= ($view['wr_link1']) ?><!--" target="_blank">구매후기 더 보기</a>-->
<!--    </p>-->
    <?= $templateData['review']; ?>
</div>
<div class="content-block essentialinfo">
    <?= $templateData['essentialInfo']); ?>
</div>
<!--<div class="content-block article">-->
<!--    <h3 class="block-title">관련링크</h3>-->
<!--    <hr>-->
<!--    <p>-->
<!--    <ul>-->
<!--        <li><a href="" target="_blank">링크1</a></li>-->
<!--        <li><a href="" target="_blank">링크1</a></li>-->
<!--        <li><a href="" target="_blank">링크1</a></li>-->
<!--    </ul>-->
<!--    </p>-->
<!--</div>-->
<div class="text-center" style="margin-bottom: 20px;">
    <a href="<?php echo $view['wr_link1']?>" target="_blank" rel="noopener noreferrer" class="product-link">상세정보 보기</a>
</div>
<div class="content-block notice text-center">
    * 본 게시글은 쿠팡파트너스 활동을 통해 일정액의 수수료를 제공받고 있습니다.<br>
    * 최종게시일(<?php echo date("Y.m.d H:i", strtotime($view['wr_datetime'])) ?>) 기준으로 상품 및 기타 내용이 변동될 수 있습니다.
</div>