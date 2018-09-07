<?php
use yii\web\View;

/**
 * @var View $this
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width; initial-scale=1.0" />
    <title>选择银行</title>
<!--    <link rel="stylesheet" href="/pc/css/paymentwall.css">-->
<!--    <script src="/pc/js/language.js"></script>-->

    <style>
        html, body {
            height:100%;
            font-family: "Microsoft YaHei",sans-serif;
            box-sizing: border-box;
            color: #333333;
            background: url(/pc/images/paymentwall/pix.png) ;
            padding: 20px;
        }

        .w_section {
            width: 1000px;
            margin: 0 auto;
            position: absolute;
            left: 0;
            right: 0;
        }

        .w_top {
            background: #fefefe;
            width:100%;
        }
        .w_top .div_left {
            width: 70%;
        }
        .w_top .div_right {
            width: 29%;
            display: flex;
            justify-content:flex-end;
            align-items:center;
            padding-right: 45px;
        }
        .w_top li {
            list-style: none;
            box-sizing: border-box;
            float: left;
            height: 42px;
            font-size: 14px;
            width: 100%;
            vertical-align: middle;
            color: #5f5f5f;
        }

        .w_middle {
            margin-top: 30px;
            padding: 0 0 10px 0;
            background: #fefefe;
            width: 100%;
        }

        .w_btn {
            color: #fff;
            background: #008be1;
            height: 48px;
            padding:0 100px;
            text-align: center;
            line-height: 48px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            margin: 30px auto;
        }

        input.w_btn:hover {
            background-color: #228bef;
        }

        .w_border {
            border: 1px solid red;
        }
    </style>
</head>
<body>

<section class="w_section">
    <div class="w_top">
        <div style="display: flex; justify-content: flex-start;">
            <div class="div_left">
                <div style=" color: #555555; padding: 0 0 0 40px; line-height: 32px; font-size: 28px;">
                    <p><b><?= '订单信息' ?></b></p>
                </div>
                <ul>
                    <li style="font-size: 18px; color: #333333;"><?= '商户名称：' ?><?= $product ?></li>
                    <li><?= '订单号码：' ?><?= $order_id ?></li>
                    <li><?= '下单时间：' ?><?= $order_time ?></li>
                </ul>
            </div>
            <div class="div_right">
                <p style="font-size: 14px; color: #333333;"><?= '订单金额：' ?><span style="color: #e63247;font-size: 28px;"><?= '￥' . $amount ?></span></p>
            </div>
        </div>
    </div>

    <div class="w_middle">
        <p style="color: #555555; padding: 40px 0 0 40px; font-size: 28px;line-height: 5px;"><b><?= '支付方式' ?></b></p>
        <p style="line-height: 12px; padding: 0 40px; font-size: 14px; color: #9a9a9a"><?= '单日交易限额已银行规定为准' ?></p>
        <form role="form" id="mycard_info" method="post" autocomplete="off" action="/wanvbo/pay">
            <div>
                <div style="display: flex;flex-wrap: wrap; margin: 20px 0 0 60px;">
                    <?php foreach(common\models\Video::$bank_list as $key => $item) { ?>
                        <div style="display: flex;width:33%; justify-content: space-around;">
                            <div style="display: flex; align-items:center; padding-left: 20px; height:60px; width:100%;">
                                <input type="radio" name="bank_id" value="<?= $key ?>">
                                <img style="margin: 20px 10px;" src="/img/bank-small/<?= $key ?>.png"/>
                                <span style="font-size: 16px;"><?= common\models\Video::$bank_name[$key] ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div style="display: flex;">
                    <input type="submit" id="pay_tips" class="w_btn" value="<?= '跳转银行并支付' ?>">
                </div>
            </div>
            <input type="hidden" value="<?= $order_id ?>" name="oid">
        </form>
    </div>
</section>
<footer>

</footer>

</html>