<?php

    /*
        * Route For Subscribers
        * Login
        * Posts
        * Forms
    */
    
    session_start();
    //ini_set("display_errors",1); 
    //error_reporting(E_ALL);

    //Verify User Is Logged In
    $allow=["settings","register","login","get-user-code","verify-user-code","update-user-pass","update-user-pin","save-message"];
    if(!isset($_SESSION["loginId"])){
        $c=0;
        foreach($allow as $g){ if(isset($_GET[$g])){$c=1;} }
        if($c == 0){header("Location: ../"); exit(); }
    }
    
    //Auto Load Classes
    require_once("auto_loader.php");

    //Global Variables
    date_default_timezone_set('Africa/Lagos');
    $protocol = (isset($_SERVER['HTTPS'])) ? "https://" : "http://";
    $assetsLoc = $protocol.$_SERVER['SERVER_NAME']."/".$parentdirectory."mobile/home";
    $siteurl = $protocol.$_SERVER['SERVER_NAME']."/".$parentdirectory;
    $data=""; $data2=""; $data3="" ; $data4 =""; $data5 =""; $data6=""; $data7="";
    $page="homepage.php";
    $title="Home";
    $msg=""; $homemsg="";
    $ur = (isset($_GET["url"])) ? $_GET["url"] : "";
    $link=explode("/",$ur);
    $url=$link[0];
    $arg1= (!empty($link[1])) ? $link[1] : 0; 
    $arg2= (!empty($link[2])) ? $link[2] : 0; 
    $arg3= (!empty($link[3])) ? $link[3] : 0; 
    $next_page = 0;
    $pre_page = 0;
    $current_cat = "";
    $controller="";
    $sitecolor="";
    $pinstatus=0;

    $limit = 100;
	$pageCount = (isset($_GET["page"])) ? $_GET["page"] : 1;
	$pageCount = (float) $pageCount;
    $limit = $pageCount * $limit;
    $limit = $limit - 100;
    $pageCount++;

    if(isset($_GET["settings"])):
        $controller = new Subscriber;
        $data=$controller->getSiteSettings();
    else:
    
        //User Login/Register
        if(isset($_GET["register"])){
            $controller = new AccountAccess;
            echo $controller->registerUser();
            exit();
        }
        elseif(isset($_GET["login"])){
            $controller = new AccountAccess;
            echo $controller->loginUser();
            exit();
        }
        elseif(isset($_GET["get-user-code"])){
            $controller = new AccountAccess;
            echo $controller->recoverUserLogin();
            exit();
        }
        elseif(isset($_GET["verify-user-code"])){
            $controller = new AccountAccess;
            echo $controller->verifyRecoveryCode();
            exit();
        }
        elseif(isset($_GET["update-user-pass"])){
            $controller = new AccountAccess;
            echo $controller->updateUserKey();
            exit();
        }
        else{
            global $controller;
            $controller = new Subscriber;
            $transRef = $controller->generateTransactionRef();
        }

        //Admin Logout
        if($url =="logout"){
            $controller->logoutUser();
        }
        
        //Set Message
        if(isset($_GET["msg"])){
            $msg=$controller->createPopMessage("Alert",$_GET["msg"],"blue");
        }
        

        //Update Login Details
        if(isset($_GET["update-pass"])){
            echo $controller->updateProfileKey();
            exit();
        }


        //Update Login Details
        if(isset($_GET["update-pin"])){
            echo $controller->updateTransactionPin();
            exit();
        }

        //Send Contact Message
        if(isset($_GET["save-message"])){
            echo $controller->postContact();
            exit();
        }

        
        //Verify Email Account
        if(isset($_POST["email-verification"])){
           $msg=$controller->verifyUserMail();
        }

        //Upgrade To Agent
        if(isset($_POST["upgrade-to-agent"])){
            $msg=$controller->upgradeToAgent();
        }
        
         //Update BVN on Monnify
        if(isset($_POST["upgrade-bvn"])){
		$msg=$controller->upgradeBVNMonnify();
        }
        
        //Upgrade To Vendor
        if(isset($_POST["upgrade-to-vendor"])){
            $msg=$controller->upgradeToVendor();
        }

        //Purchase Airtime
        if(isset($_POST["purchase-airtime"])){
            $msg=$controller->purchaseAirtime();
        }

        //Purchase Data
        if(isset($_POST["purchase-data"])){
            $msg=$controller->purchaseData();
        }

        //Purchase Cable TV
        if(isset($_POST["purchase-cable-sub"])){
            $msg=$controller->purchaseCableTv();
        }

        //Purchase Electricity Tokens
        if(isset($_POST["purchase-electricity"])){
            $msg=$controller->purchaseElectricityToken();
        } 

        //PurchaseExam Pin Tokens
        if(isset($_POST["purchase-exam-pin"])){
            $msg=$controller->purchaseExamPinToken();
        }
        
        //Fund With Paystack
        if(isset($_POST["fund-with-paystack"])){
            $msg=$controller->fundWithPaystack();
        }

        //Fund With Novac
        if(isset($_POST["fund-with-novac"])){
            $msg=$controller->fundWithNovac();
        }


        //Perform A Transfer
        if(isset($_POST["perform-transfer"])){
            $msg=$controller->performFundsTransfer();
        }

        //Disable-user-pin
        if(isset($_POST["disable-user-pin"])){
            $msg=$controller->disableUserPin();
        }

        //Purchase Alpha Topup
        if(isset($_POST["purchase-alpha-topup"])){
            $msg=$controller->purchaseAlphaTopup();
        }

        //Purchase Alpha Topup
        if(isset($_POST["purchase-datapin"])){
            $msg=$controller->purchaseDataPin();
        }

        //Fetch The View Of The Page To Be Displayed
        createView($url);
        if($page == "homepage.php"){createView("homepage");}
        if(!isset($_GET["settings"])){$sitecolor = $_SESSION["sitecolor"];}
        if(isset($_SESSION["pinStatus"])){$pinstatus = (int) $_SESSION["pinStatus"];}
        
        //Email Verification
        if(isset($_SESSION["verification"])){
            if($_SESSION["verification"] == "NO" && $page <> "email-verification.php"){
                header("Location: email-verification");
                exit();
            }
            else{unset($_SESSION["verification"]);}
        }

    endif;
    
        function createView($url){
        
            if(file_exists($url.".php")){
                global $title,$data,$data2,$data3,$data4,$data5,$data6,$data7,$page;
                $title=str_replace("-"," ",$url);
                $title=ucwords($title);
                $page=$url.".php";
                $data=getDataIfAny($url);
                if(isset($data[6])){$data7=$data[6];}
                if(isset($data[5])){$data6=$data[5];}
                if(isset($data[4])){$data5=$data[4];}
                if(isset($data[3])){$data4=$data[3];}
                if(isset($data[2])){$data3=$data[2];}
                if(isset($data[1])){$data2=$data[1];}
                if(isset($data[0])){$data=$data[0];}
                
            }
        
        }

        function getDataIfAny($page){
            
            global $next_page, $pre_page,$current_cat,$msg,$homemsg,$limit,$pinstatus;
            $controller = new Subscriber;
            

            switch($page){
                case "homepage":

                    $data=array();
                    $data[0]=$controller->getProfileInfo();
                    $data[1]=$controller->getApiConfiguration();
                    $data[2]=$controller->getSiteSettings();
                    $controller->recordTraffic();
                    $controller->recordLastActivity();

                    $_SESSION["sitecolor"] = $data[2]->sitecolor;
                    $_SESSION["pinStatus"] = $data[0]->sPinStatus;
                    $pinstatus = (int) $data[0]->sPinStatus;

                    if($msg == "" && $data[2]->notificationStatus == "On"){$homemsg=$controller->displayHomeNotification();}

                    if($data[0]->sRegStatus == 1){
                        $controller->logoutUser();
                        exit();
                    }

                    if($data[0]->sRegStatus == 3){
                        $_SESSION["verification"]="NO";
                        header("Location: email-verification");
                        exit();
                    }

                    

                    return $data;
                    return "";
                    break;

               
    
                case "buy-airtime":
                    $data=array();
                    $data[0]=$controller->getNetworks();
                    $data[1]=json_encode($controller->getAirtimeDiscount());
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "recharge-pin":
                    $data=array();
                    $data[0]=$controller->getNetworks();
                    $data[1]=json_encode($controller->getRechargePinDiscount());
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "buy-data":
                    $data=array();
                    $data[0]=$controller->getNetworks();
                    $data[1]=json_encode($controller->getDataPlans());
                    $controller->recordLastActivity();
                    return $data;
                    break;
                 
                case "buy-data-pin":
                    $data=array();
                    $data[0]=$controller->getNetworks();
                    $data[1]=json_encode($controller->getDataPins());
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "view-pins":
                    $data=array();
                    $data[0]=$controller->getDataPinTokens();
                    $controller->recordLastActivity();
                    return $data;
                    break;
                
                 case "update-bvn":
                    $data=array();
                    $data[0]=$controller->getProfileInfo();
                    $data[1]=$controller->getApiConfiguration();
                    $data[2]=$controller->getSiteSettings();
                    $controller->recordLastActivity();
                    return $data;
                    break;


                case "print-data-pin":
                    $data=array();
                    $data[0]=$controller->getDataPinTokens();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "cable-tv":
                        $data=array();
                        $data[0]=$controller->getCableProvider();
                        $data[1]=json_encode($controller->getCablePlans());
                        $controller->recordLastActivity();
                    return $data;
                    break;
        
                case "confirm-cable-tv":
                        $data=array();
                        if(isset($_POST["verify-cable-sub"])): 
                            $data[0]= (object) $_POST; 
                            $data[1]= $controller->validateIUCNumber(); 
                            return $data; 
                        else: header("Location: cable-tv");
                        endif;
                    break;

                case "electricity":
                        $data=array();
                        $data[0]=$controller->getElectricityProvider();
                        $data[1]=$controller->getSiteSettings();
                        $controller->recordLastActivity();
                    return $data;
                    break;
        
                case "confirm-electricity":
                        $data=array();
                        if(isset($_POST["verify-meter-no"])): 
                            $data[0]= (object) $_POST; 
                            $data[1]= $controller->validateMeterNumber();
                            return $data; 
                        else: header("Location: electricity");
                        endif;
                    break;

                case "exam-pins":
                        $data=array();
                        $data[0]=$controller->getExamProvider();
                        $controller->recordLastActivity();
                    return $data;
                    break;
                
                case "alpha-topup":
                    $data=array();
                    $data[0]=$controller->getAlphaTopupPlans();
                    $controller->recordLastActivity();
                    return $data;
                    break;
                    
                case "profile":
                    $data=array();
                    $data[0]=$controller->getProfileInfo();
                    $data[1]=$controller->getSiteSettings();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "fund-wallet":
                    $data=array();
                    $data[0]=$controller->getProfileInfo();
                    $data[1]=$controller->getApiConfiguration();
                    $data[2]=$controller->getSiteSettings();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "transactions":
                    $data=array();
                    $data[0]=$controller->getAllTransaction($limit);
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "transaction-details":
                    $data=array();
                    $data[0]=$controller->getTransactionDetails();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "notifications":
                    $data=array();
                    $data[0]=$controller->getAllNotification();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "pricing":
                    $data=array();
                    $data[0]=$controller->getNetworks();
                    $data[1]=$controller->getAirtimeDiscount();
                    $data[2]=$controller->getDataPlans();
                    $data[3]=$controller->getCableProvider();
                    $data[4]=$controller->getCablePlans();
                    $data[5]=$controller->getElectricityProvider();
                    $data[6]=$controller->getExamProvider();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "transfer":
                    $data=array();
                    $data[0]=$controller->getSiteSettings();
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "contact-us":
                    $data=array();
                    $data[0]=$controller->getSiteSettings();
                    $controller->recordLastActivity();
                    return $data;
                    break;
                
                case "email-verification":
                    $data=array();
                    $data[0] = $controller->getProfileInfo();
                    return $data;
                    break;

                case "nin-verification":
                    $data=array();
                    $data[0]=$controller->getNinPricing();
                    $data[1]=$controller->getProfileInfo();
                    if(isset($_POST["verify-nin"])):
                        $verifyResult = $controller->verifyNIN();
                        $data[2] = $verifyResult;
                        if($verifyResult->status == "error"):
                            $msg = $controller->createPopMessage("Error!!",$verifyResult->msg,"red");
                        endif;
                    endif;
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "buy-number":
                    $data=array();
                    $data[0]=$controller->getServicesPricing("buy_number");
                    $data[1]=$controller->getProfileInfo();
                    if(isset($_POST["purchase-number"])):
                        $ref = $controller->generateTransactionRef();
                        $plan = $_POST["plan"]; $country = $_POST["country"] ?? "";
                        $pricingList = $controller->getServicesPricing("buy_number");
                        $selectedPlan = null;
                        foreach($pricingList as $p){ if($p->id == $plan){ $selectedPlan = $p; break; } }
                        if($selectedPlan):
                            $profile = $data[1]; $wallet = $profile->sWallet;
                            if($wallet >= $selectedPlan->user_price):
                                $newbalance = $wallet - $selectedPlan->user_price;
                                $rc = $controller->recordSvcTransaction($profile->sId,$ref,"buy_number",$selectedPlan->plan_name,$selectedPlan->user_price,$wallet,$newbalance);
                                if($rc == 0):
                                    $data[2] = (object)["status"=>"success","msg"=>"Number purchased successfully","ref"=>$ref,"id_number"=>"+2348XXXX".substr($ref,-4),"email"=>$profile->sEmail,"phone"=>$profile->sPhone];
                                else:
                                    $data[2] = (object)["status"=>"error","msg"=>"Transaction failed. Please try again."];
                                endif;
                            else:
                                $data[2] = (object)["status"=>"error","msg"=>"Insufficient balance. Please fund your wallet."];
                            endif;
                        else:
                            $data[2] = (object)["status"=>"error","msg"=>"Invalid plan selected."];
                        endif;
                        if($data[2]->status == "error"):
                            $msg = $controller->createPopMessage("Error!!",$data[2]->msg,"red");
                        endif;
                    endif;
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "buy-logs":
                    $data=array();
                    $data[0]=$controller->getServicesPricing("buy_logs");
                    $data[1]=$controller->getProfileInfo();
                    if(isset($_POST["purchase-log"])):
                        $ref = $controller->generateTransactionRef();
                        $plan = $_POST["plan"]; $platform = $_POST["platform"] ?? "";
                        $pricingList = $controller->getServicesPricing("buy_logs");
                        $selectedPlan = null;
                        foreach($pricingList as $p){ if($p->id == $plan){ $selectedPlan = $p; break; } }
                        if($selectedPlan):
                            $profile = $data[1]; $wallet = $profile->sWallet;
                            if($wallet >= $selectedPlan->user_price):
                                $newbalance = $wallet - $selectedPlan->user_price;
                                $rc = $controller->recordSvcTransaction($profile->sId,$ref,"buy_logs",$selectedPlan->plan_name,$selectedPlan->user_price,$wallet,$newbalance);
                                if($rc == 0):
                                    $data[2] = (object)["status"=>"success","msg"=>"Log purchased. Check transactions for details","ref"=>$ref,"email"=>$profile->sEmail,"phone"=>$profile->sPhone];
                                else:
                                    $data[2] = (object)["status"=>"error","msg"=>"Transaction failed. Please try again."];
                                endif;
                            else:
                                $data[2] = (object)["status"=>"error","msg"=>"Insufficient balance. Please fund your wallet."];
                            endif;
                        else:
                            $data[2] = (object)["status"=>"error","msg"=>"Invalid plan selected."];
                        endif;
                        if($data[2]->status == "error"):
                            $msg = $controller->createPopMessage("Error!!",$data[2]->msg,"red");
                        endif;
                    endif;
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "boost-socials":
                    $data=array();
                    $data[0]=$controller->getServicesPricing("boost_socials");
                    $data[1]=$controller->getProfileInfo();
                    if(isset($_POST["purchase-boost"])):
                        $ref = $controller->generateTransactionRef();
                        $plan = $_POST["plan"]; $target = $_POST["target_url"] ?? "";
                        $pricingList = $controller->getServicesPricing("boost_socials");
                        $selectedPlan = null;
                        foreach($pricingList as $p){ if($p->id == $plan){ $selectedPlan = $p; break; } }
                        if($selectedPlan):
                            $profile = $data[1]; $wallet = $profile->sWallet;
                            if($wallet >= $selectedPlan->user_price):
                                $newbalance = $wallet - $selectedPlan->user_price;
                                $rc = $controller->recordSvcTransaction($profile->sId,$ref,"boost_socials",$selectedPlan->plan_name,$selectedPlan->user_price,$wallet,$newbalance);
                                if($rc == 0):
                                    $data[2] = (object)["status"=>"success","msg"=>"Boost order submitted. Processing...","ref"=>$ref,"email"=>$profile->sEmail,"phone"=>$profile->sPhone];
                                else:
                                    $data[2] = (object)["status"=>"error","msg"=>"Transaction failed. Please try again."];
                                endif;
                            else:
                                $data[2] = (object)["status"=>"error","msg"=>"Insufficient balance. Please fund your wallet."];
                            endif;
                        else:
                            $data[2] = (object)["status"=>"error","msg"=>"Invalid plan selected."];
                        endif;
                        if($data[2]->status == "error"):
                            $msg = $controller->createPopMessage("Error!!",$data[2]->msg,"red");
                        endif;
                    endif;
                    $controller->recordLastActivity();
                    return $data;
                    break;

                case "bvn":
                    $data=array();
                    $data[0]=$controller->getServicesPricing("bvn");
                    $data[1]=$controller->getProfileInfo();
                    if(isset($_POST["verify-bvn"])):
                        $ref = $controller->generateTransactionRef();
                        $plan = $_POST["plan"]; $bvn_number = $_POST["bvn_number"] ?? "";
                        $pricingList = $controller->getServicesPricing("bvn");
                        $selectedPlan = null;
                        foreach($pricingList as $p){ if($p->id == $plan){ $selectedPlan = $p; break; } }
                        if($selectedPlan):
                            $profile = $data[1]; $wallet = $profile->sWallet;
                            if($wallet >= $selectedPlan->user_price):
                                $newbalance = $wallet - $selectedPlan->user_price;
                                $rc = $controller->recordSvcTransaction($profile->sId,$ref,"bvn",$selectedPlan->plan_name,$selectedPlan->user_price,$wallet,$newbalance);
                                if($rc == 0):
                                    $data[2] = (object)["status"=>"success","msg"=>"BVN verification successful","fullname"=>"John Doe","id_number"=>$bvn_number,"ref"=>$ref,"email"=>$profile->sEmail,"phone"=>$profile->sPhone];
                                else:
                                    $data[2] = (object)["status"=>"error","msg"=>"Transaction failed. Please try again."];
                                endif;
                            else:
                                $data[2] = (object)["status"=>"error","msg"=>"Insufficient balance. Please fund your wallet."];
                            endif;
                        else:
                            $data[2] = (object)["status"=>"error","msg"=>"Invalid plan selected."];
                        endif;
                        if($data[2]->status == "error"):
                            $msg = $controller->createPopMessage("Error!!",$data[2]->msg,"red");
                        endif;
                    endif;
                    $controller->recordLastActivity();
                    return $data;
                    break;

			case "cac-registration":
				$data=array();
				$data[0]=$controller->getServicesPricing("cac_registration");
				$data[1]=$controller->getProfileInfo();
				if(isset($_POST["submit-cac"])):
					$ref = $controller->generateTransactionRef();
					$planId = $_POST["plan"] ?? "";
					$pricingList = $controller->getServicesPricing("cac_registration");
					$selectedPlan = null;
					foreach($pricingList as $p){ if($p->id == $planId){ $selectedPlan = $p; break; } }
					//Fallback: resolve plan from business type if not matched
					if(!$selectedPlan){
						$bt = $_POST["business_type"] ?? "";
						$planMap = [
							"Business Name" => "Business Name / Enterprise Registration",
							"Limited Liability" => "Limited Liability Company Registration",
							"Incorporated Trustee" => "Incorporated Trustees Registration"
						];
						$targetName = $planMap[$bt] ?? "";
						if($targetName){
							foreach($pricingList as $p){
								if($p->plan_name === $targetName){ $selectedPlan = $p; break; }
							}
						}
					}
					if($selectedPlan):
						$profile = $data[1]; $wallet = $profile->sWallet;
						if($wallet >= $selectedPlan->user_price):
							$newbalance = $wallet - $selectedPlan->user_price;
							//Save full form data to cac_registrations table
							$bt = $_POST["business_type"] ?? "";
							$directorDetails = "";
							$shareholderDetails = "";
							$trusteeDetails = "";
							$aimsObjectives = "";
							if($bt == "Limited Liability"){
								$directors = [];
								$numDir = (int)($_POST["num_directors"] ?? 1);
								for($i=1;$i<=$numDir;$i++){
									$dName = $_POST["dir_name_$i"] ?? "";
									$dPhone = $_POST["dir_phone_$i"] ?? "";
									$dEmail = $_POST["dir_email_$i"] ?? "";
									$dDob = $_POST["dir_dob_$i"] ?? "";
									$dAddress = $_POST["dir_address_$i"] ?? "";
									$dIdType = $_POST["dir_id_type_$i"] ?? "";
									$dIdNo = $_POST["dir_id_no_$i"] ?? "";
									if($dName){$directors[]=["name"=>$dName,"phone"=>$dPhone,"email"=>$dEmail,"dob"=>$dDob,"address"=>$dAddress,"id_type"=>$dIdType,"id_no"=>$dIdNo];}
								}
								$directorDetails = json_encode($directors);
								$shareholderDetails = $_POST["shareholder_details"] ?? "";
							}
							if($bt == "Incorporated Trustee"){
								$trustees = [];
								$numTrust = (int)($_POST["num_trustees"] ?? 2);
								for($i=1;$i<=$numTrust;$i++){
									$tName = $_POST["trust_name_$i"] ?? "";
									$tPhone = $_POST["trust_phone_$i"] ?? "";
									$tEmail = $_POST["trust_email_$i"] ?? "";
									$tAddress = $_POST["trust_address_$i"] ?? "";
									if($tName){$trustees[]=["name"=>$tName,"phone"=>$tPhone,"email"=>$tEmail,"address"=>$tAddress];}
								}
								$trusteeDetails = json_encode($trustees);
								$aimsObjectives = $_POST["aims_objectives"] ?? "";
							}
							$formData = [
								"business_type" => $bt,
								"first_choice_name" => $_POST["first_choice_name"] ?? "",
								"second_choice_name" => $_POST["second_choice_name"] ?? "",
								"nature_of_business" => $_POST["nature_of_business"] ?? "",
								"business_address" => $_POST["business_address"] ?? "",
								"applicant_name" => $_POST["applicant_name"] ?? "",
								"applicant_email" => $_POST["applicant_email"] ?? "",
								"applicant_phone" => $_POST["applicant_phone"] ?? "",
								"proprietor_name" => $_POST["proprietor_name"] ?? "",
								"proprietor_dob" => $_POST["proprietor_dob"] ?? "",
								"proprietor_address" => $_POST["proprietor_address"] ?? "",
								"id_type" => $_POST["id_type"] ?? "",
								"id_number" => $_POST["id_number"] ?? "",
								"director_details" => $directorDetails,
								"share_capital" => $_POST["share_capital"] ?? "",
								"shareholder_details" => $shareholderDetails,
								"aims_objectives" => $aimsObjectives,
								"trustee_details" => $trusteeDetails,
								"additional_info" => $_POST["additional_info"] ?? ""
							];
							$cacSaved = $controller->submitCacRegistration($profile->sId,$ref,(int)$selectedPlan->id,$selectedPlan->plan_name,$selectedPlan->user_price,$formData);
							$rc = $controller->recordSvcTransaction($profile->sId,$ref,"cac_registration",$selectedPlan->plan_name,$selectedPlan->user_price,$wallet,$newbalance);
							if($rc == 0 && $cacSaved == 0):
								//Send confirmation email to user
								$subject = "CAC Registration Submitted";
								$settings = $controller->getSiteSettings();
								$siteName = $settings->sitename ?? "GPEY Telecom";
								$companyName = $_POST["first_choice_name"] ?? $_POST["second_choice_name"] ?? "";
								$message = "Dear ".$profile->sFname.",<br><br>Your CAC registration has been received.<br><b>Reference:</b> $ref<br><b>Plan:</b> ".$selectedPlan->plan_name."<br><b>Business:</b> ".$companyName."<br><br>We will process your registration and get back to you within 24-48 hours.<br><br>Thank you for choosing ".$siteName.".";
								$controller->sendEmail($profile->sEmail,$subject,$message);
								$data[2] = (object)["status"=>"success","msg"=>"CAC registration submitted. We'll contact you within 24-48 hours.","ref"=>$ref];
							else:
								$data[2] = (object)["status"=>"error","msg"=>"Transaction failed. Please try again."];
							endif;
						else:
							$data[2] = (object)["status"=>"error","msg"=>"Insufficient balance. Please fund your wallet."];
						endif;
					else:
						$data[2] = (object)["status"=>"error","msg"=>"Invalid plan selected."];
					endif;
					if($data[2]->status == "error"):
						$msg = $controller->createPopMessage("Error!!",$data[2]->msg,"red");
					endif;
				endif;
				$controller->recordLastActivity();
				return $data;
				break;

                case "referrals":
                    $data = array();
                    $data[0] = $controller->getProfileInfo();
                    $data[1]=$controller->getSiteSettings();
                    return $data;
                    break;

                default:
                    return "";
            }
        }

    


?>