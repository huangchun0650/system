<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>訂單補件通知</title> <!-- The title tag shows in email notifications, like Android 4.4. -->


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">

    <!-- CSS Reset : BEGIN -->
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],
        /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }
    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
        .primary {
            background: #f3a333;
        }

        .bg_white {
            background: #ffffff;
        }

        .bg_light {
            background: #fafafa;
        }

        .bg_black {
            background: #000000;
        }

        .bg_dark {
            background: rgba(0, 0, 0, .8);
        }

        .email-section {
            padding: 2.5em;
        }

        /*BUTTON*/
        .btn {
            padding: 20px 25px;
        }

        .btn.btn-primary {
            border-radius: 10px;
            background: #f3a333;
            color: #ffffff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            color: #000000;
            margin-top: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0, 0, 0, .4);
        }

        a {
            color: #f3a333;
        }

        table {}

        /*LOGO*/

        .logo h1 {
            margin: 0;
        }

        .logo h1 a {
            color: #000;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Montserrat', sans-serif;
        }

        /*HERO*/
        .hero {
            position: relative;
        }

        .hero img {}

        .hero .text {
            color: rgba(255, 255, 255, .8);
        }

        .hero .text h2 {
            color: rgba(0, 0, 0, 0.4);
            font-size: 24px;
            margin-bottom: 25;
        }

        .hero .text h3 {
            color: rgba(0, 0, 0, 0.4);
            font-size: 20px;
            margin-bottom: 25;
        }

        /*HEADING SECTION*/
        .heading-section {}

        .heading-section h2 {
            color: #2d2a2a;
            font-size: 28px;
            margin-top: 0;
            line-height: 1.4;
        }

        .heading-section .subheading {
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .heading-section .subheading::after {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: '';
            width: 100%;
            height: 2px;
            background: #f3a333;
            margin: 0 auto;
        }

        .bg_white .heading-section .subheading {
            color: #000000;
        }

        .bg_dark .heading-section .subheading {
            color: rgba(255, 255, 255, .6);
        }

        /* PRODUCT CARD */
        .product-card {
            background: #ffffff;
            max-width: 100%;
            margin: 30px auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 100%; /* 讓圖片寬度填滿容器 */
            height: auto; /* 保持原始高寬比 */
            border-radius: 10px 10px 0 0;
            object-fit: cover; /* 圖片填滿容器，可能裁切部分內容 */
        }

        .product-card p {
            padding: 20px 25px;
            margin: 30px;
        }

        .product-card h2 {
            color: #ffffff;
            font-size: 24px;
            text-align: center;
            padding: 25px;
            margin: 20;
            background-color: #0c6fe8;
            border-radius: 10px;
        }

        /** REASON_CARD **/
        .reason-card {
            background: #f3a333;
            max-width: 100%;
            margin: 30px auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reason-card h3 {
            color: #ffffff;
            font-size: 20px;
            text-align: center;
            padding: 15px;
            margin: 10;
        }

        .icon {
            text-align: center;
        }

        .icon img {}


        /*SERVICES*/
        .text-services {
            padding: 10px 10px 0;
            text-align: center;
        }

        .text-services h3 {
            font-size: 20px;
        }

        /*BLOG*/
        .text-services .meta {
            text-transform: uppercase;
            font-size: 14px;
        }

        /*TESTIMONY*/
        .text-testimony .name {
            margin: 0;
        }

        .text-testimony .position {
            color: rgba(0, 0, 0, .3);
        }

        .text-red {
            color: rgba(202, 27, 27, 0.8);
        }


        /*VIDEO*/
        .img {
            width: 100%;
            height: auto;
            position: relative;
        }

        .img .icon {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            bottom: 0;
            margin-top: -25px;
        }

        .img .icon a {
            display: block;
            width: 60px;
            position: absolute;
            top: 0;
            left: 50%;
            margin-left: -25px;
        }

        /*COUNTER*/
        .counter-text {
            text-align: center;
        }

        .counter-text .num {
            display: block;
            color: #ffffff;
            font-size: 34px;
            font-weight: 700;
        }

        .counter-text .name {
            display: block;
            color: rgba(255, 255, 255, .9);
            font-size: 13px;
        }


        /*FOOTER*/

        .footer {
            color: rgba(255, 255, 255, .5);
        }

        .footer .heading {
            color: #ffffff;
            font-size: 20px;
        }

        .footer ul {
            margin: 0;
            padding: 0;
        }

        .footer ul li {
            list-style: none;
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: rgba(255, 255, 255, 1);
        }


        @media screen and (max-width: 500px) {
            .icon {
                text-align: left;
            }

            .text-services {
                padding-left: 0;
                padding-right: 20px;
                text-align: left;
            }
            .hero .text h1 {
                color: #000000;
                font-size: 20px;
                margin-bottom: 20;
            }

            .hero .text h2 {
                color: rgba(0, 0, 0, 0.4);
                font-size: 18px;
                margin-bottom: 20;
            }

            .hero .text h3 {
                color: rgba(0, 0, 0, 0.4);
                font-size: 16px;
                margin-bottom: 20;
            }

            .product-card {
                background: #ffffff;
                max-width: 100%;
                margin: 30px auto;
                overflow: hidden;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .product-card img {
                width: 100%; /* 讓圖片寬度填滿容器 */
                height: auto; /* 保持原始高寬比 */
                border-radius: 10px 10px 0 0;
                object-fit: cover; /* 圖片填滿容器，可能裁切部分內容 */
            }

            .product-card h2 {
                font-size: 20px; /* Adjust font size for smaller devices */
                padding: 20px; /* Adjust padding for smaller devices */
                color: #ffffff;
                text-align: center;
                padding: 20px;
                margin: 20;
                background-color: #0c6fe8;
                border-radius: 10px;
            }

            .product-card p {
                padding: 20px 20px;
                margin: 20px;
            }
        }
    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
    <center style="width: 100%; background-color: #f1f1f1;">
        <div
            style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <!-- BEGIN BODY -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="margin: auto;">
                <tr>
                    <td class="primary logo" style="padding: 1em 2.5em; text-align: center">
                        <h1><a href="#">易期付</a></h1>
                    </td>
                </tr><!-- end tr -->
                <tr>
                    <td valign="middle" class="hero"
                        style="background-image: url(https://thumb.photo-ac.com/32/32efcf852261b9af9207a0fa1786ae1c_t.jpeg); background-size: cover; height: 400px;">
                        <table>
                            <tr>
                                <td>
                                    <div class="text" style="padding: 0 3em; text-align: center;">
                                        <h1> {!! $greeting !!}</h1>
                                        <h2>{{ $caption }}</h2>
                                        <h3>{{ $directions }}</h3>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr><!-- end tr -->
                <tr>
                    <td class="bg_white">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td class="bg_dark email-section" style="padding: 0 3em; text-align:center;">
                                    <div class="heading-section">
                                        <span class="subheading">以下是您在易期付訂購的商品明細</span>
                                        <div class="product-card">
                                            <img width="100%" src="{{ $productImage }}" />
                                            <div class="heading-section">
                                                <h3>{{ $productName }}</h3>
                                                <h3>{{ $specification }}</h3>
                                                <h3>
                                                    每期 $ <span class="text-red">{{ $installmentPrice }}</span>
                                                    分 <span class="text-red">{{ $installment }}</span> 期
                                                </h3>
                                                <h2>訂單狀態： {{ $orderStatus }}</h2>
                                            </div>
                                            <p><a href="{{ $orderLink }}" class="btn btn-primary">檢視我的訂單</a></p>
                                        </div>
                                    </div>
                                </td>
                            </tr><!-- end: tr -->
                        </table>
                    </td>
                    <tr>
                        <td class="bg_white">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td class="bg_white email-section" style="text-align: center;">
                                        <div class="heading-section">
                                            <span class="subheading">審核結果</span>
                                            <h5>審核時間：{{ $reviewTime }}</h5>
                                            <div class="reason-card">
                                                <div class="heading-section">
                                                    <h3>{{ $supplementReason }}</h3>
                                                </div>
                                            </div>
                                            <div class="text" style="padding: 0 2em; text-align: center;">
                                                <h2> 對於訂單有任何問題或疑慮? </h2>
                                                <h3> 歡迎聯繫客服協助您處理相關問題 </h3>
                                            </div>
                                            <div class="text" style="padding: 20px 20px; text-align: center;">
                                                <p><a href="{{ $customerServiceLink }}" class="btn btn-primary">聯繫客服</a></p>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr><!-- end: tr -->
                            </table>
                        </td>
                    </tr>
                </tr><!-- end:tr -->
            </table>
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="margin: auto;">
                <tr>
                    <td valign="middle" class="primary footer email-section">
                        <table>
                            <tr>
                                <td valign="top" width="50%" style="padding-top: 20px;">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="text-align: center; padding-right: 10px;">
                                                <h3 class="heading">易期付</h3>
                                                <p>提供無卡分期服務</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top" width="50%" style="padding-top: 20px;">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="text-align: center; padding-left: 5px; padding-right: 5px;">
                                                <h3 class="heading">好交貸</h3>
                                                <ul>
                                                    <li><span class="text">提供二胎借款服務</span></li>
                                                    <li><span class="text">+2 392 3929 210</span></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <td valign="top" width="100%">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="text-align: center;">
                                            <p>&copy; 2024 英富開發. All Rights Reserved</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </table>
                    </td>
                </tr><!-- end: tr -->
            </table>
        </div>
    </center>
</body>
</html>
