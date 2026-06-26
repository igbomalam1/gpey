<?php
	
	class AccountAccess extends Controller{

		protected $model;

		public function __construct(){
			$this->model=new Account;
		}

		public function verifyAdminLogin(){
			$data=extract($_POST);
			$result=$this->model->verifyAdminAccount($username,$password);
			$username=strip_tags($username);
			if($result == 0){return 0;}
		    elseif($result == 1){return 1;}
		    elseif($result == 2){ return 2;}
		    else{return 3;} 
		}
		    
 

		//Register/Create User Account
		public function registerUser(){
			extract($_POST);
			if(!isset($_POST["referal"])){$referal="";}

			//Clean Input
			$fname=strip_tags($fname); $lname=strip_tags($lname); $email=strip_tags($email); $phone=strip_tags($phone);
			$state=strip_tags($state); $account=strip_tags($account); $referal=strip_tags($referal); $transpin=strip_tags($transpin);
			
			$check=$this->model->registerUser($fname,$lname,$email,$phone,$password,$state,$account,$referal,$transpin);
			return $check;
		}

		//Login User Account
		public function loginUser(){
			extract($_POST);
			$phone=strip_tags($phone);
			$check=$this->model->loginUser($phone,$password);
			return $check;
		}

		//Recover User Account
		public function recoverUserLogin(){
			extract($_POST);
			$email=strip_tags($email);
			$check=$this->model->recoverUserLogin($email);
			return $check;
		}

		//Recover User Account
		public function verifyRecoveryCode(){
			extract($_POST);
			$email=strip_tags($email);
			$code=strip_tags($code);
			$check=$this->model->verifyRecoveryCode($email,$code);
			return $check;
		}

		//Recover Seller Account
		public function updateUserKey(){
			extract($_POST);
			$email=strip_tags($email);
			$code=strip_tags($code);
			$check=$this->model->updateUserKey($email,$code,$password);
			return $check;
		}

	}

?>