<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
include "Sendmail.php";

$headers = apache_request_headers();
//if( $headers['AccessKey'] == "12345678901234567890"){
if ( 1){
	$postMsg = file_get_contents("php://input");
	
        $postMsg = preg_replace("/\\\\\"/i" ,"\"", $postMsg);
        $postMsg = preg_replace("/\\\\/i" ,"", $postMsg);

	$fp = fopen("UrlSetting.txt","r");
	while( !feof($fp) ) $mail_addr = fgets($fp);
	fclose($fp);


        $postMsgArray   = json_decode($postMsg,TRUE);
	if( $postMsgArray["Result"] == "OK" ){
		echo "100";
		$sendmail = new Sendmail();
		$to=$mail_addr;
		$from="WebHookMessage";
		$subject = $postMsgArray["IFN"];
		$contents = $postMsgArray["doCount"]." Processed<br/>".$postMsgArray["contents"];
		
		$body=$contents;
		$sendmail->send_mail($to, $from, $subject, $body);
	}else{
		echo "400";
                $sendmail = new Sendmail();
                $to="aws@cloud.nurinubi.com";
                $from=$mail_addr;
                $subject = $postMsgArray["IFN"];
                $contents = "Request Do Not Processed";
                $body=$contents;
                $sendmail->send_mail($to, $from, $subject, $body);
	}
	
}else{
}
?>
