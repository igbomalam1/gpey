<?php
    require_once("../autoloader.php");
    require_once("../../core/helpers/vendor/autoload.php");

    $headers = apache_request_headers();
    $response = array();
    $controller = new ApiAccess;
    date_default_timezone_set('Africa/Lagos');

    $email = $_GET["email"];
    $reference = $_GET["transactionReference"] ?? $_GET["reference"] ?? "";

    if(!$reference){
        $msg = 'Server Error: No reference supplied';
        header("Location: ../../mobile/home/fund-wallet?msg=$msg");
        exit();
    }

    $check=$controller->verifyNovacRef($email,$reference);

    if($check["status"] == "success"):
        $userid = $check["userid"];
        $userbalance = $check["balance"];
        $charges = (float) $check["charges"];
        $servicename = "Wallet Topup";
        $amountFromNovac = (float) $check["amount"];

        if($amountFromNovac > 2500){ $amounttosave = $amountFromNovac - ($amountFromNovac * ($charges/100)) - 100; }
        else{ $amounttosave = $amountFromNovac - ($amountFromNovac * ($charges/100)); }

        $result = $controller->recordNovacTransaction($userid,$servicename,"Wallet funding of N{$amountFromNovac} via Novac.",$amounttosave,$userbalance,$reference,"0");
        $msg = "Wallet Funding Of N{$amounttosave} Successful. Your Transaction Reference Is $reference.";

        $controller->sendEmailNotification($servicename,$msg,$email);

        header("Location: ../../mobile/home/homepage?msg=$msg");
        exit();
    else:
        $msg = "Error: " .$check["msg"];
        header("Location: ../../mobile/home/homepage?msg=$msg");
        exit();
    endif;
?>
