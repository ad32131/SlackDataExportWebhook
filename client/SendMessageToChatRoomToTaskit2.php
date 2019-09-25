<?php
	header("Access-Control-Allow-Origin: *");	
	header("Access-Control-Allow-Headers: *");
	header("Access-Control-Allow-Methods: *");

	function addUserToTaskit($postMsg){
				try{
					$contents = "AddMessageChatRoom Start\n";
					$doCount = 0;
					$postMsgArray   = json_decode($postMsg,TRUE);
					if( json_last_error() != JSON_ERROR_NONE ){
		                                $body="ERROR Data Is Incorrected";
		                                throw new Exception("IMPORT DATA IS INCORRECTED!", 1);
                        		}
				$resultJsonData = array();
				$channelName	= $resultJsonData["classname"];
				foreach($postMsgArray[0]["Data"] as $dataArray){
					$doCount = $doCount + 1;
					$contents = $contents.$channelName.":".$dataArray["text"]." - textAdd\n<br/>";
					

				}
				$resultJsonData["IFN"] = $postMsgArray[0]["IFN"];
				$resultJsonData["Result"] = "OK";
				$resultJsonData["doCount"] = $doCount;
				$resultJsonData["contents"] = $contents;
	                        $resultJsonData["TenantName"] = "TaskIT";
				$resultJsonData["Data"] = $postMsgArray[0]["Data"];
				$ch = curl_init($postMsgArray[0]["ReturnURL"]);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"AccessKey: ".$postMsgArray[0]["AccessKey"]));
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($resultJsonData));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response  = curl_exec($ch);
				echo $response;
				curl_close($ch);
				}catch(Exception $e){
			$resultJsonData = array();
                        $resultJsonData["IFN"] = $postMsgArray[0]["IFN"];
                        $resultJsonData["Result"] = "NG";
                        $resultJsonData["TenantName"] = "TaskIT";

                        $ch = curl_init($postMsgArray[0]["ReturnURL"]);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('AccessKey : '.$postMsgArray[0]["AccessKey"]));
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($resultJsonData));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response  = curl_exec($ch);
                        curl_close($ch);
                }
	}
		$headers = apache_request_headers();
		if( $headers['AccessKey'] == "12345678901234567890"){
			$postMsg = file_get_contents("php://input");
	  		addUserToTaskit($postMsg);
		}else{
		}	
?>    

