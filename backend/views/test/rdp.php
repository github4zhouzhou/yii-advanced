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

    /*@media (min-width: 600px) {*/
      /*.r_section {*/
        /*width: 400px;*/
        /*margin: 0 auto;*/
        /*position: absolute;*/
        /*left: 0;*/
        /*right: 0;*/
      /*}*/
    /*}*/

		.r_top {
			background: #fefefe;
			width:100%;
		}

    .r_middle {
      margin-top: 15px;
      padding: 5px 0 5px 0;
      background: #fefefe;
      width: 100%;
    }

    .w_input {
      padding-left: 10px;
      margin: 0 10px 0 10px;
      height: 30px;
      width: 100%;
      line-height: 16px;
      font-size: 16px;
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
	<div class="r_top">
		<div style="padding: 10px 0 0 20px; line-height: 32px; font-size: 24px; color: #686868">
			<p><b><?= $title ?></b></p>
		</div>
    <div style="padding: 0 0 20px 24px; line-height: 10px; color: #868686;">
      <p><?= $pay_type ?></p>
      <p><?= $pay_amount ?></p>
    </div>
	</div>

  <div class="r_middle">
    <form role="form" id="card_info" method="post" autocomplete="off" action="/rdp/pay">
      <input type="hidden" value="<?= $order_id ?>" name="oid">

      <div style="display: flex; color: #868686;">
        <input class="w_input" type="text" oninput="textChange()" id="bc_number" name="bc_number" value="" placeholder="<?= $input_tip ?>">
      </div>

    </form>

  </div>

  <div style="display: flex;">
    <input class="w_btn" type="submit" disabled="true" id="pay" value="<?= $btn_tip ?>">
  </div>


</section>
<footer>
  
</footer>

<script>
  function textChange() {
    var inputVal = document.getElementById("bc_number");
    var payBtn = document.getElementById("pay");
    if (inputVal.value.length > 0) {
      console.log('disable = false')
      payBtn.disabled = false;
    } else {
      console.log('disable = true')
      payBtn.disabled = true;
    }
  }
</script>

</html>