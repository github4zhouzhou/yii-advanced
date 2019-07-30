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
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= $title ?></title>

	<style>
		html, body {
			height:100%;
			font-family: "Microsoft YaHei",sans-serif;
			box-sizing: border-box;
			color: #333333;
			background: url(/pc/images/paymentwall/pix.png);
		}

		.r_section {
			margin-top: 10px;
			width: 100%;
		}





		.r_middle {
			margin-top: 15px;
			padding: 5px 0 5px 0;
			background: #fefefe;
			width: 100%;
		}

		.w_input {
			margin: 0 10px 0 10px;
			height: 30px;
			width: 100%;
			line-height: 32px;
			font-size: 32px;
		}

		input::-webkit-input-placeholder{
			color: #868686;
		}

		input {
			outline:medium;
			background-color: transparent;
			border: none;
		}

		input:hover {
			outline:medium;
			background-color: transparent;
			border: none;
		}

		input:focus{
			outline:medium;
			background-color: transparent;
			border: none;
		}

		.w_btn {
			color: #fff;
			background: #008be1;
			height: 42px;
			width: 100%;
			padding:0 100px;
			text-align: center;
			line-height: 32px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			cursor: pointer;
			margin: 30px 10px;
		}

		input.w_btn:hover {
			background-color: #228bef;
		}

		input.w_btn:disabled {
			background-color: #ddd;
		}

		.w_border {
			border: 1px solid red;
		}

	</style>
</head>
<body>
<section class="r_section">

	<div class="r_middle">
		<p align="center">客戶平台賬號（轉賬時需填寫）</p>
    <div class="r_middle">
      <input class="w_input" readonly style="text-align:center;" type="text" id="p_order" value="<?= $order ?>" />
    </div>

	</div>

  <div style="display: flex;">
    <input class="w_btn" type="submit" id="pay" onclick="onClick('<?= $url ?>')" value="<?= $btn_tip ?>">
  </div>



</section>
<footer>

</footer>

<script>
  function onClick(url) {
    console.log('url', url)
    let promoLinkEle = document.getElementById("p_order");
    const info = promoLinkEle.value;
    console.log('info', info)
    promoLinkEle.setSelectionRange(0,info.length);
    promoLinkEle.focus();
    try{
      document.execCommand("copy",false);
    }catch(e){
      console.log('e', e)
    }

    window.location.href=url;
  }
</script>

</html>