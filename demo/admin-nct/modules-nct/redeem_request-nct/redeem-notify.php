<?php
require_once ("../../../includes-nct/config-nct.php");



/*$content = "\n\n-----------------------------------------------------------------------------------\n\n" . date("Y-m-d H:i:s")."\n\n-----------------------------------------------------------------------------------";
foreach ($_REQUEST as $k => $v) {
    $content .= "\n\nkey=" . $k . "======>value=" . $v;
}

$h = fopen("redeem-notify.txt", "a");
$r = fwrite($h, $content);
fclose($h);

$message = SITE_URL."<BR><BR>";
$message .= "<pre>" . print_r($_REQUEST, TRUE);

sendEmailAddress('gaurav.chavda@ncrypted.com', 'Redeem Notify - ' . SITE_NM, $message);
*/
if($_POST){

    list($user_id, $redeem_id, $amount) = preg_split('/__/', $_POST["custom"]);



     if (!empty($user_id) && !empty($redeem_id)) {


        $user_details = $db -> select('tbl_users', array(
            'firstName',
            'email'
        ), array('id' => $user_id)) -> result();

        $redeemArray = array(
            'paymentStatus' => 'redeemed',
            'redeemedAmount'=>$_POST['mc_gross'],
            'redeemedDate'=>date('Y-m-d H:i:s'));


        $db -> update('tbl_redeem_requests', $redeemArray, array('id' => $redeem_id));

        $mailarray = array(
            'greetings' => $user_details['firstName'],
            'USER_EAMIL' => $user_details['email'],
            'TRANSACTION_ID' => $_POST['txn_id'],
            'AMOUNT' => DEFAULT_CURRENCY_SIGN . $_POST['mc_gross'],
            'DATE' => date(PHP_DATE_FORMAT),
            'STATUS' => 'Completed'
        );

        $array = generateEmailTemplate('redeem_succ', $mailarray);

        sendEmailAddress($user_details['email'], $array['subject'], $array['message']);

    }
	
}
	if($_SERVER["SERVER_NAME"] == '192.168.100.71' || $_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == 'nct71')
    {

            $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'Payment status for this transaction is pending. Amount will be added to user paypal once completed.'));
            redirectPage(SITE_ADM_MOD.'redeem_request-nct/');

    }

exit;
?>