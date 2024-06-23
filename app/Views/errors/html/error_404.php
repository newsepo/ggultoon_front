<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= lang('Errors.pageNotFound') ?>
    </title>

    <style>
        @import url("/assets/fonts/kr/NanumSquareNeo.css");

        body,
        html {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            margin: 0px;
            padding: 0px;
        }

        h1,
        p,
        button {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .wrap {
            width: 263px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            margin-top: -50px;
        }

        .wrap>img {
            display: block;
            width: 44px;
            height: 44px;
            margin-bottom: 1rem;
        }

        .wrap h1 {
            display: block;
            width: 100%;
            text-align: center;
            font-family: 'NanumSquareNeo';
            font-size: 24px;
            line-height: 120%;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #222;
        }

        .wrap .bottom_wrap,
        .wrap .bottom_wrap>p {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            letter-spacing: -0.5px;
            gap: 4px;
        }

        .wrap .bottom_wrap>p>span {
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .wrap .bottom_wrap>a {
            display: block;
            box-sizing: border-box;
            color: #222;
            padding: 11px 1rem;
            border-radius: 0.5rem;
            background-color: #FFE143;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            margin-top: 24px;
            line-height: 120%;
            letter-spacing: -0.5px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wrap">
            <img src="/assets/images/kr/icon/404.png" alt="">
            <h1>길을 잃으셨나요...?</h1>

            <div class="bottom_wrap">
                <p>
                    <span class="Text-md">존재하지 않는 페이지예요.</span>
                    <span class="Text-md">꿀툰 홈으로 이동하고 다양한 콘텐츠를 만나보세요!</span>
                </p>
                <a href="/" class="Text-md">꿀툰 홈으로 가기</a>
            </div>

            <!-- <p>
                <?php if (ENVIRONMENT !== 'production'): ?>
                    <?= nl2br(esc($message)) ?>
                <?php else: ?>
                    <?= lang('Errors.sorryCannotFind') ?>
                <?php endif ?>
            </p> -->
        </div>
    </div>
</body>

</html>