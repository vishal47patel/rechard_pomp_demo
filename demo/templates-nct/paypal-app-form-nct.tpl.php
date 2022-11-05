<?php

/*
	This code is only for web service call only
	for ride payment
*/

require_once "../includes-nct/config-nct.php";
extract($_REQUEST);
$payment_history_id = base64_decode($payment_history_id);

if($payment_history_id <= 0 || !isset($payment_history_id)){
	$_SESSION["msgType"] = disMessage(array(
                        'type' => 'err',
                        'var'  => MSG_SOMETHING_WRONG,
                    ));
	redirectPage(SITE_URL);
	exit;
}else{
    $getData = $db->pdoQuery("SELECT * FROM tbl_payment_history WHERE id = ?",array($payment_history_id));

    if($getData->affectedRows() <= 0){
    	$_SESSION["msgType"] = disMessage(array(
                            'type' => 'err',
                            'var'  => MSG_SOMETHING_WRONG,
                        ));
    	redirectPage(SITE_URL);
    	exit;
    }else{
     	$paypalData = $getData->result();
        /*pri($paypalData);*/
        $amount = $paypalData['amount'];
     	$bookingId = $paypalData['bookingId'];

        $action_cancel = base64_encode($bookingId);

        $notify_url = SITE_URL."notify/";
        if($_SERVER["SERVER_NAME"] == '192.168.100.128' || $_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == 'nct128' )
        {
            $return_url = SITE_URL."notify/";
        }else{
            $return_url = SITE_URL."thankyou/";
        }
        $cancel_url = SITE_URL."failed/".$action_cancel;

    ?>

    <div align="center" style="width:100%;margin-top:30px;">
    	<h1>Please wait, We are connecting to Paypal.... Please do not refresh the page.</h1>
    </div>
    <form name="frm_paypal_service" action="<?php echo PAYPAL_URL; ?>" method="post" id="frm_paypal_service">
        <input type="hidden" name="item_name" value="Ride payment">
        <input type="hidden" name="item_number" value="<?php echo $bookingId; ?>">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?php echo PAYPAL_EMAIL; ?>">
        <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY_CODE; ?>">
        <input type="hidden" name="no_shipping" value="1">
        <input type="image" src="http://www.paypal.com/en_GB/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" title="Make payments with PayPal - it's fast, free and secure!" style="display: none;">
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="rm" value="2">
        <input type="hidden" name="notify_url" value="<?php echo  $notify_url; ?>">
        <input type="hidden" name="return" value="<?php echo  $return_url; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo  $cancel_url; ?>">
        <input type="hidden" name="custom" value="<?php echo $bookingId; ?>">
        <input type="hidden" name="bn" value="NCryptedTechnologies_SP_EC" >
    </form>

    <script type="text/javascript">document.frm_paypal_service.submit();</script>
<?php }
 } ?>