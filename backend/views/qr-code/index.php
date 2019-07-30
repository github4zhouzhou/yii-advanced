<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title> $title </title>
    <link rel="stylesheet" href="/css/pay.css?v=3">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script src="/js/jquery.qrcode.min.js"></script>

</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>
    </h1>

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="money">0.08</div>
        <div class="paybtn" style="display: none;"><a href="https://qr.alipay.com/tsx08115bqtjebvcygizwd3"
                                                      id="alipaybtn" class="btn btn-primary"
                                                      target="_blank">启动支付宝App支付</a></div>
        <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
            <div data-role="qrPayImg" class="qrcode-img-area">
                <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;"></div>
                <div style="position: relative;display: inline-block;">
                    <img id="show_qrcode" width="300" height="210"
                         src="data:image/png;base64,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"
                         style="display: block; width: 310px; height: 270px;">
                    <img onclick="$('#use').hide()" id="use" src="/pc/safecode/logo_alipay.png"
                         style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -20px">

                    <div id="qrcode" style="display: none;">
                        <canvas width="200" height="200"></canvas>
                    </div>
                    <canvas id="imgCanvas" width="310" height="270" style="display: none;"></canvas>
                </div>
            </div>


        </div>
        <div class="payweixinbtn" style="display: none;"><a href="https://qr.alipay.com/tsx08115bqtjebvcygizwd3"
                                                            target="_blank" id="downloadbtn" class="btn btn-primary">1.先保存二维码到手机</a>
        </div>

        <div class="payweixinbtn" style="display: none;padding-top: 10px"><a href="weixin://" class="btn btn-primary">2.打开微信，扫一扫本地图片</a>
        </div>

        <div class="iospayweixinbtn" style="display: none;">1.长按上面的图片然后"存储图像"</div>
        <div class="iospayweixinbtn" style="display: none;padding-top: 10px"><a href="weixin://scanqrcode"
                                                                                class="btn btn-primary">2.打开微信，扫一扫本地图片</a>
        </div>


        <div class="time-item" style="padding-top: 10px">
            <div class="time-item" id="msg"><h1>扫码后，务必<font color="red">准确</font>填入金额</h1></div>
            <div class="time-item"><h1>订单:76e1fa2c550b1e0ee033fc9807f04c21</h1></div>
            <strong id="hour_show"><s id="h"></s>0时</strong>
            <strong id="minute_show"><s></s>01分</strong>
            <strong id="second_show"><s></s>48秒</strong>
        </div>

        <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p id="showtext">打开支付宝 [扫一扫]</p>
            </div>
        </div>


        <div class="tip-text">
        </div>


    </div>
    <div class="foot">
        <div class="inner" style="display:none;">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在支付宝扫一扫中选择“相册”即可</p>
            <p></p>
        </div>
    </div>
</div>

