<?php
    $dateTime = $dateTime ?? '11월 14일 오전 10시 ~ 11시 (1시간)';
    $description = $description ?? '서비스 안정성 확보를 위한 점검';
?>
<!DOCTYPE html>
<html lang="ko" oncontextmenu="return false;">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">

    <title>
        <?= $clientIp ?>
    </title>
</head>

<style>
    @import url("/assets/fonts/kr/UhBeeSe_hyun.css");


    body,
    html {
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        margin: 0px;
        padding: 0px;
    }

    p {
        letter-spacing: -0.5px;
        margin-bottom: 0px;
        margin-top: 0px;
    }

    .container {
        width: 100%;
        height: 100%;
        min-height: 98vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .wrap {
        max-width: 80%;
        margin-top: -50px;
    }

    .wrap>img {
        display: block;
        width: 44px;
        height: 44px;
        margin: 0 auto;
        margin-bottom: 1rem;
    }

    .wrap>.title {
        display: block;
        width: 100%;
        text-align: center;
        font-family: 'UhBeeSe_hyun';
        font-size: 24px;
        line-height: 120%;
        letter-spacing: -0.5px;
        color: #222;
        margin-bottom: 24px;
    }

    .wrap>p:last-of-type {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        gap: 4px;
        color: #666;
    }

    .wrap>p:last-of-type>span {
        display: block;
        width: 100%;
        text-align: center;
    }

    .wrap .bottom_wrap {
        margin-top: 24px;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        box-sizing: border-box;
        padding-top: 24px;
        gap: 4px;
        border-top: 1px solid #f0f0f0;
    }

    .wrap .bottom_wrap>p {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        width: 100%;
        gap: 2px;
        color: #666;
        font-size: 14px;
    }

    .wrap .bottom_wrap>p>span:first-of-type::before {
        content: '·';
        display: inline-block;
        vertical-align: middle;
        width: 10px;
    }

    .wrap .bottom_wrap>p:last-of-type>span:last-of-type {
        text-decoration: none;
    }
</style>

<body>
    <div class="container">
        <div class="wrap">
            <img src="/assets/images/kr/icon/maintenance.png" alt="">
            <p class="title">꿀툰은 서비스 점검중</p>
            <p>
                <span class="Text-md">꿀꿀하게 해드려서 죄송해요.</span>
                <span class="Text-md">꿀툰은 서비스 안정화를 위해 점검중이에요</span>
                <span class="Text-md">최대한 빨리 작업할게요!</span>
            </p>
            <div class="bottom_wrap">
                <p>
                    <span class="Text-sm">점검일시 : <?= $dateTime ?></span>
                </p>
                <p>
                    <span class="Text-sm">점검내용 : <?= $description ?></span>
                </p>
                <p>
                    <span class="Text-sm">고객지원 : help@ggultoons.com</span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>