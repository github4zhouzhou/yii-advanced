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
	<title>Select Bank</title>

	<style>
		html, body {
			height:100%;
			font-family: "Microsoft YaHei",sans-serif;
			box-sizing: border-box;
			color: #333333;
			background: url(/pc/images/paymentwall/pix.png);
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

		.w_border {
			border: 1px solid red;
		}

    .fill_explane {
      display: flex;
      padding-top: 20px;
    }

    .fill_explane .card_tit{
      display: inline-block;
      width: 279px;
      text-align: right;
      font-size: 22px;
      margin-right: 20px;
    }
    .fill_explane .card_text{
      display: inline-block;
      width: 752px;
    }

    .fill_explane .form-control {
      height: 24px;
      padding: 6px 12px;
      font-size: 14px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
      -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
      -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
      transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .fill_explane .mycardinput{
      width: 368px;
      height: auto;
    }

    .fill_explane .selector{
      width: 392px;
      height: 38px;
    }

    header{
      height: 70px;
      background: #fff;
      margin-bottom: 30px;
    }

    .wrap{
      width: 1200px;
      margin:0 auto;
    }

  </style>
</head>
<body>
<header>
  <div class="wrap">
    <img src="/pc/images/paymentwall/dlocal.png" style="height: 70px;margin-left: 100px;" alt="logo">
  </div>
</header>
<section class="w_section">
	<div class="w_top">
		<div style="display: flex; justify-content: flex-start;">
			<div class="div_left">
				<ul>
					<li><?= 'Order：' ?><?= $order_id ?></li>
          <li><?= 'Currency：' ?><?= $order_id ?></li>
				</ul>
			</div>
			<div class="div_right">
				<p style="font-size: 14px; color: #333333;"><?= 'Amount：' ?><span style="color: #e63247;font-size: 28px;"><?= $amount ?></span></p>
			</div>
		</div>
	</div>

	<div class="w_middle">
		<p style="color: #555555; padding: 40px 0 0 40px; font-size: 28px;line-height: 5px;"><b><?= 'Personal Information' ?></b></p>
		<form role="form" id="mycard_info" method="post" autocomplete="off" action="/dlocal/pay">
			<input type="hidden" value="<?= $order_id ?>" name="oid">

      <div class="fill_explane">
        <div class="card_tit">
          <label for="expiry"><?= 'Country:' ?></label>
        </div>
        <div class="card_text">
          <select id="country_code" class="form-control selector">
			      <?php foreach(common\models\Video::$country_list as $key => $name) { ?>
                <option value="<?= $key ?>"> <?= $name ?> </option>
			      <?php } ?>
          </select>
        </div>
      </div>

      <div class="fill_explane">
        <div class="card_tit" style="padding-bottom: 10px;">
          <label><?= 'Bank:' ?></label>
        </div>
        <div class="card_text">
          <select id="bank_code" class="form-control selector">
          </select>
        </div>
      </div>

      <div class="fill_explane">
        <div class="card_tit">
          <label for="expiry"><?= 'Full Name:' ?></label>
        </div>
        <div class="card_text">
          <input type="text" id="bc_number" name="bc_number" class="form-control mycardinput" maxlength="32" value="" >
        </div>
      </div>

      <div class="fill_explane">
        <div class="card_tit">
          <label for="expiry"><?= 'Email:' ?></label>
        </div>
        <div class="card_text">
          <input type="text"  id="bc_number" name="bc_number" class="form-control mycardinput" maxlength="32" value="" >
        </div>
      </div>

      <div class="fill_explane">
        <div class="card_tit">
          <label for="expiry"><?= 'ID Number:' ?></label>
        </div>
        <div class="card_text">
          <input type="text"  id="bc_number" name="bc_number" class="form-control mycardinput" maxlength="32" value="" >
        </div>
      </div>

      <div style="display: flex;">
        <input type="submit" id="pay_tips" class="w_btn" value="<?= 'Submit' ?>">
      </div>

		</form>
	</div>
</section>
<footer>

</footer>

<script>
  var countryBankList = {
    AR: [
      {
        code: 'TE',
        desc: 'TEST BANK',
        payment_type: 'Bank Transfer Offline',
        logo: 'https://pay.dlocal.com/views/2.0/images/payments/SI.png'
      },
      {
        code: 'SI',
        desc: 'Santander Rio',
        payment_type: 'Bank Transfer Offline',
        logo: 'https://pay.dlocal.com/views/2.0/images/payments/SI.png'
      },
      {
        code: 'PF',
        desc: 'Pago Fácil',
        payment_type: 'Cash Payment',
        logo: 'https://pay.dlocal.com/views/2.0/images/payments/PF.png'
      }
    ],
    BR: [
      {
        code: 'BL',
        desc:'Boleto',
        payment_type:'Cash Payment',
        logo:'https://pay.dlocal.com/views/2.0/images/payments/BL.png'
      },
      {
        code: 'I',
        desc: 'Itau',
        payment_type: 'Bank Transfer Online',
        logo: 'https://pay.dlocal.com/views/2.0/images/payments/I.png'
      }
    ],
  };
  function banks() {
    var countryCode = document.getElementById("country_code");
    var bankCode = document.getElementById("bank_code");
    countryCode.onchange = function() {
      var index = countryCode.options.selectedIndex;
      bankCode.options.length = 0
      if (index > 0) {
        var bankList = countryBankList[countryCode.options[index].value];
        for(var i = 0; i < bankList.length; i++) {
          bankCode.options.add(new Option(bankList[i]['desc'], bankList[i]['code']));
        }
      }
    }

    bankCode.onchange = function() {
      console.log(bankCode.options[bankCode.options.selectedIndex].value);
    }
  }
  banks()
</script>

</html>