<script type="text/javascript">

    var myTimer;
    var strcode = 'https://qr.alipay.com/tsx08115bqtjebvcygizwd3';

    function timer(intDiff) {
        myTimer = window.setInterval(function () {
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                qrcode_timeout();
                clearInterval(myTimer);
            }
            intDiff--;

            if (strcode != "") {
                checkdata();
            }

        }, 2000);
    }

    function checkdata() {
        $.post(
            "/pay/getresult",
            {
                transaction_id: "76e1fa2c550b1e0ee033fc9807f04c21",
            },
            function (data) {
                if (data.code > 0) {
                    window.clearInterval(timer);
                    $("#show_qrcode").attr("src", "/images/pay_ok.png");
                    $("#use").remove();
                    $("#money").text("支付成功");
                    $("#msg").html("<h1>即将返回商家页</h1>");
                    if (isMobile() == 1) {
                        $(".paybtn").html('<a href="' + data.url + '" class="btn btn-primary">返回商家页</a>');
                        setTimeout(function () {
                            // window.location = data.url;
                            location.replace(data.url)
                        }, 3000);
                    } else {
                        $("#msg").html("<h1>即将<a href='" + data.url + "'>跳转</a>回商家页</h1>");
                        setTimeout(function () {
                            // window.location = data.url;
                            location.replace(data.url)
                        }, 3000);
                    }

                }
            }
        );
    }

    function qrcode_timeout() {
        $('#show_qrcode').attr("src", "/images/qrcode_timeout.png");
        $("#use").hide();
        $('#msg').html("<h1>请刷新本页</h1>");

    }

    function isWeixin() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return 1;
        } else {
            return 0;
        }
    }

    function isMobile() {
        var ua = navigator.userAgent.toLowerCase();
        _long_matches = 'googlebot-mobile|android|avantgo|blackberry|blazer|elaine|hiptop|ip(hone|od)|kindle|midp|mmp|mobile|o2|opera mini|palm( os)?|pda|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino|maemo|fennec';
        _long_matches = new RegExp(_long_matches);
        _short_matches = '1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-';
        _short_matches = new RegExp(_short_matches);
        if (_long_matches.test(ua)) {
            return 1;
        }
        user_agent = ua.substring(0, 4);
        if (_short_matches.test(user_agent)) {
            return 1;
        }
        return 0;
    }

    //本地生成二维码
    function showCodeImage() {
        var any = '1';
        var qrcode = $('#qrcode').qrcode({
            text: 'https://qr.alipay.com/tsx08115bqtjebvcygizwd3',
            width: 200,
            height: 200,
        }).hide();
        //添加文字
        var outTime = '过期时间：2018-09-27 18:09:36';//过期时间
        var canvas = qrcode.find('canvas').get(0);
        var oldCtx = canvas.getContext('2d');
        var imgCanvas = document.getElementById('imgCanvas');
        var ctx = imgCanvas.getContext('2d');
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, 310, 270);
        ctx.putImageData(oldCtx.getImageData(0, 0, 200, 200), 55, 28);
        //ctx.stroke = 3;
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        ctx.font = "15px Arial";
        ctx.fillStyle = '#00c800';
        ctx.strokeStyle = '#00c800'
        ctx.fillText(outTime, imgCanvas.width / 2, 242);
        ctx.strokeText(outTime, imgCanvas.width / 2, 242);

        var about = '过期后请勿支付，不自动到账';
        ctx.fillText(about, imgCanvas.width / 2, 260);
        ctx.strokeText(about, imgCanvas.width / 2, 260);

        if (any > 0) {
            ctx.fillStyle = 'red';
            ctx.strokeStyle = 'red'
            var about = '请支付 0.08 元,否则不能自动到账';
            ctx.fillText(about, imgCanvas.width / 2, 10);
            ctx.strokeText(about, imgCanvas.width / 2, 10);
        }
        imgCanvas.style.display = 'none';
        $('#show_qrcode').attr('src', imgCanvas.toDataURL('image/png')).css({
            width: 310, height: 270
        });
        // $('#downloadbtn').attr('href', imgCanvas.toDataURL('image/png'));
    }

    $().ready(function () {
        //默认5分钟过期
        timer("300");
        var istype = "1";
        var suremoney = "1";
        var uaa = navigator.userAgent;
        var isiOS = !!uaa.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isMobile() == 1) {
            if (isWeixin() == 1 && istype == 2) {
                //微信内置浏览器+微信支付
                $("#showtext").text("长按二维码识别");
            } else {
                //其他手机浏览器+支付宝支付
                if (isWeixin() == 0 && istype == 1) {
                    $(".paybtn").attr('style', '');
                    var goPay = '<span id="goPay"> <span>';
                    //给A标签中的文字添加一个能被jQuery捕获的元素
                    $('#alipaybtn').append(goPay);
                    //模拟点击A标签中的文字
                    $('#goPay').click();

                    $('#msg').html("<h1>支付完成后，请返回此页</h1>");
                    $(".qrcode-img-wrapper").remove();
                    $(".tip").remove();
                    $(".foot").remove();

                    //$(location).attr('href', 'wxp://f2f11up9HqKzQaCoqDCNwhW7PovEWnIJPR7D');
                } else {
                    if (isWeixin() == 0 && istype == 2) {
                        //其他手机浏览器+微信支付
                        //IOS的排除掉
                        if (isiOS) {
                            // showCodeImage();

                            $('.iospayweixinbtn').attr('style', 'padding-top: 15px;');
                        } else {
                            $(".payweixinbtn").attr('style', 'padding-top: 15px;');
                        }
                        $("#showtext").html("请保存二维码到手机<br>微信扫一扫点右上角-从相册选取");
                    }
                }
            }
        }


        if (isiOS) {
            $('#show_qrcode').css({width: 310, height: 310});
        } else {
            var show_expire_time = '1538042976';
            if (show_expire_time != '0') {
                if (document.getElementById("imgCanvas") && document.getElementById("imgCanvas").getContext) {
                    try {
                        showCodeImage();
                    } catch (error) {
                        $('#show_qrcode').attr('src', "https://www.kuaizhan.com/common/encode-png?large=true&data=HTTPS://QR.ALIPAY.COM/FKX00580HX4OWRNJU9AFEC");
                    }
                } else {
                    $('#show_qrcode').attr('src', "https://www.kuaizhan.com/common/encode-png?large=true&data=HTTPS://QR.ALIPAY.COM/FKX00580HX4OWRNJU9AFEC");
                }
            } else {
                $('#show_qrcode').attr('src', "https://www.kuaizhan.com/common/encode-png?large=true&data=HTTPS://QR.ALIPAY.COM/FKX00580HX4OWRNJU9AFEC");
            }
        }

    });
    //
</script>

</body>
</html>
