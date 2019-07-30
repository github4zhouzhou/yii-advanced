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
	<title></title>
	<link rel="stylesheet" href="/pc/css/paymentwall.css">
	<script src="/pc/js/language/en.js"></script>
</head>
<body>
<header>
	<div class="wrap">
		<img src="/pc/images/paymentwall/dlocal.png" style="height: 60px;" alt="logo">
	</div>
</header>
<section class="wrap">
	<div class="top">
		<div class="title">
			<p class="fl"><?= Yii::t('app', '订单详情：') ?></p>
		</div>
		<ul class="list clearfix">
			<li><?= 'Amount：' ?><span><?= $amount ?></span></li>
			<li><?= 'Order：' ?><span><?= $order_sn ?></span></li>
			<li><?= 'Currency：' ?><span><?= $currency ?></span></li>
			<li><?= 'Merchant：' ?><span><?= $product ?></span></li>
		</ul>
	</div>

	<div class="cont_bottom">
		<div class="title">
			<?= Yii::t('app', 'Avoda 支付：') ?>
		</div>
		<form role="form" id="mycard_info" method="post" autocomplete="off" action="<?= "/dlocal/pay" ?>">
			<div>
        <div class="fill_explane">
          <div class="card_tit">
            <label for="country_code"><?= 'Country:' ?></label>
          </div>
          <div class="card_text">
            <select id="country_code" name="country_code" class="form-control mycardinput">
				      <?php foreach(common\models\Video::$country_list as $key => $name) { ?>
                  <option value="<?= $key ?>"> <?= $name ?> </option>
				      <?php } ?>
            </select>
          </div>
        </div>
        <div class="fill_explane">
          <div class="card_tit">
            <label for="bank_code"><?= 'Bank:' ?></label>
          </div>
          <div class="card_text">
            <select id="bank_code" name="bank_code" class="form-control mycardinput">
            </select>
          </div>
        </div>
				<div class="fill_explane">
					<div class="card_tit">
						<label for="full_name"><?= 'Full Name:' ?></label>
					</div>
					<div class="card_text">
						<input type="text" id="full_name" name="full_name" class="form-control mycardinput" maxlength="16" value="" >
					</div>
					<div style="clear: both"></div>
				</div>
				<div class="fill_explane">
					<div class="card_tit" >
						<label for="email"><?= 'Email:' ?></label>
					</div>
					<div class="card_text">
						<input type="text" id="email" name="email" class="form-control mycardinput" maxlength="32" value="" >
					</div>
					<div style="clear: both"></div>
				</div>
				<div style="clear: both;"></div>
				<div class="fill_explane">
					<div class="card_tit">
						<label for="id_number"><?= 'ID Number:' ?></label>
					</div>
					<div class="card_text">
						<input type="text"  id="id_number" name="id_number" class="form-control mycardinput" maxlength="32" value="" >
					</div>
				</div>
			</div>
			<div class="put_send_btn">

				<input type="submit" id="pay_tips" class="btn" value="<?= Yii::t('app', '确认提交') ?>">
				<div class="nomal_text" id="after_send"> <?= Yii::t('app', '交易處理中，請稍等') ?><span id="dote">..........</span><span style="color:red"><?= Yii::t('app', '提醒您！請勿重複送出交易') ?>。</span>
				</div>
			</div>
			<input type="hidden" value="<?= $token ?>" name="token">
		</form>
	</div>
</section>
<footer>

</footer>
<script src="/pc/js/jquery.js"></script>
<script src="/pc/js/validate.js"></script>
<script src="/pc/js/avodapay.js"></script>
</html>