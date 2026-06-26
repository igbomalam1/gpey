<?php

	class SubscriberModel extends Model{

		//----------------------------------------------------------------------------------------------------------------
		// Account & Profile Management
		//----------------------------------------------------------------------------------------------------------------
 
		
		//Record Site Traffic
		public function recordTraffic(){
			if(isset($_COOKIE['loginId'])){
				if(!isset($_COOKIE['loginVisit'])){
					$loginId=(float) base64_decode($_COOKIE['loginId']);
					$loginState=base64_decode($_COOKIE['loginState']);
					$visitDate=time();

					$dbh=self::connect();
					$sql="INSERT INTO uservisits (user,state,visitTime) VALUES (:u,:s,:t)";
					$queryC = $dbh->prepare($sql);
					$queryC->bindParam(':u',$loginId,PDO::PARAM_INT);
					$queryC->bindParam(':s',$loginState,PDO::PARAM_STR);
					$queryC->bindParam(':t',$visitDate,PDO::PARAM_STR);
					$queryC->execute();

					setcookie("loginVisit", "loginVisit", time() + (86400 * 30), "/");
				}
			}
		}

		//Record Last Activity
		public function recordLastActivity($id){
			$id = (float) $id;
			$date = date("Y-m-d H:i:s");
			$dbh=self::connect();

			//Check User Last Login

			$sqlA="SELECT token FROM userlogin WHERE user = $id ORDER BY id DESC LIMIT 1";
			$queryA = $dbh->prepare($sqlA);
	    	$queryA->execute();
	      	$resultA=$queryA->fetch(PDO::FETCH_OBJ);

			//Validate User Login token
			$curentUserToken = $_SESSION["loginAccToken"];
			$userToken = $resultA->token;

			if($curentUserToken <> $userToken){
				return 1; //Logout User Reponse Code
			}

	    	$sql="UPDATE subscribers SET sLastActivity=:a WHERE sId = $id";
			$queryC = $dbh->prepare($sql);
			$queryC->bindParam(':a',$date,PDO::PARAM_STR);
	    	$queryC->execute();

			return 0;
	    }


	 public function upgradeUserKyc($userId,$kyc,$createdOn){
			$dbh=self::connect();
			$c="UPDATE subscribers SET sKYC=:rb,sKycDate=:date WHERE sId=$userId";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':rb',$kyc,PDO::PARAM_STR);
					$queryC->bindParam(':date',$createdOn,PDO::PARAM_STR);
					$queryC->execute();

            return 1;
		}

	

		public function updateUserVirtualAccount($userId,$wema_name,$wema,$ref,$kyc,$createdOn,$bvn){
			$dbh=self::connect();
			$c="UPDATE subscribers SET sBankName=:bn,sBankNo=:bno,sVirtualAccountRef=:var, sKYC=:rb,sKycDate=:date WHERE sId=$userId";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':bn',$wema_name,PDO::PARAM_STR);
					$queryC->bindParam(':bno',$wema,PDO::PARAM_STR);
					$queryC->bindParam(':var',$ref,PDO::PARAM_STR);
					$queryC->bindParam(':rb',$kyc,PDO::PARAM_STR);
					$queryC->bindParam(':date',$createdOn,PDO::PARAM_STR);
					$queryC->execute();
					
					
					$obj = new Account;

				//Get API Details
				$d=$this->getApiConfiguration();
				$monifyStatus = $this->getConfigValue($d,"monifyStatus");
				$monifyApi = $this->getConfigValue($d,"monifyApi");
				$monifySecrete = $this->getConfigValue($d,"monifySecrete");
				$monifyContract = $this->getConfigValue($d,"monifyContract");
				$result=$this->getProfileInfo($userId);
				$obj->createVirtualBankAccount2($userId,$result->sFname,$result->sLname,$result->sPhone,$result->sEmail,$monifyApi,$monifySecrete,$monifyContract,$bvn);
				$obj->createVirtualBankAccount3($userId,$result->sFname,$result->sLname,$result->sPhone,$result->sEmail,$monifyApi,$monifySecrete,$monifyContract,$bvn);
				

            return 1;
		}
		
		
		public function bvnVerify($bvn,$bvn_mobile,$accessToken){
		
			$url = 'https://api.monnify.com/api/v1/vas/bvn-details-match';
			
			//var_dump($url,$bvn,$accessToken);die;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
											"bvn": "'.$bvn.'",
                                             "name": "TEST NAME",
                                             "dateOfBirth": "20-Apr-1987",
                                             "mobileNo": "'.$bvn_mobile.'"
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

	//var_dump($value);die;

		 $rec=array();
		   if($value["requestSuccessful"] == true){
		       
			   $rec['customer_bvn_dob']  = $value["responseBody"]["dateOfBirth"];
				$rec['customer_bvn']    = $value["responseBody"]["bvn"];
				$rec['customer_bvn_mobile']    = $value["responseBody"]["mobileNo"];
				$rec['customer_bvn_match']   = $value["responseBody"]["name"]["matchStatus"];
				
				if($rec['customer_bvn_mobile'] == "FULL_MATCH")
				{
					$rec['bvn_validated']   = true;	
	
				}else{
				$rec['bvn_validated']   = false;	
				}
				
				$rec['message']=$value["responseMessage"];	
			
			//var_dump($rec);die;
			}else{
				
				$rec['bvn_validated']   = false;
				if($value["responseCode"] == 99){
				$rec['message']=$value["responseMessage"];	
				}
				
				
				}

		     return $rec;
		
		
	    }		//Record Last Activity
		public function bvnUpgradeValidate($url2,$bvn,$accessToken){
			//var_dump("show info".$url2,$bvn,$accessToken);die;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "PUT",
				CURLOPT_POSTFIELDS => 
									'{
											"bvn": "'.$bvn.'"
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

		var_dump($value);die;
		   $rec=array();
		   if($value["requestSuccessful"] == true){
		        $rec['customer_name']  = $value["responseBody"]["customerName"];
				$rec['customer_bvn']    = $value["responseBody"]["bvn"];
				$rec['customer_account_reference']   = $value["responseBody"]["accountReference"];
				$rec['customer_account_name']   = $value["responseBody"]["accountName"];
				$rec['customer_email']   = $value["responseBody"]["customerEmail"];
				$rec['bvn_validated']   = true;
			}else{
				$rec['bvn_validated']   = false;
				}

		     return $rec;
		
		
	    }


		//Profile Info
		public function getProfileInfo($id){
			$id = (float) $id;
			$dbh=self::connect();
	    	$sql="SELECT * FROM subscribers WHERE sId = $id";
			$queryC = $dbh->prepare($sql);
	    	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_OBJ);

			//Count Total Referal ForThe User
			$refCheck="Select COUNT(sId) AS refCount FROM subscribers WHERE sReferal=:ref";
			$queryR = $dbh->prepare($refCheck);
			$queryR->bindParam(':ref',$result->sPhone,PDO::PARAM_STR);
			$queryR->execute();
			$resultR=$queryR->fetch(PDO::FETCH_OBJ);
			$refCount=(float) $resultR->refCount;
			$result = (object) array_merge( (array)$result, array( 'refCount' => $refCount ) );
			
		
			return $result;
		}


		//Update Profile Password
		public function updateProfileKey($id,$oldKey,$newKey){
			
			$dbh=self::connect();
			$id=(float) $id;
			$hash=substr(sha1(md5($oldKey)), 3, 10);
			$hash2=substr(sha1(md5($newKey)), 3, 10);

			$c="SELECT sPass FROM subscribers WHERE sPass=:p AND sId=$id";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':p',$hash,PDO::PARAM_STR);
	     	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_ASSOC);

	      	if($queryC->rowCount() > 0){
	          
	          $sql="UPDATE subscribers SET sPass=:p WHERE sId=$id";
			  $query = $dbh->prepare($sql);
			  $query->bindParam(':p',$hash2,PDO::PARAM_STR);
			  $query->execute();
			  return 0;
	      	}
	      	else{return 1;}
			
		}

		//Update Seller Profile Password
		public function updateTransactionPin($id,$oldKey,$newKey){
			
			$dbh=self::connect();
			$id=(float) $id;

			$c="SELECT sPin FROM subscribers WHERE sPin=:p AND sId=$id";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':p',$oldKey,PDO::PARAM_STR);
	     	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_ASSOC);

	      	if($queryC->rowCount() > 0){
	          
	          $sql="UPDATE subscribers SET sPin=:p WHERE sId=$id";
			  $query = $dbh->prepare($sql);
			  $query->bindParam(':p',$newKey,PDO::PARAM_STR);
			  $query->execute();
			  return 0;
	      	}
	      	else{return 1;}
			
		}

		//Disable User Pin
		public function disableUserPin($id,$oldPin,$status){
			
			$dbh=self::connect();
			$id=(int) $id;
			$status=(int) $status;

			$c="SELECT sPin FROM subscribers WHERE sPin=:p AND sId=$id";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':p',$oldPin,PDO::PARAM_STR);
	     	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_ASSOC);

	      	if($queryC->rowCount() > 0){
	          
	          $sql="UPDATE subscribers SET sPinStatus=:s WHERE sId=$id";
			  $query = $dbh->prepare($sql);
			  $query->bindParam(':s',$status,PDO::PARAM_STR);
			  $query->execute();
			  return 0;
	      	}
	      	else{return 1;}
			
		}

		//----------------------------------------------------------------------------------------------------------------
		// Email Verification Management
		//----------------------------------------------------------------------------------------------------------------
		//Update Seller Profile Password
		public function updateEmailVerificationStatus($id){
			
			$dbh=self::connect();
			$id=(float) $id;
			$verCode = mt_rand(1000,9999);

			$sql="UPDATE subscribers SET sRegStatus=0,sVerCode=$verCode WHERE sId=$id";
			$query = $dbh->prepare($sql);
			$query->execute();

			$_SESSION["verification"]='YES';

			return 0;
			
		}
		//----------------------------------------------------------------------------------------------------------------
		// Airtime Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Network
		public function getNetworks(){
			$dbh=self::connect();
			$sql = "SELECT * FROM networkid ORDER BY networkid ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Get Airtime Discount
		public function getAirtimeDiscount(){
			$dbh=self::connect();
			$sql = "SELECT * FROM airtime a, networkid b WHERE a.aNetwork=b.nId";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}


		//----------------------------------------------------------------------------------------------------------------
		// Recharge Car Pin Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get Recharge Pin Discount
		public function getRechargePinDiscount(){
			$dbh=self::connect();
			$sql = "SELECT * FROM airtimepinprice a, networkid b WHERE a.aNetwork=b.networkid";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Data Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Data Plans
		public function getDataPlans(){
			$dbh=self::connect();
			$sql = "SELECT * FROM dataplans a, networkid b WHERE a.datanetwork = b.nId ORDER BY a.pId ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Data Pin Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Data Plans
		public function getDataPins(){
			$dbh=self::connect();
			$sql = "SELECT * FROM datapins a, networkid b WHERE a.datanetwork = b.nId ORDER BY a.dpId ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		public function getDataPinTokens($id,$ref){
			$dbh=self::connect();
			$id = (int) $id;
			$sql = "SELECT * FROM datatokens WHERE sId=$id AND tRef=:ref";
            $query = $dbh->prepare($sql);
			$query->bindParam(":ref",$ref,PDO::PARAM_STR);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Alpha Topup Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Alpha Topup Plans
		public function getAlphaTopupPlans(){
			$dbh=self::connect();
			$sql = "SELECT * FROM alphatopupprice";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Alpha Topup 
		public function recordAlphaTopupOrder($userId,$walletbal,$amount,$amounttopay,$phone,$transref){
			$dbh=self::connect();

			$phone=strip_tags($phone); $amount=strip_tags($amount);

			$oldbalance = $walletbal;
            $newbalance = $oldbalance - $amounttopay;
			$servicename = "Alpha Topup";
    		$servicedesc = "Purchase of {$amount} Alpha Topup at N{$amounttopay} for phone number {$phone}";
			$date=date("Y-m-d H:i:s");
			
			//Transaction Status 2 for alpha topup requests
			$status = 2; 
			$profit = $amounttopay - $amount; 
			

			//Record Transaction
			$sql2 = "INSERT INTO transactions 
			SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d,profit=:pf";
			$query2 = $dbh->prepare($sql2);
			$query2->bindParam(':user',$userId,PDO::PARAM_INT);
			$query2->bindParam(':ref',$transref,PDO::PARAM_STR);
			$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
			$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
			$query2->bindParam(':a',$amounttopay,PDO::PARAM_STR);
			$query2->bindParam(':s',$status,PDO::PARAM_INT);
			$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
			$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
			$query2->bindParam(':d',$date,PDO::PARAM_STR);
			$query2->bindParam(':pf',$profit,PDO::PARAM_STR);
			$query2->execute();

			$lastInsertId = $dbh->lastInsertId();
			if($lastInsertId)
			{
				//Update Account Type & Balance
				$sql3 = "UPDATE subscribers SET sWallet=:bal WHERE sId=:id";
				$query3 = $dbh->prepare($sql3);
				$query3->bindParam(':id',$userId,PDO::PARAM_INT);
				$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
				$query3->execute();
				
				$contact = $this->getSiteSettings();
				$subject="Alpha Topup Request (".$this->sitename.")";
				$message="This is to notify you that there is a new request for Alpha Topup on your website ".$this->sitename.". Order Details : {$servicedesc}";
				$email=$contact->email;
				$check=self::sendMail($email,$subject,$message);
				return 0;
			} 
			else {return 1;}
		}




		//----------------------------------------------------------------------------------------------------------------
		// Upgrade To Agent
		//----------------------------------------------------------------------------------------------------------------
		
		//Upgrade To Agent
		public function upgradeToAgent($userId,$pin,$ref){
			$dbh=self::connect();
			$sql = "SELECT sFname,sLname,sPhone,sType,sWallet,sPin,sReferal FROM subscribers WHERE sId=:id";
            $query = $dbh->prepare($sql);
			$query->bindParam(':id',$userId,PDO::PARAM_INT);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
			$result2 = $this->getSiteSettings();
			$amount = (float) $result2->agentupgrade;
			
			$referal = $results->sPhone;
			$referalname = $results->sFname . " " . $results->sLname;
			$refearedby = $results->sReferal;
			$refbonus = $result2->referalupgradebonus;
			
			if($_SESSION["pinStatus"] == 1 || $_SESSION["pinStatus"] == "1"){$pinstatus = 1;} else{$pinstatus = 0;}
			
			if($results->sPin == $pin || $pinstatus == 1){
				if($results->sType == 2){return 2;}
				else{
					$balance = (float) $results->sWallet;
					if($balance >= $amount){

						
						$oldbalance = $balance;
            			$newbalance = $oldbalance - $amount;
						$servicename = "Account Upgrade";
    					$servicedesc = "Upgraded Account Type To Agent Account.";
						$status = 0;
						$date=date("Y-m-d H:i:s");

						//Record Transaction
						$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query2 = $dbh->prepare($sql2);
						$query2->bindParam(':user',$userId,PDO::PARAM_INT);
						$query2->bindParam(':ref',$ref,PDO::PARAM_STR);
						$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
						$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
						$query2->bindParam(':a',$amount,PDO::PARAM_STR);
						$query2->bindParam(':s',$status,PDO::PARAM_INT);
						$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
						$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
						$query2->bindParam(':d',$date,PDO::PARAM_STR);
						$query2->execute();

						$lastInsertId = $dbh->lastInsertId();
						if($lastInsertId){
							//Update Account Type & Balance
							$sql3 = "UPDATE subscribers SET sType = 2, sWallet=:bal WHERE sId=:id";
							$query3 = $dbh->prepare($sql3);
							$query3->bindParam(':id',$userId,PDO::PARAM_INT);
							$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
							$query3->execute();

							$loginAccount=base64_encode("2");
							setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
							if($refearedby <> ""){
								$this->creditReferalBonus($dbh,$referal,$referalname,$refearedby,$refbonus);
							}
						
							return 0;
						}
						else{return 4;}
						
					}
					else{return 3;}
				}
			}
			else{return 1;}

            return $results;
		}


		//----------------------------------------------------------------------------------------------------------------
		// Upgrade To Vendor
		//----------------------------------------------------------------------------------------------------------------
		
		//Upgrade To Vendor
		public function upgradeToVendor($userId,$pin,$ref){
			$dbh=self::connect();
			$sql = "SELECT sType,sFname,sLname,sPhone,sWallet,sPin,sReferal FROM subscribers WHERE sId=:id";
            $query = $dbh->prepare($sql);
			$query->bindParam(':id',$userId,PDO::PARAM_INT);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
			$result2 = $this->getSiteSettings();
			$amount = (float) $result2->vendorupgrade;

			$referal = $results->sPhone;
			$referalname = $results->sFname . " " . $results->sLname;
			$refearedby = $results->sReferal;
			$refbonus = $result2->referalupgradebonus;

			if($_SESSION["pinStatus"] == 1 || $_SESSION["pinStatus"] == "1"){$pinstatus = 1;} else{$pinstatus = 0;}
			
			if($results->sPin == $pin || $pinstatus == 1){
				if($results->sType == 3){return 2;}
				else{
					$balance = (float) $results->sWallet;
					if($balance >= $amount){

						
						$oldbalance = $balance;
            			$newbalance = $oldbalance - $amount;
						$servicename = "Account Upgrade";
    					$servicedesc = "Upgraded Account Type To Vendor Account.";
						$status = 0;
						$date=date("Y-m-d H:i:s");

						//Record Transaction
						$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query2 = $dbh->prepare($sql2);
						$query2->bindParam(':user',$userId,PDO::PARAM_INT);
						$query2->bindParam(':ref',$ref,PDO::PARAM_STR);
						$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
						$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
						$query2->bindParam(':a',$amount,PDO::PARAM_STR);
						$query2->bindParam(':s',$status,PDO::PARAM_INT);
						$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
						$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
						$query2->bindParam(':d',$date,PDO::PARAM_STR);
						$query2->execute();

						$lastInsertId = $dbh->lastInsertId();
						if($lastInsertId){
							//Update Account Type & Balance
							$sql3 = "UPDATE subscribers SET sType = 3, sWallet=:bal WHERE sId=:id";
							$query3 = $dbh->prepare($sql3);
							$query3->bindParam(':id',$userId,PDO::PARAM_INT);
							$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
							$query3->execute();

							$loginAccount=base64_encode("3");
							setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
							if($refearedby <> ""){
								$this->creditReferalBonus($dbh,$referal,$referalname,$refearedby,$refbonus);
							}
							return 0;
						}
						else{return 4;}
						
					}
					else{return 3;}
				}
			}
			else{return 1;}

            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Referal Bonus
		//----------------------------------------------------------------------------------------------------------------
		
		public function creditReferalBonus($dbh,$referal,$referalname,$refearedby,$refbonus){
			$sql = "SELECT sId,sRefWallet FROM subscribers WHERE sPhone=:phone";
            $query = $dbh->prepare($sql);
			$query->bindParam(':phone',$refearedby,PDO::PARAM_STR);
			$query->execute();
            $result=$query->fetch(PDO::FETCH_OBJ);
			
			if($query->rowCount() > 0){

				//Get User Balance
				$userId= $result->sId;
				$balance = (float) $result->sRefWallet;
				$oldbalance = $balance;
				$amount = (float) $refbonus;
            	$newbalance = $oldbalance + $amount;
				$servicename = "Referral Bonus";
    			$servicedesc = "Referral Bonus Of N{$amount} For Referring {$referalname} ({$referal}). Bonus For Account Upgrade.";
				$status = 0;
				$date=date("Y-m-d H:i:s");
				$ref = "REF-".time();

				//Record Transaction
				$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
				$query2 = $dbh->prepare($sql2);
				$query2->bindParam(':user',$userId,PDO::PARAM_INT);
				$query2->bindParam(':ref',$ref,PDO::PARAM_STR);
				$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
				$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
				$query2->bindParam(':a',$amount,PDO::PARAM_STR);
				$query2->bindParam(':s',$status,PDO::PARAM_INT);
				$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
				$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
				$query2->bindParam(':d',$date,PDO::PARAM_STR);
				$query2->execute();

				$lastInsertId = $dbh->lastInsertId();
				if($lastInsertId){
					//Update Account Type & Balance
					$sql3 = "UPDATE subscribers SET sRefWallet=:bal WHERE sId=:id";
					$query3 = $dbh->prepare($sql3);
					$query3->bindParam(':id',$userId,PDO::PARAM_INT);
					$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
					$query3->execute();
					return 0;
				}
			
			}
		}

		//----------------------------------------------------------------------------------------------------------------
		// Contact Management
		//----------------------------------------------------------------------------------------------------------------
		//Get Site Setting
		public function getSiteSettings(){
			$dbh=self::connect();
			$sql = "SELECT * FROM sitesettings WHERE sId=1";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
            return $results;
		}

		

		//----------------------------------------------------------------------------------------------------------------
		//	Exam Pin Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Exam Pin Provider
		public function getExamProvider(){
			$dbh=self::connect();
			$sql = "SELECT * FROM examid ORDER BY eId ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		//	Electricity Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Electricity Provider
		public function getElectricityProvider(){
			$dbh=self::connect();
			$sql = "SELECT * FROM electricityid ORDER BY provider ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		//	Cable Plan Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Cable Provider
		public function getCableProvider(){
			$dbh=self::connect();
			$sql = "SELECT * FROM cableid ORDER BY cableid ASC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Get Cable Plans
		public function getCablePlans(){
			$dbh=self::connect();
			$sql = "SELECT * FROM cableplans a, cableid b WHERE a.cableprovider=b.cableid";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Transaction Management
		//----------------------------------------------------------------------------------------------------------------
	

		//Get All Transactions
		public function getAllTransaction($userId,$limit){
			$dbh=self::connect();
			$addon="";
			
			if(isset($_GET["search"])){
    			
				$search=(isset($_GET["search"])) ? $_GET["search"] : "";  
				$searchfor = (isset($_GET["searchfor"])) ? $_GET["searchfor"] : ""; 

    			if($search == ""){
        			if($searchfor == "all"){$addon="";}
        			if($searchfor == "wallet"){$addon=" AND b.servicename ='Wallet Credit' ";}
        			if($searchfor == "monnify"){$addon=" AND b.transref LIKE '%MNFY%' ";}
        			if($searchfor == "paystack"){$addon=" AND b.servicedesc LIKE '%Paystack%' ";}
        			if($searchfor == "airtime"){$addon=" AND b.servicename LIKE '%Airtime%' ";}
        			if($searchfor == "data"){$addon=" AND b.servicename LIKE '%Data%' ";}
        			if($searchfor == "cable"){$addon=" AND b.servicename LIKE '%Cable%' ";}
        			if($searchfor == "electricity"){$addon=" AND b.servicename LIKE '%Electricity%' ";}
        			if($searchfor == "exam"){$addon=" AND b.servicename LIKE '%Exam%' ";}
        			if($searchfor == "reference"){$addon=" AND b.transref LIKE :search ";}
    			}
    			else{
        			
        			if($searchfor == "all"){$addon=" AND b.servicedesc LIKE :search";}
        			if($searchfor == "wallet"){$addon=" AND (b.servicedesc LIKE :search AND b.servicename ='Wallet Credit') ";}
        			if($searchfor == "monnify"){$addon=" AND (b.servicedesc LIKE :search AND b.transref LIKE '%MNFY%') ";}
        			if($searchfor == "paystack"){$addon=" AND (b.servicedesc LIKE :search AND b.servicedesc LIKE '%Paystack%') ";}
					if($searchfor == "airtime"){$addon=" AND (b.servicedesc LIKE :search AND b.servicename LIKE '%Airtime%') ";}
        			if($searchfor == "data"){$addon=" AND (b.servicedesc LIKE :search AND b.servicename LIKE '%Data%') ";}
        			if($searchfor == "cable"){$addon=" AND (b.servicedesc LIKE :search AND b.servicename LIKE '%Cable%') ";}
        			if($searchfor == "electricity"){$addon=" AND (a.servicedesc LIKE :search AND b.servicename LIKE '%Electricity%') ";}
        			if($searchfor == "exam"){$addon=" AND (b.servicedesc LIKE :search AND b.servicename LIKE '%Exam%') ";}
        			if($searchfor == "reference"){$addon=" AND b.transref LIKE :search ";}
    			}
			}
			
			$sql = "SELECT a.sFname,a.sPhone,a.sEmail,a.sType,b.* FROM subscribers a, transactions b WHERE a.sId=b.sId ";
			$sql.=$addon." AND a.sId=:id ORDER BY b.date DESC LIMIT $limit, 100";
            $query = $dbh->prepare($sql);
			$query->bindParam(':id',$userId,PDO::PARAM_INT);
            if(isset($_GET["search"])): if($search <> ""): $query->bindValue(':search','%'.$search.'%'); endif; endif;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Verify Transaction Pin
		public function verifyTransactionPin($userId,$transkey){
			$dbh=self::connect();
			
			if(isset($_SESSION["pinStatus"])){
				if($_SESSION["pinStatus"] == 1 || $_SESSION["pinStatus"] == "1"){
					$sql = "SELECT sApiKey,sWallet,sType FROM subscribers WHERE sId=:id";
					$query = $dbh->prepare($sql);
					$query->bindParam(':id',$userId,PDO::PARAM_INT);
					$query->execute();
					$results=$query->fetch(PDO::FETCH_OBJ);
					if($query->rowCount() > 0){return $results;} else{return 1;}
				}
				else{
					$sql = "SELECT sApiKey,sWallet,sType FROM subscribers WHERE sId=:id AND sPin=:p";
					$query = $dbh->prepare($sql);
					$query->bindParam(':id',$userId,PDO::PARAM_INT);
					$query->bindParam(':p',$transkey,PDO::PARAM_STR);
					$query->execute();
					$results=$query->fetch(PDO::FETCH_OBJ);
					if($query->rowCount() > 0){return $results;} else{return 1;}
				}
			}

			return 1;

		}

		//Get Transaction Details
		public function getTransactionDetails($ref){
			$dbh=self::connect();
			$sql = "SELECT * FROM transactions WHERE transref=:ref";
            $query = $dbh->prepare($sql);
			$query->bindParam(':ref',$ref,PDO::PARAM_STR);
            $query->execute();
            $result=$query->fetch(PDO::FETCH_OBJ);
            return $result;
		}


		//----------------------------------------------------------------------------------------------------------------
		// Perform Wallet To Wallet Transfer
		//----------------------------------------------------------------------------------------------------------------
		
		//Perform Wallet Transfer
		public function performWalletTransfer($userId,$email,$amount,$amounttopay,$transref1,$transref2){
			$dbh=self::connect();

			$email=strip_tags($email); $amount=strip_tags($amount);
			$sql = "SELECT sType,sWallet,sPin,sEmail FROM subscribers WHERE sId=:id";
            $query = $dbh->prepare($sql);
			$query->bindParam(':id',$userId,PDO::PARAM_INT);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
			$result2 = $this->getSiteSettings();
			$senderEmail = $results->sEmail;
			$walletcharges= (float) $result2->wallettowalletcharges;
			$amounttopay = $amount + $walletcharges;
			
			$c="SELECT sId,sEmail,sWallet FROM subscribers WHERE sEmail=:e";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':e',$email,PDO::PARAM_STR);
	     	$queryC->execute(); 
	      	$resultC=$queryC->fetch(PDO::FETCH_OBJ);
	      	if($queryC->rowCount() > 0){
	      	    $receiverID = $resultC->sId;
	      	    $receiverEmail = $resultC->sEmail;
	      	    $receiverOldBal = (float) $resultC->sWallet;
	      	    $receiverNewBal = $receiverOldBal + $amount;
	      	    $servicename2 = "Wallet Transfer";
    			$servicedesc2 = "Wallet To Wallet Transfer Of N{$amount} From User {$senderEmail} To {$receiverEmail}. New Balance Is {$receiverNewBal}.";
	      	}
	      	else{return 2;}
		
			if($senderEmail == $receiverEmail || $userId == $receiverID){return 5;}
			$balance = (float) $results->sWallet;
			if($balance >= $amounttopay){

						
						$oldbalance = $balance;
            			$newbalance = $oldbalance - $amounttopay;
						$servicename = "Wallet Transfer";
    					$servicedesc = "Wallet To Wallet Transfer Of N{$amount} To User {$email}. Total Amount With Charges Is {$amounttopay}. New Balance Is {$newbalance}.";
						$status = 0;
						$date=date("Y-m-d H:i:s");

						//Record Transaction
						$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query2 = $dbh->prepare($sql2);
						$query2->bindParam(':user',$userId,PDO::PARAM_INT);
						$query2->bindParam(':ref',$transref1,PDO::PARAM_STR);
						$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
						$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
						$query2->bindParam(':a',$amounttopay,PDO::PARAM_STR);
						$query2->bindParam(':s',$status,PDO::PARAM_INT);
						$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
						$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
						$query2->bindParam(':d',$date,PDO::PARAM_STR);
						$query2->execute();

						$lastInsertId = $dbh->lastInsertId();
						if($lastInsertId){
							//Update Account Type & Balance
							$sql3 = "UPDATE subscribers SET sWallet=:bal WHERE sId=:id";
							$query3 = $dbh->prepare($sql3);
							$query3->bindParam(':id',$userId,PDO::PARAM_INT);
							$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
							$query3->execute();
						}
						else{return 4;}
						
						//Record Transaction
						$sql3 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query3 = $dbh->prepare($sql3);
						$query3->bindParam(':user',$receiverID,PDO::PARAM_INT);
						$query3->bindParam(':ref',$transref2,PDO::PARAM_STR);
						$query3->bindParam(':sn',$servicename2,PDO::PARAM_STR);
						$query3->bindParam(':sd',$servicedesc2,PDO::PARAM_STR);
						$query3->bindParam(':a',$amount,PDO::PARAM_STR);
						$query3->bindParam(':s',$status,PDO::PARAM_INT);
						$query3->bindParam(':ob',$receiverOldBal,PDO::PARAM_STR);
						$query3->bindParam(':nb',$receiverNewBal,PDO::PARAM_STR);
						$query3->bindParam(':d',$date,PDO::PARAM_STR);
						$query3->execute();

						$lastInsertId = $dbh->lastInsertId();
						if($lastInsertId){
							//Update Account Type & Balance
							$sql3 = "UPDATE subscribers SET sWallet=:bal WHERE sId=:id";
							$query3 = $dbh->prepare($sql3);
							$query3->bindParam(':id',$receiverID,PDO::PARAM_INT);
							$query3->bindParam(':bal',$receiverNewBal,PDO::PARAM_STR);
							$query3->execute();
						}
						else{return 4;}
						
						return 0;
						
			}
			else{return 3;}
			
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Perform Referal To Wallet Transfer
		//----------------------------------------------------------------------------------------------------------------
		
		//Upgrade To Agent
		public function performReferralTransfer($userId,$amount,$amounttopay,$transref1,$transref2){
			$dbh=self::connect();

			$amount=strip_tags($amount);

			$sql = "SELECT sType,sWallet,sRefWallet,sPin,sEmail FROM subscribers WHERE sId=:id";
            $query = $dbh->prepare($sql);
			$query->bindParam(':id',$userId,PDO::PARAM_INT);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
			$result2 = $this->getSiteSettings();
			$senderEmail = $results->sEmail;
			$balance = (float) $results->sWallet;
			$refbalance = (float) $results->sRefWallet;
			
			if($refbalance >= $amounttopay){

						//Credit Referal Bonus
						$oldbalance = $balance;
            			$newbalance = $oldbalance + $amount;
						$servicename = "Wallet Transfer";
    					$servicedesc = "Referral To Wallet Transfer Of N{$amount} from referral wallet to main wallet. New Balance Is {$newbalance}.";
						$status = 0;
						$date=date("Y-m-d H:i:s");

						//Record Transaction
						$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query2 = $dbh->prepare($sql2);
						$query2->bindParam(':user',$userId,PDO::PARAM_INT);
						$query2->bindParam(':ref',$transref1,PDO::PARAM_STR);
						$query2->bindParam(':sn',$servicename,PDO::PARAM_STR);
						$query2->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
						$query2->bindParam(':a',$amount,PDO::PARAM_STR);
						$query2->bindParam(':s',$status,PDO::PARAM_INT);
						$query2->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
						$query2->bindParam(':nb',$newbalance,PDO::PARAM_STR);
						$query2->bindParam(':d',$date,PDO::PARAM_STR);
						$query2->execute();

						$refoldbalance = $refbalance;
            			$refnewbalance = $refoldbalance - $amounttopay;
						$servicename = "Referral Debit";
    					$servicedesc = "Referral To Wallet Transfer Of N{$amount} from referral wallet to main wallet. Total Amount With Charges Is {$amounttopay}. New Balance Is {$refnewbalance}.";
						$status = 0;
						$date=date("Y-m-d H:i:s");

						//Record Transaction
						$sql3 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
						$query3 = $dbh->prepare($sql3);
						$query3->bindParam(':user',$userId,PDO::PARAM_INT);
						$query3->bindParam(':ref',$transref2,PDO::PARAM_STR);
						$query3->bindParam(':sn',$servicename,PDO::PARAM_STR);
						$query3->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
						$query3->bindParam(':a',$amounttopay,PDO::PARAM_STR);
						$query3->bindParam(':s',$status,PDO::PARAM_INT);
						$query3->bindParam(':ob',$refoldbalance,PDO::PARAM_STR);
						$query3->bindParam(':nb',$refnewbalance,PDO::PARAM_STR);
						$query3->bindParam(':d',$date,PDO::PARAM_STR);
						$query3->execute();

						

						$lastInsertId = $dbh->lastInsertId();
						if($lastInsertId){
							//Update Account Type & Balance
							$sql3 = "UPDATE subscribers SET sWallet=:bal,sRefWallet=:refbal WHERE sId=:id";
							$query3 = $dbh->prepare($sql3);
							$query3->bindParam(':id',$userId,PDO::PARAM_INT);
							$query3->bindParam(':bal',$newbalance,PDO::PARAM_STR);
							$query3->bindParam(':refbal',$refnewbalance,PDO::PARAM_STR);
							$query3->execute();

							return 0;
						}
						else{return 4;}
						
			}
			else{return 3;}
			
            return $results;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Wallet Funding Management
		//----------------------------------------------------------------------------------------------------------------
		
		

		//Initilize Paystack Payment
		public function initializePayStack($siteurl,$email,$amount){

			$dbh=self::connect();
			$d=$this->getApiConfiguration();
			$key = $this->getConfigValue($d,"paystackApi");
			$$amount = (float) $amount;
			$theresponse = array();

			$email=strip_tags($email);
			$amount=strip_tags($amount);

			$amounttopass = urlencode(base64_encode($amount));
		    $amount = $amount."00";  //Amount
		      //Amount

		    // url to go to after payment
		    $callback_url = $siteurl ."webhook/paystack/index.php?email=$email&ama=$amounttopass";  
			$curl = curl_init();
		    curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode([
				  'amount'=>$amount,
				  'email'=>$email,
				  'callback_url' => $callback_url
				]),
				CURLOPT_HTTPHEADER => [
				  "authorization: Bearer ".$key, //replace this with your own test key
				  "content-type: application/json",
				  "cache-control: no-cache"
				],
			));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    if($err){
		      // there was an error contacting the Paystack API
			  $theresponse["status"]="fail";
			  $theresponse["msg"]=' Curl Returned Error: ' . $err;
		      return $theresponse;
		    }

		    $tranx = json_decode($response, true);

		    if(!$tranx['status']){
		      // there was an error from the API
			  $theresponse["status"]="fail";
			  $theresponse["msg"]='API Returned Error: ' . $tranx['message'];
		      return $theresponse;
		      
		    }

			$theresponse["status"]="success";
			$theresponse["msg"]=$tranx['data']['authorization_url'];
			return $theresponse;

		 }

		//Initialize Novac Payment
		public function initializeNovac($siteurl,$email,$amount){

			$dbh=self::connect();
			$d=$this->getApiConfiguration();
			$key = trim($this->getConfigValue($d,"novacPublicKey"));
			$amount = (float) $amount;
			$theresponse = array();

			$email=strip_tags($email);
			$amount=strip_tags($amount);

			$reference = "REF-" . time() . "-" . mt_rand(1000, 9999);
		    $redirectUrl = $siteurl ."webhook/novac/index.php?email=$email";

            $sqlUser = "SELECT sFname, sLname, sPhone FROM subscribers WHERE sEmail=:e LIMIT 1";
            $queryUser = $dbh->prepare($sqlUser);
            $queryUser->bindParam(':e', $email, PDO::PARAM_STR);
            $queryUser->execute();
            $userInfo = $queryUser->fetch(PDO::FETCH_ASSOC);

            $firstName = $userInfo['sFname'] ?? 'Customer';
            $lastName = $userInfo['sLname'] ?? 'User';
            $phone = $userInfo['sPhone'] ?? '0000000000';

            $siteSettings = $this->getSiteSettings();
            $modalTitle = $siteSettings->sitename ?? "Wallet Funding";

			$payload = [
				  'transactionReference' => $reference,
				  'amount' => $amount,
				  'currency' => 'NGN',
				  'redirectUrl' => $redirectUrl,
				  'checkoutCustomerData' => [
					  'email' => $email,
                      'firstName' => $firstName,
                      'lastName' => $lastName,
                      'phoneNumber' => $phone
				  ],
                  'checkoutCustomizationData' => [
                    'logoUrl' => $siteurl . 'assets/images/logo.png',
                    'paymentDescription' => 'Wallet Funding',
                    'checkoutModalTitle' => $modalTitle
                  ]
			];

			$curl = curl_init();
		    curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.novacpayment.com/api/v1/initiate",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($payload),
				CURLOPT_HTTPHEADER => [
				  "Authorization: Bearer ".$key,
				  "Content-Type: application/json",
				  "Cache-Control: no-cache"
				],
			));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    if($err){
			  $theresponse["status"]="fail";
			  $theresponse["msg"]=' Curl Returned Error: ' . $err;
		      return $theresponse;
		    }

		    $tranx = json_decode($response, true);

		    if(!$tranx['status']){
			  $theresponse["status"]="fail";
			  $theresponse["msg"]='API Returned Error: ' . (isset($tranx['message']) ? $tranx['message'] : json_encode($tranx));
		      return $theresponse;
		    }

			$theresponse["status"]="success";
			$theresponse["msg"]=$tranx['data']['paymentRedirectUrl'];
			return $theresponse;

		 }

		//----------------------------------------------------------------------------------------------------------------
		// NIN Verification
		//----------------------------------------------------------------------------------------------------------------
		
		//Get NIN Pricing
		public function getNinPricing(){
			$dbh=self::connect();
			$sql = "SELECT * FROM nin_pricing WHERE status='On'";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Record NIN Transaction & Debit User
		public function recordNinTransaction($userid,$ref,$slipType,$amount,$oldbalance,$newbalance){
			$dbh=self::connect();
			$userid=(float) $userid;
			$amount=(float) $amount;
			$oldbalance=(float) $oldbalance;
			$newbalance=(float) $newbalance;
			$date=date("Y-m-d H:i:s");
			$status=0;
			$servicename="NIN Verification";
			$servicedesc="NIN $slipType Slip Verification";

			//Debit user wallet
			$sqlD = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
			$queryD = $dbh->prepare($sqlD);
			$queryD->bindParam(':id',$userid,PDO::PARAM_INT);
			$queryD->bindParam(':nb',$newbalance,PDO::PARAM_STR);
			$queryD->execute();

			//Record Transaction
			$sql = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
			$query = $dbh->prepare($sql);
			$query->bindParam(':user',$userid,PDO::PARAM_INT);
			$query->bindParam(':ref',$ref,PDO::PARAM_STR);
			$query->bindParam(':sn',$servicename,PDO::PARAM_STR);
			$query->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
			$query->bindParam(':a',$amount,PDO::PARAM_STR);
			$query->bindParam(':s',$status,PDO::PARAM_INT);
			$query->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
			$query->bindParam(':nb',$newbalance,PDO::PARAM_STR);
			$query->bindParam(':d',$date,PDO::PARAM_STR);
			$query->execute();

			$lastInsertId = $dbh->lastInsertId();
			if($lastInsertId){return 0;}else{return 1;}
		}

		//----------------------------------------------------------------------------------------------------------------
		// General Verification Services (Driver License, Passport, Voter Card, CAC, TIN)
		//----------------------------------------------------------------------------------------------------------------
		
		//Get Verification Pricing
		public function getVerificationPricing($serviceType){
			$dbh=self::connect();
			$sql = "SELECT * FROM verification_pricing WHERE service_type=:st AND status='On'";
            $query = $dbh->prepare($sql);
			$query->bindParam(':st',$serviceType,PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Record Verification Transaction & Debit User
		public function recordVerificationTransaction($userid,$ref,$serviceType,$planName,$amount,$oldbalance,$newbalance){
			$dbh=self::connect();
			$userid=(float) $userid;
			$amount=(float) $amount;
			$oldbalance=(float) $oldbalance;
			$newbalance=(float) $newbalance;
			$date=date("Y-m-d H:i:s");
			$status=0;
			$serviceLabels = [
				"buy_number" => "Buy Virtual Number",
				"buy_logs" => "Buy Logs",
				"boost_socials" => "Boost Socials",
				"bvn" => "BVN Verification",
				"cac_registration" => "CAC Registration"
			];
			$servicename = $serviceLabels[$serviceType] ?? "Verification Service";
			$servicedesc = "$servicename - $planName";

			//Debit user wallet
			$sqlD = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
			$queryD = $dbh->prepare($sqlD);
			$queryD->bindParam(':id',$userid,PDO::PARAM_INT);
			$queryD->bindParam(':nb',$newbalance,PDO::PARAM_STR);
			$queryD->execute();

			//Record Transaction
			$sql = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
			$query = $dbh->prepare($sql);
			$query->bindParam(':user',$userid,PDO::PARAM_INT);
			$query->bindParam(':ref',$ref,PDO::PARAM_STR);
			$query->bindParam(':sn',$servicename,PDO::PARAM_STR);
			$query->bindParam(':sd',$servicedesc,PDO::PARAM_STR);
			$query->bindParam(':a',$amount,PDO::PARAM_STR);
			$query->bindParam(':s',$status,PDO::PARAM_INT);
			$query->bindParam(':ob',$oldbalance,PDO::PARAM_STR);
			$query->bindParam(':nb',$newbalance,PDO::PARAM_STR);
			$query->bindParam(':d',$date,PDO::PARAM_STR);
			$query->execute();

			$lastInsertId = $dbh->lastInsertId();
			if($lastInsertId){return 0;}else{return 1;}
		}

		//----------------------------------------------------------------------------------------------------------------
		// CAC Registration Management
		//----------------------------------------------------------------------------------------------------------------

		//Submit CAC Registration to DB
		public function submitCacRegistration($userId, $ref, $planId, $planName, $amount, $data){
			$dbh=self::connect();
			$date=date("Y-m-d H:i:s");
			$status="pending";
			$sql="INSERT INTO cac_registrations SET
				user_id=:uid,ref=:ref,plan_id=:pid,plan_name=:pn,amount=:amt,
				business_type=:bt,first_choice_name=:fcn,second_choice_name=:scn,
				nature_of_business=:nob,business_address=:ba,
				applicant_name=:an,applicant_email=:ae,applicant_phone=:ap,
				proprietor_name=:prn,proprietor_dob=:prd,proprietor_address=:pra,
				id_type=:idt,id_number=:idn,
				director_details=:dd,share_capital=:sc,shareholder_details=:shd,
				aims_objectives=:ao,trustee_details=:td,
				additional_info=:ai,
				status=:st,created_at=:ca";
			$query=$dbh->prepare($sql);
			$query->bindParam(':uid',$userId,PDO::PARAM_INT);
			$query->bindParam(':ref',$ref,PDO::PARAM_STR);
			$query->bindParam(':pid',$planId,PDO::PARAM_INT);
			$query->bindParam(':pn',$planName,PDO::PARAM_STR);
			$query->bindParam(':amt',$amount,PDO::PARAM_STR);
			$bt=$data['business_type']??'';
			$query->bindParam(':bt',$bt,PDO::PARAM_STR);
			$fcn=$data['first_choice_name']??'';
			$query->bindParam(':fcn',$fcn,PDO::PARAM_STR);
			$scn=$data['second_choice_name']??'';
			$query->bindParam(':scn',$scn,PDO::PARAM_STR);
			$nob=$data['nature_of_business']??'';
			$query->bindParam(':nob',$nob,PDO::PARAM_STR);
			$ba=$data['business_address']??'';
			$query->bindParam(':ba',$ba,PDO::PARAM_STR);
			$an=$data['applicant_name']??'';
			$query->bindParam(':an',$an,PDO::PARAM_STR);
			$ae=$data['applicant_email']??'';
			$query->bindParam(':ae',$ae,PDO::PARAM_STR);
			$ap=$data['applicant_phone']??'';
			$query->bindParam(':ap',$ap,PDO::PARAM_STR);
			$prn=$data['proprietor_name']??'';
			$query->bindParam(':prn',$prn,PDO::PARAM_STR);
			$prd=$data['proprietor_dob']??null;
			if($prd===''){$prd=null;}
			$query->bindParam(':prd',$prd,PDO::PARAM_STR);
			$pra=$data['proprietor_address']??'';
			$query->bindParam(':pra',$pra,PDO::PARAM_STR);
			$idt=$data['id_type']??'';
			$query->bindParam(':idt',$idt,PDO::PARAM_STR);
			$idn=$data['id_number']??'';
			$query->bindParam(':idn',$idn,PDO::PARAM_STR);
			$dd=$data['director_details']??'';
			$query->bindParam(':dd',$dd,PDO::PARAM_STR);
			$sc=$data['share_capital']??null;
			if($sc===''){$sc=null;}
			$query->bindParam(':sc',$sc,PDO::PARAM_STR);
			$shd=$data['shareholder_details']??'';
			$query->bindParam(':shd',$shd,PDO::PARAM_STR);
			$ao=$data['aims_objectives']??'';
			$query->bindParam(':ao',$ao,PDO::PARAM_STR);
			$td=$data['trustee_details']??'';
			$query->bindParam(':td',$td,PDO::PARAM_STR);
			$ai=$data['additional_info']??'';
			$query->bindParam(':ai',$ai,PDO::PARAM_STR);
			$query->bindParam(':st',$status,PDO::PARAM_STR);
			$query->bindParam(':ca',$date,PDO::PARAM_STR);
			if($query->execute()){return 0;}else{return 1;}
		}

		//Get CAC orders for a specific user
		public function getUserCacOrders($userId){
			$dbh=self::connect();
			$userId=(float) $userId;
			$sql="SELECT * FROM cac_registrations WHERE user_id=:uid ORDER BY id DESC LIMIT 50";
			$query=$dbh->prepare($sql);
			$query->bindParam(':uid',$userId,PDO::PARAM_INT);
			$query->execute();
			$results=$query->fetchAll(PDO::FETCH_OBJ);
			return $results;
		}

		//Get a single CAC order by ref
		public function getCacOrderByRef($ref){
			$dbh=self::connect();
			$sql="SELECT c.*,s.sFname,s.sLname,s.sEmail,s.sPhone,s.sWallet FROM cac_registrations c JOIN subscribers s ON c.user_id=s.sId WHERE c.ref=:ref";
			$query=$dbh->prepare($sql);
			$query->bindParam(':ref',$ref,PDO::PARAM_STR);
			$query->execute();
			$result=$query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		//----------------------------------------------------------------------------------------------------------------
		// Notification Management
		//----------------------------------------------------------------------------------------------------------------
		
		//Get All Notification
		public function getAllNotification($userType){
			$dbh=self::connect();
			$sql = "SELECT * FROM notifications WHERE msgFor=:ut OR msgFor=3 ORDER BY msgId DESC LIMIT 20";
            $query = $dbh->prepare($sql);
			$query->bindParam(':ut',$userType,PDO::PARAM_INT);
			$query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

		//Get Home Notification
		public function getHomeNotification(){
			$dbh=self::connect();
			$sql = "SELECT * FROM notifications WHERE msgFor=3 ORDER BY msgId DESC LIMIT 1";
            $query = $dbh->prepare($sql);
			$query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
            return $results;
		}
		//----------------------------------------------------------------------------------------------------------------
		// Contact Management
		//----------------------------------------------------------------------------------------------------------------
		

		//Post Form Contact Message
		public function postContact($name,$email,$subject,$msg){
			$dbh=self::connect();

			$name=strip_tags($name); $email=strip_tags($email);
			$subject=strip_tags($subject); $msg=strip_tags($msg);
			
			$sql = "INSERT INTO contact  SET name=:n,contact=:c,subject=:s,message=:m";
            $query = $dbh->prepare($sql);
            $query->bindParam(':n',$name,PDO::PARAM_STR);
            $query->bindParam(':c',$email,PDO::PARAM_STR);
            $query->bindParam(':s',$subject,PDO::PARAM_STR);
            $query->bindParam(':m',$msg,PDO::PARAM_STR);
            $query->execute();

            $lastInsertId = $dbh->lastInsertId();
			if($lastInsertId){return 0;}else{return 1;}
		}

		

		
		


	}

?>