<?php
/* eslint-disable */
ob_start();
session_start();
require_once ('DatabaseQueries.php');
require_once ('validationManager.php');
require_once ('FileHandler.php');

class main_work{

    use DatabaseQueries, validationManager, FileHandler;

    function __construct()
    {
        $this->connectToDb();
        $this->callFunctions();

    }
 function callFunctions(){
        if (isset($_GET["option"])) {
            switch ($_GET["option"]){
                case 'register':
                    $this-> register();
                    break;
                case 'pincode':
                    $this-> pincode();
                    break;
                case 'login':
                    $this-> login();
                    break;
                case 'check':
                    $this->check();
                    break;
                case 'deposit':
                    $this->deposit();
                    break;
                case 'profile':
                    $this->profile();
                    break;
                case 'kyc':
                    $this->kyc();
                    break;
                case 'passwords':
                    $this->passwords();
                    break;
                case 'settingpin':
                    $this->settingpin();
                    break;
                case 'report':
                    $this->report();
                    break;
                case 'domestic':
                    $this->domestic();
                    break;
                case 'wire':
                    $this->wire();
                    break;
                case 'self':
                    $this->self();
                    break;
                case 'user':
                    $this->User();
                    break;
                case 'card':
                    $this->card();
                    break;
                case 'loan':
                    $this->loan();
                    break;
                case 'loginAdmin':
                    $this->loginAdmin();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                case 'logouts':
                    $this->logouts();
                    break;
                case 'pending':
                    $this->suspendUser('confirmed');
                    break;
                case 'confirmed':
                    $this->suspendUser('pending');
                    break;
                case 'suspended':
                    $this->suspendedUser('active');
                    break;
                case 'active':
                    $this->suspendedUser('suspended');
                    break;
                case 'delete':
                    $this->deleteUser('delete');
                    break;
                case 'add':
                    $this->addAmount();
                    break;
                case 'remove':
                    $this->removeAmount();
                    break;
                case 'edit':
                    $this->edit();
                    break;
                case 'Processing':
                    $this->cardProcessing('Complete');
                    break;
                case 'Complete':
                    $this->cardProcessing('Processing');
                    break;
                case 'deleteCard':
                    $this->deleteCard('delete');
                    break;
                case 'currencyUpdate':
                    $this->currencyUpdate();
                    break;
                case 'depositProcessing':
                    $this->depositProcessing('Complete');
                    break;
                case 'depositComplete':
                    $this->depositProcessing('Processing');
                    break;
                case 'deleteDeposit':
                    $this->deleteDeposit('delete');
                    break;
                case 'checkProcessing':
                    $this->checkProcessing('Complete');
                    break;
                case 'checkComplete':
                    $this->checkProcessing('Processing');
                    break;
                case 'deleteCheck':
                    $this->deleteCheck('delete');
                    break;
                case 'feeUpdate':
                    $this->feeUpdate();
                    break;
                case 'loanProcessing':
                    $this->loanProcessing('Complete');
                    break;
                case 'loanComplete':
                    $this->loanProcessing('Processing');
                    break;
                case 'deleteLoan':
                    $this->deleteLoan('delete');
                    break;
                case 'localProcessing':
                    $this->localProcessing('Complete');
                    break;
                case 'localComplete':
                    $this->localProcessing('Processing');
                    break;
                case 'deletelocal':
                    $this->deletelocal('delete');
                    break;
                case 'selfProcessing':
                    $this->selfProcessing('Complete');
                    break;
                case 'selfComplete':
                    $this->selfProcessing('Processing');
                    break;
                case 'deleteSelf':
                    $this->deleteSelf('delete');
                    break;
                case 'deleteTicket':
                    $this->deleteTicket('delete');
                    break;
                case 'userProcessing':
                    $this->userProcessing('Complete');
                    break;
                case 'userComplete':
                    $this->userProcessing('Processing');
                    break;
                case 'deleteUserT':
                    $this->deleteUserT('delete');
                    break;
                case 'wallectUpdate':
                    $this->wallectUpdate('');
                    break;
                case 'wireProcessing':
                    $this->wireProcessing('Complete');
                    break;
                case 'wireComplete':
                    $this->wireProcessing('Processing');
                    break;
                case 'deletewire':
                    $this->deletewire('delete');
                    break;
                case 'forgetpassword':
                    $this->forgetpassword();
                    break;
                case 'resetpassword':
                    $this->resetpassword();
                    break;
                case 'editLocal':
                    $this->editLocal();
                    break;
                case 'editDatewire':
                    $this->editDatewire();
                    break;
                case 'editDateself':
                    $this->editDateself();
                    break;
                case 'editDatewireuser':
                    $this->editDatewireuser();
                    break;
                    

            }
        }
    }



    function register(){
        $name= $_SESSION['name']=mysqli_real_escape_string($this->dbConnection, $_POST['name']);
        $lastname= $_SESSION['lastname']=mysqli_real_escape_string($this->dbConnection, $_POST['lastname']);
        $email= $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);
        $phone= $_SESSION['phone']=mysqli_real_escape_string($this->dbConnection, $_POST['phone']);
        $password= $_SESSION['password']=mysqli_real_escape_string($this->dbConnection, $_POST['password']);
        $confirmPassword= $_SESSION['confirmPassword']=mysqli_real_escape_string($this->dbConnection, $_POST['confirmPassword']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);

        $thingsToValidate = [
            $name.'|Name|name|empty',
            $lastname.'|Lastname|lastname|empty',
            $email.'|Email|email|empty',
            $phone.'|Phone|phone|empty',
            $password.'|Password|password|empty',
            $confirmPassword.'|ConfirmPassword|confirmPassword|empty',
            $pincode.'|Pincode|pincode|empty'
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../register.php');
            return;
        }
        if ($password !== $confirmPassword) {
            $_SESSION['formError'] = ['general_error' => ['Password and Confirm Password do not match']];
            header('location:../register.php');
            return;
        }

        $emailUniqueness = $this->checkUniqueValueInDatabase('user', 'email', $email);
       // print_r( $emailUniqueness); die();
        if($emailUniqueness > 0){
            $_SESSION['formError'] = ['general_error'=>['Email Address exists']];
            header('location:../register.php');
            return;
        }
        $user_unique_id = $this->createUniqueID('user', 'user_unique_id');
        $hashedPasword = $this->hasHer($password);
        $current =$this->generateUniqueNumber();
        $saving =$this->generateUniqueNumber();
        $_SESSION['name'] = $name;
        $_SESSION['user_unique_id'] = $user_unique_id;
        $query = "INSERT INTO user (id,name,lastname,email,phone,password,pincode,current,saving,user_unique_id)
         VALUES (null,'".$name."', '".$lastname."','".$email."','".$phone."','".$hashedPasword."','".$pincode."','".$current."','".$saving."','".$user_unique_id."')";

        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../register.php');
            return;
        }
        if ($result){
            $to  = $email;
            $d = date('Y');
            $subject = "Welcome To Coastchartered";
            $message = '
                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                    <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                    <div style="font-size: 14px;">
                    <p>Dear ' . $name . ',</p>
                    <p>Welcome to Coastchartered Bank! We are thrilled to have you as a customer.</p>
                    <p>At Our Bank, we are committed to providing you with exceptional service and helping you achieve your financial goals.</p>
                    <p>If you have any questions or need assistance, please feel free to contact our customer support team at support@coastchartered.com.</p>
                    <p>Thank you for choosing Our Bank!</p>
                    <p>Sincerely,<br>Our Bank Team</p>
					<p style="color:#332E2E">Best Regard<br />
                    coastchartered Team<br />
                    Email: support@coastchartered.com<br /></p>
				
			<div style="background-color:rgb(253, 150, 26);
						float:left;
						width:80%;
						border:1px solid rgb(253, 150, 26);
						border-radius:0px 0px 3px 3px;
						padding-left:10% ;
						padding-right:10% ;
						padding-top:30px ;
						padding-bottom:30px ;
						font-family: \'Roboto\', sans-serif;" class="footer">
                        coastchartered.<br>
				located at 150 Minories,<br>
				Tower, london EC3N,<br>
                United kingdom.
			</div>
			<p style="float:left;
			width:100%;
			text-align:center;
			font-family: \'Roboto Condensed\', sans-serif;
			">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
		</div>
		</body>
		</html>';
            $header = "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
            $retval = @mail($to,$subject, $message, $header);
            if ($retval = true) {
                header("location:../pincode.php?success=Registration was successful");
                // header("location:login.php");
            }else {
                return  'Internal error. Mail fail to send';
            }
            header("location:../pincode.php?success=Registration was successful");
        }
         
          
    }  

    function pincode(){

        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);
        $userId= $_SESSION['userId']=mysqli_real_escape_string($this->dbConnection, $_POST['userId']);

        $thingsToValidate = [
            $pincode.'|Pincode|pincode|empty',
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../pincode.php');
            return;
        } 

        $query = "SELECT pincode FROM user WHERE user_unique_id = '$userId'";
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            return $result['error'];
        }
        $detail = $result['data'];
        if(mysqli_num_rows($detail) > 0) {
            while($row = mysqli_fetch_assoc($detail)){
                $user_pincode = $row['pincode'];
            if ($pincode !== $user_pincode) {
                $_SESSION['formError'] = ['general_error' => ['Incorrect pincode']];
                header('location:../pincode.php');
                return;
                }
            }
            header("location:../user/index.php?success=Register was successful");
        }
    }

    function generateUniqueNumber() {
        $uniqueNumber = uniqid(mt_rand(), true);
        $uniqueNumber = substr(str_replace(".", "", $uniqueNumber), 0, 11);
        return $uniqueNumber;
    }

    function login(){
        $email= $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);
        $password= $_SESSION['password']=mysqli_real_escape_string($this->dbConnection, $_POST['password']);

        $thingsToValidate = [
            $email.'|Email|email|empty',
            $password.'|Password|Passwords|empty'
        ];

        
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false) {
            $_SESSION['formError'] = $this->errors;
            header('location:../login.php');
            return;
         
        }
        $hashedPasword = $this->hasHer($password);
        $calllogin = $this->loginHandler($email,$hashedPasword);
       // print_r( $calllogin); die();


        if ($calllogin['error_code']== 1 ){
            $_SESSION['formError'] = ['general_error'=>[$calllogin['error']]];
            header('location:../login.php');

        }
        $queryResult = $calllogin['data'];
        if(mysqli_num_rows($queryResult) == 1){
            //create the login sessions
            while($row = mysqli_fetch_object($queryResult)){
                $user_unique_id = $row->user_unique_id;
                $name = $row->name;
                $email = $row->email;
                $current = $row->current;
                $saving = $row->saving;
                $Userpincode = $row->pincode;
                $balance = $row->balance;
                $_SESSION['user_unique_id'] = $user_unique_id;
                $_SESSION['name'] = $name;
                $_SESSION['userEmail'] = $email;
                $_SESSION['current'] = $current;
                $_SESSION['saving'] = $saving;
                $_SESSION['Userpincode'] = $Userpincode;
                $_SESSION['balance'] = $balance;
                // $typeOfUser = $row->type_of_user;

            }

            $ass = $this->getsingledetail($user_unique_id);
          //  print_r($ass->status);die();
            $active = $ass->status;
            if($active =='pending'){
                $_SESSION['formError'] = ['general_error' => ['You Account is pending']];
                header('location:../login.php');
                return;
            }





            $query = "INSERT INTO logins (id,user_unique_id)VALUES (null,'".$user_unique_id."')";
            $result = $this->runMysqliQuery($query); 
            if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../register.php');
            return;
            }
            header('location:../pincode.php');
        }else{
            $_SESSION['formError'] = ['general_error'=>['Incorrect Username/Email or Password']];
            header('location:../login.php');
        }
        // header('location:../dashboard.php');

    }

    function processImage() {
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if(getimagesize($_FILES['image']['tmp_name']) !== false) {
                $maxFileSize = 5 * 1024 * 1024; // 5MB (adjust as needed)
                if($_FILES['image']['size'] <= $maxFileSize) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if(in_array($_FILES['image']['type'], $allowedTypes)) {
                        $uploadDir = '../user/uploads/'; 
                        $uploadPath = $uploadDir . basename($_FILES['image']['name']);
                        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                            return $uploadPath;
                        } else {
                            $_SESSION['formError'] = ['general_error' => ['Error moving uploaded file.']];
                        }
                    } else {
                        $_SESSION['formError'] = ['general_error' => ['Invalid file type. Please upload JPEG, PNG, or GIF images only.']];
                    }
                } else {
                    $_SESSION['formError'] = ['general_error' => ['File size exceeds the allowed limit (5MB).']];
                }
            } else {
                $_SESSION['formError'] = ['general_error' => ['Uploaded file is not an image.']];
            }
        } else {
            $_SESSION['formError'] = ['general_error' => ['Error uploading image.']] ;
        }
    
        return false; 
    }
    
    
    function check() {
        $imagePath = $this->processImage();
        if(!$imagePath) {
            header('location:../user/check_deposit.php');
            exit;
        }
    
        $check_id = $this->createUniqueID('DepostCheck','check_id');
        $user_unique_id = $_SESSION['user_unique_id'];
    

        $query = "INSERT INTO DepostCheck (id,check_id,user_unique_id,image)
                  VALUES (null,'".$check_id."','".$user_unique_id."','".$imagePath."')";      
        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../user/check_deposit.php');
            return;
        }
    
        header("location:../user/check_deposit.php?success=check was successful");
    }

    function profile() {
        $imagePath = $this->processImage();
        if(!$imagePath) {
            header('location:../user/profile.php');
            exit;
        }

        $user_unique_id = $_SESSION['user_unique_id'];

        $query = "UPDATE user SET image = '".$imagePath."' WHERE user_unique_id = '$user_unique_id'";
        //print_r($query);die();  
        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../user/profile.php');
            return;
        }
    
        header("location:../user/profile.php?success=check was successful");
    }

    function processImages($inputName) {
        if(isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            if(getimagesize($_FILES[$inputName]['tmp_name']) !== false) {
                $maxFileSize = 5 * 1024 * 1024; // 5MB (adjust as needed)
                if($_FILES[$inputName]['size'] <= $maxFileSize) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if(in_array($_FILES[$inputName]['type'], $allowedTypes)) {
                        $uploadDir = '../user/uploads/'; 
                        $uploadPath = $uploadDir . basename($_FILES[$inputName]['name']);
                        if(move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadPath)) {
                            return $uploadPath;
                        } else {
                            $_SESSION['formError'] = ['general_error' => ['Error moving uploaded file.']];
                        }
                    } else {
                        $_SESSION['formError'] = ['general_error' => ['Invalid file type. Please upload JPEG, PNG, or GIF images only.']];
                    }
                } else {
                    $_SESSION['formError'] = ['general_error' => ['File size exceeds the allowed limit (5MB).']];
                }
            } else {
                $_SESSION['formError'] = ['general_error' => ['Uploaded file is not an image.']];
            }
        } else {
            $_SESSION['formError'] = ['general_error' => ['Error uploading image.']] ;
        }
    
        return false; 
    }



    function kyc() {
        $idnumber= $_SESSION['idnumber']=mysqli_real_escape_string($this->dbConnection, $_POST['idnumber']);
        $date_of_birth= $_SESSION['date_of_birth']=mysqli_real_escape_string($this->dbConnection, $_POST['date_of_birth']);
        $next_of_kin_name= $_SESSION['next_of_kin_name']=mysqli_real_escape_string($this->dbConnection, $_POST['next_of_kin_name']);
        $phone_number= $_SESSION['phone_number']=mysqli_real_escape_string($this->dbConnection, $_POST['phone_number']);
        $next_of_kind_address= $_SESSION['next_of_kind_address']=mysqli_real_escape_string($this->dbConnection, $_POST['next_of_kind_address']);

        $thingsToValidate = [
            $idnumber.'|Idnumber|idnumber|empty',
            $date_of_birth.'|Idnumber|idnumber|empty',
            $next_of_kin_name.'|date of birth|date_of_birth|empty',
            $phone_number.'|phone number|idnumber|empty',
            $next_of_kind_address.'|next of kind address|idnumber|empty',


        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../user/pending-kyc.php');
            return;
        }
        $id_front = $this->processImages('id_front');
        if(!$id_front) {
            header('location:../user/pending-kyc.php');
            exit;
        }
        $id_back = $this->processImages('id_back');
        if(!$id_back) {
            header('location:../user/pending-kyc.php');
            exit;
        }

        $proof_address = $this->processImages('proof_address');
        if(!$proof_address) {
            header('location:../user/pending-kyc.php');
            exit;
        }

        $user_unique_id = $_SESSION['user_unique_id'];

        $query = "UPDATE user SET id_front = '".$id_front."',id_back = '".$id_back."',proof_address = '".$proof_address."',id_number = '".$idnumber."',
        date_of_birth = '".$date_of_birth."',next_of_kin_name = '".$next_of_kin_name."',phone_number = '".$phone_number."',next_of_kind_address = '".$next_of_kind_address."' WHERE user_unique_id = '$user_unique_id'";
        //print_r($query);die();  
        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../user/pending-kyc.php');
            return;
        }
    
        header("location:../user/pending-kyc.php?success=check was successful");
    }

    function getLoggedInUserDetails(){
        $user_unique_id = $_SESSION['user_unique_id'];
        $query = "SELECT * FROM user WHERE user_unique_id = '$user_unique_id'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
           //print_r($result);die();
            return $result;
        }
    }

    function getLoggedInUser(){
        $user_unique_id = $_SESSION['user_unique_id'];
        $query = "SELECT * FROM user WHERE user_unique_id = '$user_unique_id'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            $row = mysqli_fetch_object($result);
            //print_r($row); die();
            return $row;
        }
        // print_r($query); die();

    }

    function allwellect(){
        $UserDetails = [];
        $query = "SELECT * FROM wallect";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                //print_r($row);die();
                $UserDetails[] = $row;
                //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function deposit(){
        $amount= $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $account= $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $cypto_type= $_SESSION['cypto_type']=mysqli_real_escape_string($this->dbConnection, $_POST['cypto_type']);
        $wallet= $_SESSION['wallet']=mysqli_real_escape_string($this->dbConnection, $_POST['wallet']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);


        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $cypto_type.'|Cypto_type|cypto_type|empty',
            $wallet.'|Wallet|wallet|empty',
            $pincode.'|Pincode|pincode|empty',
        ];
        
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false) {
            $_SESSION['formError'] = $this->errors;
            header('location:../user/deposit.php');
            return;
         
        }

        $image = $this->processImage();
        //print_r($image);die();
         if(!$image) {
            header('location:../user/deposit.php');
             exit;
         }

        $Userpincode = $_SESSION['Userpincode'];
        //print_r($Userpincode);die();

        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Pincode']];
            header('location:../user/deposit.php');
            return;
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['name'];
        $date =  date('Y-m-d');



        $deposit_id = $this->createUniqueID('deposit', 'deposit_id');
        $user_unique_id = $_SESSION['user_unique_id'];

        $query = "INSERT INTO deposit (id,deposit_id,amount,account,cypto_type,wallet,proof,Refrence_id,user_unique_id)
        VALUES (null,'".$deposit_id."', '".$amount."','".$account."','".$cypto_type."','".$wallet."','".$image."','".$deposit_id."','".$user_unique_id."')";
        
        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../register.php');
            return;
        }
        if ($result){
            $to  = $email;
            $d = date('Y');
            $subject = "Deposit Notification Coastchartered";
            $message = '
                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                    <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                    <div style="font-size: 14px;">
                    <p>Dear ' . $name . ',</p>
                    <p>We are writing to inform you that You made deposit of At Coastchartered.</p>  

                    <table border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>'.$date.'</td>
                            <td>Deposit</td>
                            <td>$' . $amount . '</td>
                        </tr>
                    </table>
                    <p>If you have any questions about this deposit or your account, please dont hesitate to contact us.</p>
                    <p>Thank you for banking with us.</p>
                    <p>Sincerely,<br>Our Bank Team</p>
					<p style="color:#332E2E">Best Regard<br />
                    coastchartered Team<br />
                    Email: support@coastchartered.com<br /></p>
				
			<div style="background-color:rgb(253, 150, 26);
						float:left;
						width:80%;
						border:1px solid rgb(253, 150, 26);
						border-radius:0px 0px 3px 3px;
						padding-left:10% ;
						padding-right:10% ;
						padding-top:30px ;
						padding-bottom:30px ;
						font-family: \'Roboto\', sans-serif;" class="footer">
                        coastchartered.<br>
				located at 150 Minories,<br>
				Tower, london EC3N,<br>
                United kingdom.
			</div>
			<p style="float:left;
			width:100%;
			text-align:center;
			font-family: \'Roboto Condensed\', sans-serif;
			">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
		</div>
		</body>
		</html>';
            $header = "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
            $retval = @mail($to,$subject, $message, $header);
            if ($retval = true) {
                header("location:../user/deposit.php?success=deposit was successful");
                // header("location:login.php");
            }else {
                return  'Internal error. Mail fail to send';
            }
            header("location:../user/deposit.php?success=deposit was successful");
        }
       header("location:../user/deposit.php?success=deposit was successful");

    }

    function passwords(){

        $oldpassword = $_SESSION['oldpassword']=mysqli_real_escape_string($this->dbConnection, $_POST['oldpassword']);
        $newpassword = $_SESSION['newpassword']=mysqli_real_escape_string($this->dbConnection, $_POST['newpassword']);
        $confirmpassword = $_SESSION['confirmpassword']=mysqli_real_escape_string($this->dbConnection, $_POST['confirmpassword']);


        $thingsToValidate = [
            $oldpassword.'|Oldpassword|oldpassword|empty',
            $newpassword.'|Newpassword|newpassword|empty',
            $confirmpassword.'|Confirmpassword|confirmpassword|empty'
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../user/password.php');
            return;
        }

        if ($newpassword !== $confirmpassword) {
            $_SESSION['formError'] = ['general_error' => ['New Password and Confirm New Password do not match']];
            header('location:../user/password.php');
            return;
        }

        $user_unique_id = $_SESSION['user_unique_id'];
        $hashedPasword = $this->hasHer($newpassword);

        $query = "UPDATE user SET password='".$hashedPasword."' WHERE user_unique_id='".$user_unique_id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/password.php");
            return;
        }

        header ('location:../user/password.php?&success=New_password was updated successfully');

    }

    function settingpin(){

        $oldpin = $_SESSION['oldpin']=mysqli_real_escape_string($this->dbConnection, $_POST['oldpin']);
        $newpin = $_SESSION['newpin']=mysqli_real_escape_string($this->dbConnection, $_POST['newpin']);
        $confirmpin = $_SESSION['confirmpin']=mysqli_real_escape_string($this->dbConnection, $_POST['confirmpin']);


        $thingsToValidate = [
            $oldpin.'|Oldpin|oldpin|empty',
            $newpin.'|newpin|newpin|empty',
            $confirmpin.'|Confirmpin|confirmpin|empty'
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../user/Settingpin.php');
            return;
        }

        if ($newpin !== $confirmpin) {
            $_SESSION['formError'] = ['general_error' => ['New pin and Confirm New pin do not match']];
            header('location:../user/Settingpin.php');
            return;
        }

        $user_unique_id = $_SESSION['user_unique_id'];

        $query = "UPDATE user SET pincode='".$newpin."' WHERE user_unique_id='".$user_unique_id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/Settingpin.php");
            return;
        }

        header ('location:../user/Settingpin.php?&success=Pin was updated successfully');

    }
    
    function getLoggedInActivitic($user_unique_id) {
        $query = "SELECT * FROM logins WHERE user_unique_id = '$user_unique_id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            return $result; // Return fetched data
        }
    }

    function getsingledetail($user_unique_id) {
        $query = "SELECT * FROM user WHERE user_unique_id = '$user_unique_id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function report(){
        $type = $_SESSION['type']=mysqli_real_escape_string($this->dbConnection, $_POST['type']);
        $information = $_SESSION['information']=mysqli_real_escape_string($this->dbConnection, $_POST['information']);
        $pincode = $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);


        $thingsToValidate = [
            $type.'|Type|type|empty',
            $information.'|Information|information|empty',
            $pincode.'|Pincode|pincode|empty'
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../user/report.php');
            return;
        }
        $Userpincode = $_SESSION['Userpincode'];

        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Account Pincode']];
            header('location:../user/report.php');
            return;
        }

        $ticket_id = $this->createUniqueID('ticket', 'ticket_id');

        $user_unique_id = $_SESSION['user_unique_id'];

        $query = "INSERT INTO ticket (id,ticket_type,information,ticket_id,user_unique_id)
         VALUES (null,'".$type."', '".$information."','".$ticket_id."','".$user_unique_id."')";
        // print_r($query); die();


        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../user/report.php');
            return;
        }

        header ('location:../user/report.php?&success=Pin was updated successfully');

    }



    function feeDomestic(){
        $query = "SELECT * FROM fee WHERE names = 'domestic-transfer'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row->fee;
            }
            return $UserDetails;
        }
    }
    function domestic(){
        $amount = $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $account = $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $bank_name = $_SESSION['bank_name']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_name']);
        $account_numbers = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $account_name = $_SESSION['account_name']=mysqli_real_escape_string($this->dbConnection, $_POST['account_name']);
        $details = $_SESSION['details']=mysqli_real_escape_string($this->dbConnection, $_POST['details']);

        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $bank_name.'|Bank name|bank_name|empty',
            $account_numbers.'|Account number|account_number|empty',
            $account_name.'|Account name|account_name|empty',
            $details.'|Details|details|empty',
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/domestic.php');
            return;
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['name'];
        $date =  date('Y-m-d');
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        preg_match('/\((\d+)\)/', $account, $matches);
        $account_number = isset($matches[1]) ? $matches[1] : null;
        $sus = $this->getsingledetail($user_unique_id);
        //  print_r($ass->status);die();
          $active = $sus->suspended;
          if($active =='suspended'){
              $_SESSION['formError'] = ['general_error' => ['You Account is suspended']];
              header('location:../login.php');
              return;
          }
        
          $queryss = "SELECT * FROM user WHERE saving = '$account_numbers' OR current = '$account_numbers'";
            $detailsss = $this->runMysqliQuery($queryss);
            if ($detailsss['error_code'] == 1) {
                return $detailsss['error'];
            }

            $resultss = $detailsss['data'];
             {
                while ($rowss = mysqli_fetch_assoc($resultss)) {
                    $user_unique_idddd = $rowss['user_unique_id'];
                    $saving_balanceddd = $rowss['saving_balance'];
                    $current_balanceddd = $rowss['current_balance'];
                    if ($rowss['saving'] == $account_numbers) {
                        $ddtotals = $amount + $saving_balanceddd;
                        $ddtotalc = $current_balanceddd;
                    } elseif ($rowss['current'] == $account_numbers) {
                        $ddtotals = $saving_balanceddd;
                        $ddtotalc = $amount + $current_balanceddd;
                    }
                    // $query_user = "UPDATE user SET saving_balance='$ddtotals', current_balance='$ddtotalc' WHERE user_unique_id='$user_unique_idddd'";
                    // $back_user = $this->runMysqliQuery($query_user);
                    // if ($back_user['error_code'] == 1) {
                    //     $_SESSION['formError'] = ['general_error' => [$back_user['error']]];
                    //     header("location:../user/edit.php");
                    //     return;
                    // }
                    $local_id = $this->createUniqueID('local_tranfer', 'local_id');

                    $query_local = "INSERT INTO local_tranfer (id, local_id, amount, account, bank_name, account_numble, account_name, details, Refrence_id,transaction_type, user_unique_id)
                                    VALUES (null, '$local_id', '$amount', '$account', '$bank_name', '$account_number', '$account_name', '$details', '$local_id', 'Credit', '$user_unique_idddd')";
                    $result_local = $this->runMysqliQuery($query_local);
                    if ($result_local['error_code'] == 1) {
                        $_SESSION['formError'] = ['general_error' => [$result_local['error']]];
                        header("location:../user/edit.php");
                        return;
                    }
                }
            }

        //print_r($account_number);die();
        if($saving == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feeDomestic();
            $balance = $ass->saving_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/domestic.php');
                return;
            }
    
            $local_id = $this->createUniqueID('local_tranfer', 'local_id');
            
    
    
            $query = "INSERT INTO local_tranfer (id,local_id,amount,account,bank_name,account_numble,account_name,details,Refrence_id,transaction_type,user_unique_id)
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_numbers."','".$account_name."','".$details."','".$local_id."','Debit','".$user_unique_id."')";
           // print_r($query); die();
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../register.php');
               return;
           }
            
            $query = "UPDATE user SET saving_balance ='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/domestic.php");
                return;
            }
            
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
        }

        if($current == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feeDomestic();
            $balance = $ass->current_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/domestic.php');
                return;
            }
    
            $local_id = $this->createUniqueID('local_tranfer', 'local_id');
    
    
            $query = "INSERT INTO local_tranfer (id,local_id,amount,account,bank_name,account_numble,account_name,details,Refrence_id,transaction_type,user_unique_id)
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_numbers."','".$account_name."','".$details."','".$local_id."','Debit','".$user_unique_id."')";
           // print_r($query); die();
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../register.php');
               return;
           }
            
            $query = "UPDATE user SET current_balance ='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/domestic.php");
                return;
            }
            
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
        }

        if ($result){
            $to  = $email;
            $d = date('Y');
            $subject = "Transfer Notification Coastchartered";
            $message = '
                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                    <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                    <div style="font-size: 14px;">
                    <p>Dear ' . $name . ',</p>
                    <p>We are writing to inform you that a transfer has been successfully made from your account at Coastchartered.</p>
                    <table border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>Date</th>
                            <th>Recipient</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>'.$date.'</td>
                            <td>'.$account_name.'</td>
                            <td>Local Transfer</td>
                            <td>$'. $amount .'</td>
                        </tr>
                    </table>
                    <p>If you did not authorize this transfer or have any questions about it, please contact us immediately.</p>                    <p>Thank you for banking with us.</p>
                    <p>Sincerely,<br>Our Bank Team</p>
					<p style="color:#332E2E">Best Regard<br />
                    coastchartered Team<br />
                    Email: support@coastchartered.com<br /></p>
				
			<div style="background-color:rgb(253, 150, 26);
						float:left;
						width:80%;
						border:1px solid rgb(253, 150, 26);
						border-radius:0px 0px 3px 3px;
						padding-left:10% ;
						padding-right:10% ;
						padding-top:30px ;
						padding-bottom:30px ;
						font-family: \'Roboto\', sans-serif;" class="footer">
                        coastchartered.<br>
				located at 150 Minories,<br>
				Tower, london EC3N,<br>
                United kingdom.
			</div>
			<p style="float:left;
			width:100%;
			text-align:center;
			font-family: \'Roboto Condensed\', sans-serif;
			">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
		</div>
		</body>
		</html>';
            $header = "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
            $retval = @mail($to,$subject, $message, $header);
            if ($retval = true) {
                header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
                // header("location:login.php");
            }else {
                return  'Internal error. Mail fail to send';
            }
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
        }

    }
    function accountType(){
        $query = "SELECT * FROM account_type";
        $details = $this->runMysqliQuery($query);
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        $accountTypes = [];
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $accountTypes[] = $row;
              //  print_r($accountTypes);die();
            }
        }
        return $accountTypes;
    }

    function courrency(){
        $query = "SELECT * FROM currencies";
        $details = $this->runMysqliQuery($query);
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        $currencies = [];
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $currencies[] = $row;
              //  print_r($accountTypes);die();
            }
        }
        return $currencies;
    }
    function feewire(){
        $query = "SELECT * FROM fee WHERE names = 'wire-transfer'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row->fee;
            }
            return $UserDetails;
        }
    }
    function wire(){
        $amount = $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $account = $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $account_type = $_SESSION['account_type']=mysqli_real_escape_string($this->dbConnection, $_POST['account_type']);
        $bank_name = $_SESSION['bank_name']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_name']);
        $account_numbers = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $account_name = $_SESSION['account_name']=mysqli_real_escape_string($this->dbConnection, $_POST['account_name']);
        $bank_country = $_SESSION['bank_country']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_country']);
        $bank_code = $_SESSION['bank_code']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_code']);
        $details = $_SESSION['details']=mysqli_real_escape_string($this->dbConnection, $_POST['details']);

        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $account_type.'|Account Type|account_type|empty',
            $bank_name.'|Bank name|bank_name|empty',
            $account_numbers.'|Account number|account_number|empty',
            $account_name.'|Account name|account_name|empty',
            $bank_country.'|Bank Country|bank_country|empty',
            $bank_code.'|Bank Code|bank_code|empty',
            $details.'|Details|details|empty',
        ];
        //print_r($thingsToValidate);die();
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/wire.php');
            return;
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['name'];
        $date =  date('Y-m-d');
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        preg_match('/\((\d+)\)/', $account, $matches);
        $account_number = isset($matches[1]) ? $matches[1] : null;
       // print_r($account_number);die();
        $sus = $this->getsingledetail($user_unique_id);
        //  print_r($ass->status);die();
          $active = $sus->suspended;
          if($active =='suspended'){
              $_SESSION['formError'] = ['general_error' => ['You Account is suspended']];
              header('location:../login.php');
              return;
          }
          $queryss = "SELECT * FROM user WHERE saving = '$account_numbers' OR current = '$account_numbers'";
            $detailsss = $this->runMysqliQuery($queryss);
            if ($detailsss['error_code'] == 1) {
                return $detailsss['error'];
            }

            $resultss = $detailsss['data'];
             {
                while ($rowss = mysqli_fetch_assoc($resultss)) {
                    $user_unique_idddd = $rowss['user_unique_id'];
                    $saving_balanceddd = $rowss['saving_balance'];
                    $current_balanceddd = $rowss['current_balance'];
                    if ($rowss['saving'] == $account_numbers) {
                        $ddtotals = $amount + $saving_balanceddd;
                        $ddtotalc = $current_balanceddd;
                    } elseif ($rowss['current'] == $account_numbers) {
                        $ddtotals = $saving_balanceddd;
                        $ddtotalc = $amount + $current_balanceddd;
                    }
                    // $query_user = "UPDATE user SET saving_balance='$ddtotals', current_balance='$ddtotalc' WHERE user_unique_id='$user_unique_idddd'";
                    // $back_user = $this->runMysqliQuery($query_user);
                    // if ($back_user['error_code'] == 1) {
                    //     $_SESSION['formError'] = ['general_error' => [$back_user['error']]];
                    //     header("location:../user/edit.php");
                    //     return;
                    // }
                    $local_id = $this->createUniqueID('wire_tranfer', 'wire_id');

                    $query_local = "INSERT INTO wire_tranfer (id, wire_id, amount, account,account_type, bank_name, account_numble, account_name, details, Refrence_id,bank_country,bank_code,transaction_type, user_unique_id)
                                    VALUES (null, '$local_id', '$amount', '$account', '$account_type','$bank_name', '$account_number', '$account_name', '$details', '$local_id','$bank_country','$bank_code', 'Credit', '$user_unique_idddd')";
                    $result_local = $this->runMysqliQuery($query_local);
                    if ($result_local['error_code'] == 1) {
                        $_SESSION['formError'] = ['general_error' => [$result_local['error']]];
                        header("location:../user/edit.php");
                        return;
                    }
                }
            }


       if($saving == $account_number){
        $ass = $this->getsingledetail($user_unique_id);
        $fee = $this->feewire();
        $balance = $ass->saving_balance;
        $subTotal = ($fee/100)*$amount;
        $sumTotal = $balance - $subTotal;
        $total = $sumTotal - $amount;
        //print_r($total);die();

        if ($total < 0) {
            $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
            header('location:../user/wire.php');
            return;
        }

        $local_id = $this->createUniqueID('wire_tranfer', 'wire_id');


        $query = "INSERT INTO wire_tranfer (id,wire_id,amount,account,account_type,bank_name,account_numble,account_name,details,bank_code,Refrence_id,transaction_type,user_unique_id)
        VALUES (null,'".$local_id."', '".$amount."','".$account."','".$account_type."','".$bank_name."','".$account_numbers."','".$account_name."','".$details."','".$bank_code."','".$local_id."','Debit','".$user_unique_id."')";
       // print_r($query); die();
       $result = $this->runMysqliQuery($query); 
       if ($result['error_code'] == 1){
           $_SESSION['formError']=['general_error' =>[$result['error']] ];
           header('location:../user/wire.php');
           return;
       }
        
        $query = "UPDATE user SET saving_balance ='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/wire.php");
            return;
        }
        if ($result){
            $to  = $email;
            $d = date('Y');
            $subject = "Transfer Notification Coastchartered";
            $message = '
                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                    <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                    <div style="font-size: 14px;">
                    <p>Dear ' . $name . ',</p>
                    <p>We are writing to inform you that a transfer has been successfully made from your account at Coastchartered.</p>
                    <table border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>Date</th>
                            <th>Recipient</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>'.$date.'</td>
                            <td>'.$account_name.'</td>
                            <td>Wire Transfer</td>
                            <td>$'. $amount .'</td>
                        </tr>
                    </table>
                    <p>If you did not authorize this transfer or have any questions about it, please contact us immediately.</p>                    <p>Thank you for banking with us.</p>
                    <p>Sincerely,<br>Our Bank Team</p>
					<p style="color:#332E2E">Best Regard<br />
                    coastchartered Team<br />
                    Email: support@coastchartered.com<br /></p>
				
			<div style="background-color:rgb(253, 150, 26);
						float:left;
						width:80%;
						border:1px solid rgb(253, 150, 26);
						border-radius:0px 0px 3px 3px;
						padding-left:10% ;
						padding-right:10% ;
						padding-top:30px ;
						padding-bottom:30px ;
						font-family: \'Roboto\', sans-serif;" class="footer">
                        coastchartered.<br>
				located at 150 Minories,<br>
				Tower, london EC3N,<br>
                United kingdom.
			</div>
			<p style="float:left;
			width:100%;
			text-align:center;
			font-family: \'Roboto Condensed\', sans-serif;
			">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
		</div>
		</body>
		</html>';
            $header = "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
            $retval = @mail($to,$subject, $message, $header);
            if ($retval = true) {
                header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
                // header("location:login.php");
            }else {
                return  'Internal error. Mail fail to send';
            }
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");
        }


        }

        if($current === $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feewire();
            $balance = $ass->current_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;

            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/wire.php');
                return;
            }

            $local_id = $this->createUniqueID('wire_tranfer', 'wire_id');


            $query = "INSERT INTO wire_tranfer (id,wire_id,amount,account,account_type,bank_name,account_numble,account_name,details,bank_code,Refrence_id,user_unique_id)
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_type."','".$account_numbers."','".$account_name."','".$details."','".$bank_code."','".$local_id."','".$user_unique_id."')";
        // print_r($query); die();
        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../user/wire.php');
            return;
        }
            
            $query = "UPDATE user SET current_balance ='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/wire.php");
                return;
            }

            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$local_id");


        }
        
    }

    function feeself(){
        $query = "SELECT * FROM fee WHERE names = 'self-transfer'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row->fee;
            }
            return $UserDetails;
        }
    }

    function self(){
        $amount = $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $from_account = $_SESSION['from_account']=mysqli_real_escape_string($this->dbConnection, $_POST['from_account']);
        $to_account = $_SESSION['to_account']=mysqli_real_escape_string($this->dbConnection, $_POST['to_account']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);


        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $from_account.'|From Account|from_account|empty',
            $to_account.'|To Account|to_account|empty',
            $pincode.'|Pincode|pincode|empty',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/self.php');
            return;
        }
        $Userpincode = $_SESSION['Userpincode'];
        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Pincode']];
            header('location:../user/self.php');
            return;
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['name'];
        $date =  date('Y-m-d');
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        preg_match('/\((\d+)\)/', $from_account, $matches);
        $account_number = isset($matches[1]) ? $matches[1] : null;
        preg_match('/\((\d+)\)/', $to_account, $matches);
        $to_accou = isset($matches[1]) ? $matches[1] : null;
        $sus = $this->getsingledetail($user_unique_id);
        // print_r($sus);die();

          $active = $sus->suspended;
          if($active =='suspended'){
              $_SESSION['formError'] = ['general_error' => ['You Account is suspended']];
              header('location:../login.php');
              return;
          }
        if($saving == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feeself();
            $balance = $ass->saving_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
           // print_r($to_accou);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/self.php');
                return;
            }
    
            $self_id = $this->createUniqueID('self_tranfer', 'self_id');
            $encodedMessage = urlencode('Tranfer was successfully');
            $encodedSelfId = urlencode($self_id);

            $query = "INSERT INTO self_tranfer (id,self_id,amount,account,to_account,Refrence_id,transaction_type,user_unique_id)
            VALUES (null,'".$self_id."', '".$amount."','".$from_account."','".$to_account."','".$self_id."','Debit','".$user_unique_id."')";
           // print_r($query); die();
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../user/self.php');
               return;
           }
           if ($saving == $to_accou) {
            $_SESSION['formError'] = ['general_error' => ['you cannot send Money to saving to saving']];
            header('location:../user/self.php');
            return;
            }
           $current_balance = $ass->current_balance;
           $ccurentTotal = $amount + $current_balance;

            // $query = "UPDATE user SET saving_balance='".$total."',current_balance='".$ccurentTotal."'WHERE user_unique_id='".$user_unique_id."' ";
            // $back = $this->runMysqliQuery($query);
            // if($back['error_code'] == 1){
            //     $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            //     header("location:../user/self.php");
            //     return;
            // }
    
            header ("location:../user/receipt.php?&success=$encodedMessage&ref_id=$encodedSelfId");

        }
        
        if($current == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feeself();
            $balance = $ass->current_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
           // print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/self.php');
                return;
            }
    
            $self_id = $this->createUniqueID('self_tranfer', 'self_id');
            $encodedMessage = urlencode('Tranfer was successfully');
            $encodedSelfId = urlencode($self_id);
    
            $query = "INSERT INTO self_tranfer (id,self_id,amount,account,to_account,Refrence_id,transaction_type,user_unique_id)
            VALUES (null,'".$self_id."', '".$amount."','".$from_account."','".$to_account."','".$self_id."','Debit','".$user_unique_id."')";
           // print_r($query); die();
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../user/self.php');
               return;
           }
            
           if ($current == $to_accou) {
            $_SESSION['formError'] = ['general_error' => ['you cannot send Money to current to current']];
            header('location:../user/self.php');
            return;
            }
           $saving_balance = $ass->saving_balance;
           $savingTotal = $amount + $saving_balance;
            
            // $query = "UPDATE user SET current_balance='".$total."',saving_balance='".$savingTotal."'WHERE user_unique_id='".$user_unique_id."' ";
            // $back = $this->runMysqliQuery($query);
            // if($back['error_code'] == 1){
            //     $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            //     header("location:../user/self.php");
            //     return;
            // }

            if ($result){
                $to  = $email;
                $d = date('Y');
                $subject = "Transfer Notification Coastchartered";
                $message = '
                                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                    <html xmlns="http://www.w3.org/1999/xhtml">
                                    <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    </head>
                                    <body>
                        <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                        <div style="font-size: 14px;">
                        <p>Dear ' . $name . ',</p>
                        <p>We are writing to inform you that a transfer has been successfully made from your account at Coastchartered.</p>
                        <table border="1" cellpadding="5" cellspacing="0">
                            <tr>
                                <th>Date</th>
                                <th>Recipient</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                            <tr>
                                <td>'.$date.'</td>
                                <td>'.$to_account.'</td>
                                <td>Self Transfer</td>
                                <td>$'. $amount .'</td>
                            </tr>
                        </table>
                        <p>If you did not authorize this transfer or have any questions about it, please contact us immediately.</p>                    <p>Thank you for banking with us.</p>
                        <p>Sincerely,<br>Our Bank Team</p>
                        <p style="color:#332E2E">Best Regard<br />
                        coastchartered Team<br />
                        Email: support@coastchartered.com<br /></p>
                    
                <div style="background-color:rgb(253, 150, 26);
                            float:left;
                            width:80%;
                            border:1px solid rgb(253, 150, 26);
                            border-radius:0px 0px 3px 3px;
                            padding-left:10% ;
                            padding-right:10% ;
                            padding-top:30px ;
                            padding-bottom:30px ;
                            font-family: \'Roboto\', sans-serif;" class="footer">
                            coastchartered.<br>
                    located at 150 Minories,<br>
                    Tower, london EC3N,<br>
                    United kingdom.
                </div>
                <p style="float:left;
                width:100%;
                text-align:center;
                font-family: \'Roboto Condensed\', sans-serif;
                ">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
            </div>
            </body>
            </html>';
                $header = "MIME-Version: 1.0" . "\r\n";
                $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
                $retval = @mail($to,$subject, $message, $header);
                if ($retval = true) {
                    header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$self_id");
                    // header("location:login.php");
                }else {
                    return  'Internal error. Mail fail to send';
                }
                header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$self_id");
            }
    
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$self_id");

        }

    }

    function feeuser(){
        $query = "SELECT * FROM fee WHERE names = 'User-transfer'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row->fee;
            }
            return $UserDetails;
        }
    }

    function User(){
        $amount = $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $account = $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $account_numbers = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);


        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $account_numbers.'|Account Number|account_number|empty',
            $pincode.'|Pincode|pincode|empty',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/user.php');
            return;
        }

        $Userpincode = $_SESSION['Userpincode'];
        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Pincode']];
            header('location:../user/user.php');
            return;
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['name'];
        $date =  date('Y-m-d');
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        preg_match('/\((\d+)\)/', $account, $matches);
         $account_number = isset($matches[1]) ? $matches[1] : null;
        $sus = $this->getsingledetail($user_unique_id);
          $active = $sus->suspended;
          if($active =='suspended'){
              $_SESSION['formError'] = ['general_error' => ['You Account is suspended']];
              header('location:../login.php');
              return;
          }

          $queryss = "SELECT * FROM user WHERE saving = '$account_numbers' OR current = '$account_numbers'";
          $detailsss = $this->runMysqliQuery($queryss);
          if ($detailsss['error_code'] == 1) {
              return $detailsss['error'];
          }

          $resultss = $detailsss['data'];
           {
              while ($rowss = mysqli_fetch_assoc($resultss)) {
                  $user_unique_idddd = $rowss['user_unique_id'];
                  $saving_balanceddd = $rowss['saving_balance'];
                  $current_balanceddd = $rowss['current_balance'];
                  if ($rowss['saving'] == $account_numbers) {
                      $ddtotals = $amount + $saving_balanceddd;
                      $ddtotalc = $current_balanceddd;
                  } elseif ($rowss['current'] == $account_numbers) {
                      $ddtotals = $saving_balanceddd;
                      $ddtotalc = $amount + $current_balanceddd;
                  }
                //   $query_user = "UPDATE user SET saving_balance='$ddtotals', current_balance='$ddtotalc' WHERE user_unique_id='$user_unique_idddd'";
                //   $back_user = $this->runMysqliQuery($query_user);
                //   if ($back_user['error_code'] == 1) {
                //       $_SESSION['formError'] = ['general_error' => [$back_user['error']]];
                //       header("location:../user/edit.php");
                //       return;
                //   }
                  $user_id = $this->createUniqueID('user_transfer', 'user_id');

                  $query_local = "INSERT INTO user_transfer (id,user_id,amount,account,account_number,Refrence_id,transaction_type,user_unique_id)
                                  VALUES (null,'$user_id', '$amount', '$account','$account_numbers','$user_id','Credit','$user_unique_idddd')";
                  //  print_r($query_local); die();
                  $result_local = $this->runMysqliQuery($query_local);
                  if ($result_local['error_code'] == 1) {
                      $_SESSION['formError'] = ['general_error' => [$result_local['error']]];
                      header("location:../user/edit.php");
                      return;
                  }
              }
          }


        if($saving == $account_number){

            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feewire();
            $balance = $ass->saving_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
            //print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/user.php');
                return;
            }
    
            $user_id = $this->createUniqueID('user_transfer', 'user_id');
    
    
            $query = "INSERT INTO user_transfer (id,user_id,amount,account,account_number,Refrence_id,transaction_type,user_unique_id)
            VALUES (null,'".$user_id."', '".$amount."','".$account."','".$account_numbers."','".$user_id."','Debit','".$user_unique_id."')";
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../user/user.php');
               return;
           }
            
            $query = "UPDATE user SET saving_balance='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/user.php");
                return;
            }
    
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");

        }

        if($current == $account_number){

            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feewire();
            $balance = $ass->current_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
            //print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/user.php');
                return;
            }
    
            $user_id = $this->createUniqueID('user_transfer', 'user_id');
    
    
            $query = "INSERT INTO user_transfer (id,user_id,amount,account,account_number,Refrence_id,user_unique_id)
            VALUES (null,'".$user_id."', '".$amount."','".$account."','".$account_numbers."','".$user_id."','".$user_unique_id."')";
           // print_r($query); die();
           $result = $this->runMysqliQuery($query); 
           if ($result['error_code'] == 1){
               $_SESSION['formError']=['general_error' =>[$result['error']] ];
               header('location:../user/user.php');
               return;
           }
            
            $query = "UPDATE user SET current_balance='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/user.php");
                return;
            }
            if ($result){
                $to  = $email;
                $d = date('Y');
                $subject = "Transfer Notification Coastchartered";
                $message = '
                                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                    <html xmlns="http://www.w3.org/1999/xhtml">
                                    <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    </head>
                                    <body>
                        <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                        <div style="font-size: 14px;">
                        <p>Dear ' . $name . ',</p>
                        <p>We are writing to inform you that a transfer has been successfully made from your account at Coastchartered.</p>
                        <table border="1" cellpadding="5" cellspacing="0">
                            <tr>
                                <th>Date</th>
                                <th>Recipient</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                            <tr>
                                <td>'.$date.'</td>
                                <td>Coastchartered</td>
                                <td>Self Transfer</td>
                                <td>$'. $amount .'</td>
                            </tr>
                        </table>
                        <p>If you did not authorize this transfer or have any questions about it, please contact us immediately.</p>                    <p>Thank you for banking with us.</p>
                        <p>Sincerely,<br>Our Bank Team</p>
                        <p style="color:#332E2E">Best Regard<br />
                        coastchartered Team<br />
                        Email: support@coastchartered.com<br /></p>
                    
                <div style="background-color:rgb(253, 150, 26);
                            float:left;
                            width:80%;
                            border:1px solid rgb(253, 150, 26);
                            border-radius:0px 0px 3px 3px;
                            padding-left:10% ;
                            padding-right:10% ;
                            padding-top:30px ;
                            padding-bottom:30px ;
                            font-family: \'Roboto\', sans-serif;" class="footer">
                            coastchartered.<br>
                    located at 150 Minories,<br>
                    Tower, london EC3N,<br>
                    United kingdom.
                </div>
                <p style="float:left;
                width:100%;
                text-align:center;
                font-family: \'Roboto Condensed\', sans-serif;
                ">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
            </div>
            </body>
            </html>';
                $header = "MIME-Version: 1.0" . "\r\n";
                $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
                $retval = @mail($to,$subject, $message, $header);
                if ($retval = true) {
                    header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");
                    // header("location:login.php");
                }else {
                    return  'Internal error. Mail fail to send';
                }
                header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");
            }
    
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");

        }

    }

    function feecard(){
        $query = "SELECT * FROM fee WHERE names = 'card'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else {
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row->fee;
            }
            return $UserDetails;
        }
    }

    function card(){
        $account = $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);

        $thingsToValidate = [
            $account.'|Account|account|empty',
            $pincode.'|Pincode|pincode|empty',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/card.php');
            return;
        }

        $Userpincode = $_SESSION['Userpincode'];
        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Pincode']];
            header('location:../user/card.php');
            return;
        }
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        preg_match('/\((\d+)\)/', $account, $matches);
       // print_r($account);die(); // Debugging
        $account_number = isset($matches[1]) ? $matches[1] : null;
        // $account_number = substr($account, 4, 1);
       // print_r($account_number); die();

        $card_id = $this->createUniqueID('card', 'card_id');

        if($saving == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feecard();
            $balance = $ass->saving_balance;
            // $subTotal = ($fee/100)*$balance;
            $total = $balance - $fee;
            // $total = $sumTotal - $amount;
            //print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/user.php');
                return;
            }
    
    
            $query = "INSERT INTO card (id,card_id,account,user_unique_id)
                VALUES (null,'".$card_id."','".$account."','".$user_unique_id."')";
            // print_r($query); die();
            $result = $this->runMysqliQuery($query); 
            if ($result['error_code'] == 1){
                $_SESSION['formError']=['general_error' =>[$result['error']] ];
                header('location:../user/card.php');
                return;
            }
            
            $query = "UPDATE user SET saving_balance='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/user.php");
                return;
            }
    
            header ('location:../user/card.php?&success=Tranfer was successfully');

        }
        //print_r($current); die();
        if($current == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feecard();
            $balance = $ass->current_balance;
            // $subTotal = ($fee/100)*$balance;
            $total = $balance - $fee;
            // $total = $sumTotal - $amount;
            //print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/user.php');
                return;
            }
    
    
            $query = "INSERT INTO card (id,card_id,account,user_unique_id)
                VALUES (null,'".$card_id."','".$account."','".$user_unique_id."')";
            // print_r($query); die();
            $result = $this->runMysqliQuery($query); 
            if ($result['error_code'] == 1){
                $_SESSION['formError']=['general_error' =>[$result['error']] ];
                header('location:../user/card.php');
                return;
            }
            
            $query = "UPDATE user SET current_balance='".$total."' WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/user.php");
                return;
            }
    
            header ('location:../user/card.php?&success=Tranfer was successfully');

        }


    }

    function loan(){
        $amount = $_SESSION['amount']=mysqli_real_escape_string($this->dbConnection, $_POST['amount']);
        $account = $_SESSION['account']=mysqli_real_escape_string($this->dbConnection, $_POST['account']);
        $loan_type = $_SESSION['loan_type']=mysqli_real_escape_string($this->dbConnection, $_POST['loan_type']);
        $loan_duration = $_SESSION['loan_duration']=mysqli_real_escape_string($this->dbConnection, $_POST['loan_duration']);
        $details = $_SESSION['details']=mysqli_real_escape_string($this->dbConnection, $_POST['details']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);

        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $loan_type.'|Loan Type|loan_type|empty',
            $loan_duration.'|Loan Duration|loan_duration|empty',
            $details.'|Details|details|empty',
            $pincode.'|Pincode|pincode|empty',
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/loan.php');
            return;
        }
        $user_unique_id = $_SESSION['user_unique_id'];
        $sus = $this->getsingledetail($user_unique_id);
        //  print_r($ass->status);die();
          $active = $sus->suspended;
          if($active =='suspended'){
              $_SESSION['formError'] = ['general_error' => ['You Account is suspended']];
              header('location:../login.php');
              return;
          }

        $Userpincode = $_SESSION['Userpincode'];
        if ($pincode !== $Userpincode) {
            $_SESSION['formError'] = ['general_error' => ['Incorrect Pincode']];
            header('location:../user/loan.php');
            return;
        }

        $loan_id = $this->createUniqueID('loan', 'loan_id');


        $query = "INSERT INTO loan (id,loan_id,amount,account,loan_type,loan_duration,details,user_unique_id)
        VALUES (null,'".$loan_id."', '".$amount."','".$account."','".$loan_type."','".$loan_duration."','".$details."','".$user_unique_id."')";
       // print_r($query); die();
       $result = $this->runMysqliQuery($query); 
       if ($result['error_code'] == 1){
           $_SESSION['formError']=['general_error' =>[$result['error']] ];
           header('location:../user/loan.php');
           return;
       }
        

        header ('location:../user/loan.php?&success=loan was successfully');

    }
    

    function alltableID() {
        $UserDetails = [];
        $user_unique_id = $_SESSION['user_unique_id'];
    
        $query = "SELECT * FROM deposit WHERE user_unique_id = '$user_unique_id' ORDER BY created_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM local_tranfer WHERE user_unique_id = '$user_unique_id' ORDER BY created_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM user_transfer WHERE user_unique_id = '$user_unique_id' ORDER BY created_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM wire_tranfer WHERE user_unique_id = '$user_unique_id' ORDER BY created_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM self_tranfer WHERE user_unique_id = '$user_unique_id' ORDER BY created_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
        //print_r($UserDetails); die();
        return $UserDetails;
    }


    function alltable() {
        $UserDetails = [];
        $user_unique_id = $_SESSION['user_unique_id'];
    
        $query = "SELECT * FROM deposit WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM local_tranfer WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM user_transfer WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM wire_tranfer WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM self_tranfer WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
        //print_r($UserDetails); die();
        return $UserDetails;
    }


    function Invoice($Refrence_id) {
    
        $query = "SELECT * FROM deposit WHERE Refrence_id = '".$Refrence_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM local_tranfer WHERE Refrence_id = '".$Refrence_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM user_transfer WHERE Refrence_id = '".$Refrence_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

        $query = "SELECT * FROM wire_tranfer WHERE Refrence_id = '".$Refrence_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
    
        $query = "SELECT * FROM self_tranfer WHERE Refrence_id = '".$Refrence_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }
        //print_r($UserDetails); die();
        return $UserDetails;
    }

    function myloan() {
        $UserDetails = [];
        $user_unique_id = $_SESSION['user_unique_id'];
    
        $query = "SELECT * FROM loan WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

       // print_r($UserDetails); die();
        return $UserDetails;
    }

    function myTicket() {
        $UserDetails = [];
        $user_unique_id = $_SESSION['user_unique_id'];
    
        $query = "SELECT * FROM ticket WHERE user_unique_id = '".$user_unique_id."'";
        $details = $this->runMysqliQuery($query);
        if($details['error_code'] == 1){
            return $details['error'];
        }
        while($row = mysqli_fetch_object($details['data'])){
            $UserDetails[] = $row;
        }

       // print_r($UserDetails); die();
        return $UserDetails;
    }
    function logout(){
        session_destroy();
        header('location:../login.php?success=you have successfully logged out');
    }
    function logouts(){
        session_destroy();
        header('location:../loginAdmin.php?success=you have successfully logged out');
    }


    function loginAdmin(){
        $email= $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);
        $password= $_SESSION['password']=mysqli_real_escape_string($this->dbConnection, $_POST['password']);

        $thingsToValidate = [
            $email.'|Email|email|empty',
            $password.'|Password|Passwords|empty'
        ];

        
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false) {
            $_SESSION['formError'] = $this->errors;
            header('location:../loginAdmin.php');
            return;
         
        }
        $calllogin = $this->loginAdminsHandler($email,$password);
      //print_r( $calllogin); die();


        if ($calllogin['error_code']== 1 ){
            $_SESSION['formError'] = ['general_error'=>[$calllogin['error']]];
            header('location:../loginAdmin.php');

        }
        $queryResult = $calllogin['data'];
        if(mysqli_num_rows($queryResult) == 1){
            header('location:../admin/dashborad.php');
        }else{
            $_SESSION['formError'] = ['general_error'=>['Incorrect Username/Email or Password']];
            header('location:../loginAdmin.php');
        }

    }

    function alluser(){
        $UserDetails = [];
        $query = "SELECT * FROM user";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function Totaluser(){
        $query = "SELECT COUNT(*) FROM user";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return '0';
        }else{
            while($row = mysqli_fetch_array($result)){
                $UserDetails = $row[0];
                //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    
    function Totalcard(){
        $query = "SELECT COUNT(*) FROM card";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return '0';
        }else{
            while($row = mysqli_fetch_array($result)){
                $UserDetails = $row[0];
                //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function Totaldeposit(){
        $query = "SELECT COUNT(*) FROM deposit";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return '0';
        }else{
            while($row = mysqli_fetch_array($result)){
                $UserDetails = $row[0];
                //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }
    function Totaldepositcheck(){
        $query = "SELECT COUNT(*) FROM depostcheck";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return '0';
        }else{
            while($row = mysqli_fetch_array($result)){
                $UserDetails = $row[0];
                //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }




    function suspendedUser($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'suspended'){
            $query = "UPDATE user SET status = 'active' WHERE user_unique_id = '".$user_id."'";
            $message = "User has been active successfully";
        } elseif ($status === 'active') {
            $query = "UPDATE user SET status = 'suspended' WHERE user_unique_id = '".$user_id."'";
            $message = "User has been suspended successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/dashborad.php");
            return;
        }
        header("location:../admin/dashborad.php?success=$message");
    }

    function suspendUser($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'pending'){
            $query = "UPDATE user SET status = 'confirmed' WHERE user_unique_id = '".$user_id."'";
            $message = "User has been confirmed successfully";
        } elseif ($status === 'confirmed') {
            $query = "UPDATE user SET status = 'pending' WHERE user_unique_id = '".$user_id."'";
            $message = "User has been pending successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/dashborad.php");
            return;
        }
        header("location:../admin/dashborad.php?success=$message");
    }

    function deleteUser($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM user WHERE user_unique_id = '".$user_id."'";
            $message = "User has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/dashborad.php");
            return;
        }
        header("location:../admin/dashborad.php?success=$message");
    }

    function addAmount(){
        $userid = $_SESSION['userid'] = mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $loan = isset($_POST['loan']) ? mysqli_real_escape_string($this->dbConnection, $_POST['loan']) : 0;
        $saving = isset($_POST['saving']) ? mysqli_real_escape_string($this->dbConnection, $_POST['saving']) : 0;
        $current = isset($_POST['current']) ? mysqli_real_escape_string($this->dbConnection, $_POST['current']) : 0;

        $thingsToValidate = [
            $loan.'|Loan|loan',
            $saving.'|Saving|saving',
            $current.'|Current|current',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/add.php?user=$userid");
            return;
        }
        $ass = $this->getsingledetail($userid);
        $loan_bal = $ass->loan_balance + $loan;
        $saving_bal = $ass->saving_balance + $saving;
        $current_bal = $ass->current_balance + $current;

        $query = "UPDATE user SET loan_balance='".$loan_bal."',saving_balance='".$saving_bal."',current_balance='".$current_bal."' WHERE user_unique_id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/user.php");
            return;
        }

        header ("location:../admin/add.php?user=$userid&success=Amount Added was successfully");

    }


    function removeAmount(){
        $userid = $_SESSION['userid']=mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $loan = $_SESSION['loan']=mysqli_real_escape_string($this->dbConnection, $_POST['loan']);
        $saving = $_SESSION['saving']=mysqli_real_escape_string($this->dbConnection, $_POST['saving']);
        $current = $_SESSION['current']=mysqli_real_escape_string($this->dbConnection, $_POST['current']);
        $thingsToValidate = [
            $loan.'|Loan|loan',
            $saving.'|Saving|saving',
            $current.'|Current|current',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/remove.php?user=$userid");
            return;
        }
        $ass = $this->getsingledetail($userid);
        $loan_bal = $ass->loan_balance - $loan;
        $saving_bal = $ass->saving_balance - $saving;
        $current_bal = $ass->current_balance - $current;
        //print_r($saving_bal);die();

        $query = "UPDATE user SET loan_balance='".$loan_bal."',saving_balance='".$saving_bal."',current_balance='".$current_bal."' WHERE user_unique_id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/remove.php");
            return;
        }

        header ("location:../admin/remove.php?user=$userid&success=Amount Remove was successfully");

    }

    function edit(){
        $userid = $_SESSION['userid']=mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $name = $_SESSION['name']=mysqli_real_escape_string($this->dbConnection, $_POST['name']);
        $lastname = $_SESSION['lastname']=mysqli_real_escape_string($this->dbConnection, $_POST['lastname']);
        $email = $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);
        $phone = $_SESSION['phone']=mysqli_real_escape_string($this->dbConnection, $_POST['phone']);
        $thingsToValidate = [
            $name.'|Name|name',
            $lastname.'|Lastname|lastname',
            $email.'|Email|email',
            $phone.'|Phone|phone',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/edit.php?user=$userid");
            return;
        }

        $query = "UPDATE user SET name ='".$name."',lastname='".$lastname."',email ='".$email."',phone ='".$phone."' WHERE user_unique_id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/edit.php");
            return;
        }

        header ("location:../admin/edit.php?user=$userid&success=User Edit was successfully");

    }

    function allCard(){
        $UserDetails = [];
        $query = "SELECT * FROM card";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function cardProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'Processing'){
            $query = "UPDATE card SET status = 'Complete' WHERE card_id = '".$user_id."'";
            $message = "User has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE card SET status = 'Processing' WHERE card_id = '".$user_id."'";
            $message = "User has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/card.php");
            return;
        }
        header("location:../admin/card.php?success=$message");
    }

    function deleteCard($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM card WHERE card_id = '".$user_id."'";
            $message = "card has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/card.php");
            return;
        }
        header("location:../admin/card.php?success=$message");
    }

    function allCurrency(){
        $UserDetails = [];
        $query = "SELECT * FROM currencies";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function getsingleCurrency($id) {
        $query = "SELECT * FROM currencies WHERE id = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }
    function currencyUpdate(){
        $userid = $_SESSION['userid']=mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $currency = $_SESSION['currency']=mysqli_real_escape_string($this->dbConnection, $_POST['currency']);
       
        $thingsToValidate = [
            $currency.'|Currency|currency',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/currencyUpdate.php?id=$userid");
            return;
        }

        $query = "UPDATE currencies SET currency ='".$currency."' WHERE id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/currencyUpdate.php");
            return;
        }

        header ("location:../admin/currencyUpdate.php?id=$userid&success=User Edit was successfully");

    }

    function allDeposit(){
        $UserDetails = [];
        $query = "SELECT * FROM deposit";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function depositProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'Processing'){
            $query = "UPDATE deposit SET status = 'Complete' WHERE deposit_id = '".$user_id."'";
            $message = "Deposit has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE deposit SET status = 'Processing' WHERE deposit_id = '".$user_id."'";
            $message = "Deposit has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/deposit.php");
            return;
        }
        header("location:../admin/deposit.php?success=$message");
    }

    function deleteDeposit($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM deposit WHERE deposit_id = '".$user_id."'";
            $message = "deposit has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/deposit.php");
            return;
        }
        header("location:../admin/deposit.php?success=$message");
    }

    function allCheck(){
        $UserDetails = [];
        $query = "SELECT * FROM depostcheck";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function checkProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'Processing'){
            $query = "UPDATE depostcheck SET status = 'Complete' WHERE check_id = '".$user_id."'";
            $message = "Check has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE depostcheck SET status = 'Processing' WHERE check_id = '".$user_id."'";
            $message = "Check has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/check.php");
            return;
        }
        header("location:../admin/check.php?success=$message");
    }

    function deleteCheck($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM depostcheck WHERE check_id = '".$user_id."'";
            $message = "check has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/check.php");
            return;
        }
        header("location:../admin/check.php?success=$message");
    }

    function allFee(){
        $UserDetails = [];
        $query = "SELECT * FROM fee";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }

    function getsingleFee($id) {
        $query = "SELECT * FROM fee WHERE id = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }
    function feeUpdate(){
        $userid = $_SESSION['userid']=mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $fee = $_SESSION['fee']=mysqli_real_escape_string($this->dbConnection, $_POST['fee']);
       
        $thingsToValidate = [
            $fee.'|Fee|fee',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/feeUpdate.php?id=$userid");
            return;
        }

        $query = "UPDATE fee SET fee ='".$fee."' WHERE id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/feeUpdate.php");
            return;
        }

        header ("location:../admin/feeUpdate.php?id=$userid&success=User Edit was successfully");

    }

    function allLoan(){
        $UserDetails = [];
        $query = "SELECT * FROM loan";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function loanProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'Processing'){
            $query = "UPDATE loan SET status = 'Complete' WHERE loan_id = '".$user_id."'";
            $message = "loan has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE loan SET status = 'Processing' WHERE loan_id = '".$user_id."'";
            $message = "loan has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/loan.php");
            return;
        }
        header("location:../admin/loan.php?success=$message");
    }
    function deleteLoan($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM loan WHERE loan_id  = '".$user_id."'";
            $message = "loan has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/loan.php");
            return;
        }
        header("location:../admin/loan.php?success=$message");
    }

    function allLocal(){
        $UserDetails = [];
        $query = "SELECT * FROM local_tranfer";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function localProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
    
        $queryss = "SELECT * FROM local_tranfer WHERE local_id = '$user_id'";
        $detailsss = $this->runMysqliQuery($queryss);
        if ($detailsss['error_code'] == 1) {
            return $detailsss['error'];
        }
        $resultsss = $detailsss['data'];
        if(mysqli_num_rows($resultsss) == 0){
            return 'No Data was returned';
        } else {
            $rowss = mysqli_fetch_assoc($resultsss);
            $account = $rowss['account'];
        }
        preg_match('/\((\d+)\)/', $account, $matches);
        $account_number = isset($matches[1]) ? $matches[1] : null;
        if($status === 'Processing'){
            $query = "UPDATE local_tranfer SET status = 'Complete' WHERE local_id = '".$user_id."'";
            $message = "Local transfer has been completed successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE local_tranfer SET status = 'Processing' WHERE local_id = '".$user_id."'";
            $message = "Local transfer has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/local.php");
            return;
        }
    
        if ($status === 'Processing') {
            $userQuery = "SELECT * FROM user WHERE saving = '$account_number' OR current = '$account_number'";
            //print_r($userQuery);die();
            $userDetails = $this->runMysqliQuery($userQuery);
            if ($userDetails['error_code'] == 1) {
                $_SESSION['formError'] = ['general_error'=>[ $userDetails['error'] ] ];
                header("location:../admin/local.php");
                return;
            }
            $userData = mysqli_fetch_assoc($userDetails['data']);
            
            $accountType = ($userData['saving'] == $account_number) ? 'saving_balance' : 'current_balance';
            $amount = $rowss['amount'];
            $updateQuery = "UPDATE user SET $accountType = $accountType + $amount WHERE user_unique_id = '".$userData['user_unique_id']."'";
            $updateResult = $this->runMysqliQuery($updateQuery);
            if($updateResult['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $updateResult['error'] ] ];
                header("location:../admin/local.php");
                return;
            }
        }

        if ($result){
            $to  = $email;
            $d = date('Y');
            $subject = "Transfer Notification Coastchartered";
            $message = '
                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                </head>
                                <body>
                    <h6 align="center"><img src="https://www.coastchartered.com/user/uploads/ffff.jpg" alt="coastchartered "/></h6>
                    <div style="font-size: 14px;">
                    <p>Dear ' . $name . ',</p>
                    <p>We are writing to inform you that a transfer has been successfully made from your account at Coastchartered.</p>
                    <table border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>Date</th>
                            <th>Recipient</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>'.$date.'</td>
                            <td>Coastchartered</td>
                            <td>Self Transfer</td>
                            <td>$'. $amount .'</td>
                        </tr>
                    </table>
                    <p>If you did not authorize this transfer or have any questions about it, please contact us immediately.</p>                    <p>Thank you for banking with us.</p>
                    <p>Sincerely,<br>Our Bank Team</p>
                    <p style="color:#332E2E">Best Regard<br />
                    coastchartered Team<br />
                    Email: support@coastchartered.com<br /></p>
                
            <div style="background-color:rgb(253, 150, 26);
                        float:left;
                        width:80%;
                        border:1px solid rgb(253, 150, 26);
                        border-radius:0px 0px 3px 3px;
                        padding-left:10% ;
                        padding-right:10% ;
                        padding-top:30px ;
                        padding-bottom:30px ;
                        font-family: \'Roboto\', sans-serif;" class="footer">
                        coastchartered.<br>
                located at 150 Minories,<br>
                Tower, london EC3N,<br>
                United kingdom.
            </div>
            <p style="float:left;
            width:100%;
            text-align:center;
            font-family: \'Roboto Condensed\', sans-serif;
            ">&copy;coastchartered <?php print ' . $d . ';?>. All Rights Reserved.</p>
        </div>
        </body>
        </html>';
            $header = "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'From: coastchartered <support@coastchartered.com' . "\r\n";
            $retval = @mail($to,$subject, $message, $header);
            if ($retval = true) {
                header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");
                // header("location:login.php");
            }else {
                return  'Internal error. Mail fail to send';
            }
            header ("location:../user/receipt.php?&success=Tranfer was successfully&ref_id=$user_id");
        }

    
        header("location:../admin/local.php?success=$message");
    }
    
    
    function deletelocal($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM local_tranfer WHERE local_id  = '".$user_id."'";
            $message = "local tranfer has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/local.php");
            return;
        }
        header("location:../admin/local.php?success=$message");
    }

    function allself(){
        $UserDetails = [];
        $query = "SELECT * FROM self_tranfer";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function selfProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        $queryss = "SELECT * FROM self_tranfer WHERE self_id = '$user_id'";
        $detailsss = $this->runMysqliQuery($queryss);
        if ($detailsss['error_code'] == 1) {
            return $detailsss['error'];
        }
        $resultsss = $detailsss['data'];
        if(mysqli_num_rows($resultsss) == 0){
            return 'No Data was returned';
        } else {
            $rowss = mysqli_fetch_assoc($resultsss);
           // print_r($rowss);die();

            $account = $rowss['to_account'];
        }
        preg_match('/\((\d+)\)/', $account, $matches);
        $account_number = isset($matches[1]) ? $matches[1] : null;
        if($status === 'Processing'){
            $query = "UPDATE self_tranfer SET status = 'Complete' WHERE self_id = '".$user_id."'";
            $message = "self tranfer has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE self_tranfer SET status = 'Processing' WHERE self_id = '".$user_id."'";
            $message = "self tranfer has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/self.php");
            return;
        }

        if ($status === 'Processing') {
            $userQuery = "SELECT * FROM user WHERE saving = '$account_number' OR current = '$account_number'";
           // print_r($userQuery);die();
            $userDetails = $this->runMysqliQuery($userQuery);
            if ($userDetails['error_code'] == 1) {
                $_SESSION['formError'] = ['general_error'=>[ $userDetails['error'] ] ];
                header("location:../admin/local.php");
                return;
            }
            $userData = mysqli_fetch_assoc($userDetails['data']);
            
            $accountType = ($userData['saving'] == $account_number) ? 'saving_balance' : 'current_balance';
    
            // Update the balance of the user's account
            $amount = $rowss['amount'];
            $updateQuery = "UPDATE user SET $accountType = $accountType + $amount WHERE user_unique_id = '".$userData['user_unique_id']."'";
            $updateResult = $this->runMysqliQuery($updateQuery);
            if($updateResult['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $updateResult['error'] ] ];
                header("location:../admin/self.php");
                return;
            }
        }
        header("location:../admin/self.php?success=$message");
    }
    function deleteSelf($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM self_tranfer WHERE self_id  = '".$user_id."'";
            $message = "self tranfer has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/self.php");
            return;
        }
        header("location:../admin/self.php?success=$message");
    }

    function allticket(){
        $UserDetails = [];
        $query = "SELECT * FROM ticket";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function deleteTicket($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM ticket WHERE ticket_id  = '".$user_id."'";
            $message = "ticket has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/ticket.php");
            return;
        }
        header("location:../admin/ticket.php?success=$message");
    }

    function alluserTransfer(){
        $UserDetails = [];
        $query = "SELECT * FROM user_transfer";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function userProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        $queryss = "SELECT * FROM user_transfer WHERE user_id = '$user_id'";
        $detailsss = $this->runMysqliQuery($queryss);
        if ($detailsss['error_code'] == 1) {
            return $detailsss['error'];
        }
        $resultsss = $detailsss['data'];
        if(mysqli_num_rows($resultsss) == 0){
            return 'No Data was returned';
        } else {
            $rowss = mysqli_fetch_assoc($resultsss);
          // print_r($rowss);die();
            $account_number = $rowss['account_number'];
        }
        // preg_match('/\((\d+)\)/', $account, $matches);
        // $account_number = isset($matches[1]) ? $matches[1] : null;
        if($status === 'Processing'){
            $query = "UPDATE user_transfer SET status = 'Complete' WHERE user_id = '".$user_id."'";
            $message = "user tranfer has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE user_transfer SET status = 'Processing' WHERE user_id = '".$user_id."'";
            $message = "user tranfer has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/user.php");
            return;
        }
        
        if ($status === 'Processing') {
            $userQuery = "SELECT * FROM user WHERE saving = '$account_number' OR current = '$account_number'";
            //print_r($userQuery);die();
            $userDetails = $this->runMysqliQuery($userQuery);
            if ($userDetails['error_code'] == 1) {
                $_SESSION['formError'] = ['general_error'=>[ $userDetails['error'] ] ];
                header("location:../admin/local.php");
                return;
            }
            $userData = mysqli_fetch_assoc($userDetails['data']);
            
            $accountType = ($userData['saving'] == $account_number) ? 'saving_balance' : 'current_balance';
    
            // Update the balance of the user's account
            $amount = $rowss['amount'];
            $updateQuery = "UPDATE user SET $accountType = $accountType + $amount WHERE user_unique_id = '".$userData['user_unique_id']."'";
            $updateResult = $this->runMysqliQuery($updateQuery);
            if($updateResult['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $updateResult['error'] ] ];
                header("location:../admin/user.php");
                return;
            }
        }
        header("location:../admin/user.php?success=$message");
    }
    function deleteUserT($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM user_transfer WHERE user_id  = '".$user_id."'";
            $message = "user transfer has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/user.php");
            return;
        }
        header("location:../admin/user.php?success=$message");
    }

    function AdminWallect(){
        $UserDetails = [];
        $query = "SELECT * FROM wallect";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
              //  print_r($row);die();
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function getsinglewallect($id) {
        $query = "SELECT * FROM wallect WHERE id = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function wallectUpdate(){
        $userid = $_SESSION['userid']=mysqli_real_escape_string($this->dbConnection, $_POST['userid']);
        $name = $_SESSION['name']=mysqli_real_escape_string($this->dbConnection, $_POST['name']);
       
        $thingsToValidate = [
            $name.'|Name|name',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/wallectUpdate.php?id=$userid");
            return;
        }

        $query = "UPDATE wallect SET wallect ='".$name."' WHERE id='".$userid."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../user/wallectUpdate.php");
            return;
        }

        header ("location:../admin/wallectUpdate.php?id=$userid&success=User Edit was successfully");

    }

    function allWire(){
        $UserDetails = [];
        $query = "SELECT * FROM wire_tranfer";
        $details = $this->runMysqliQuery($query);//run the query
        if($details['error_code'] == 1){
            return $details['error'];
        }
        $result = $details['data'];
        if(mysqli_num_rows($result) == 0){
            return 'No Data was returned';
        }else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails[] = $row;
            }
            return $UserDetails;
        }
    }
    function wireProcessing($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        $queryss = "SELECT * FROM wire_tranfer WHERE wire_id = '$user_id'";
        $detailsss = $this->runMysqliQuery($queryss);
        if ($detailsss['error_code'] == 1) {
            return $detailsss['error'];
        }
        $resultsss = $detailsss['data'];
        if(mysqli_num_rows($resultsss) == 0){
            return 'No Data was returned';
        } else {
            $rowss = mysqli_fetch_assoc($resultsss);
           // print_r($rowss);die();
            $account_number = $rowss['account_numble'];
        }
        if($status === 'Processing'){
            $query = "UPDATE wire_tranfer SET status = 'Complete' WHERE wire_id  = '".$user_id."'";
            $message = "wire tranfer has been complete successfully";
        } elseif ($status === 'Complete') {
            $query = "UPDATE wire_tranfer SET status = 'Processing' WHERE wire_id  = '".$user_id."'";
            $message = "wire tranfer has been processing successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/wire.php");
            return;
        }
        
        if ($status === 'Processing') {
            $userQuery = "SELECT * FROM user WHERE saving = '$account_number' OR current = '$account_number'";
            //print_r($userQuery);die();
            $userDetails = $this->runMysqliQuery($userQuery);
            if ($userDetails['error_code'] == 1) {
                $_SESSION['formError'] = ['general_error'=>[ $userDetails['error'] ] ];
                header("location:../admin/wire.php");
                return;
            }
            $userData = mysqli_fetch_assoc($userDetails['data']);
            
            $accountType = ($userData['saving'] == $account_number) ? 'saving_balance' : 'current_balance';
    
            // Update the balance of the user's account
            $amount = $rowss['amount'];
            $updateQuery = "UPDATE user SET $accountType = $accountType + $amount WHERE user_unique_id = '".$userData['user_unique_id']."'";
            $updateResult = $this->runMysqliQuery($updateQuery);
            if($updateResult['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $updateResult['error'] ] ];
                header("location:../admin/wire.php");
                return;
            }
        }
        header("location:../admin/wire.php?success=$message");
    }
    function deletewire($status){
        $query = "";
        $message = "";
        $user_id = mysqli_real_escape_string($this->dbConnection, $_POST['user_id']);
        if($status === 'delete'){
            $query = "DELETE FROM wire_tranfer WHERE wire_id  = '".$user_id."'";
            $message = "wire tranfer has been Delete successfully";
        }
    
        $result = $this->runMysqliQuery($query);
        if($result['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $result['error'] ] ];
            header("location:../admin/wire.php");
            return;
        }
        header("location:../admin/wire.php?success=$message");
    }
    function getlastlogin($user_unique_id) {
        $query = "SELECT * FROM logins WHERE user_unique_id = '$user_unique_id'  ORDER BY update_at DESC LIMIT 1";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
              // print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function forgetpassword(){

        $email = $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);

        $thingsToValidate = [
            $email.'|Email|email|empty',
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            //print_r( $_SESSION['formError']); die();
            header('location:../forgetpassword.php');
            return;
        }


        $query = "SELECT * FROM user WHERE email = '$email'";
        $details = $this->runMysqliQuery($query);
            if ($details['error_code'] == 1) {
            return $details['error'];
        } $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            $_SESSION['formError'] = ['general_error' => ['Email not Found']];
            header('location:../forgetpassword.php');
        }

        header ("location:../resetpassword.php?email=$email");

    }
    

    function resetpassword(){
        $email = $_SESSION['email']=mysqli_real_escape_string($this->dbConnection, $_POST['email']);
        $newpassword = $_SESSION['newpassword']=mysqli_real_escape_string($this->dbConnection, $_POST['newpassword']);
        $confirmpassword = $_SESSION['confirmpassword']=mysqli_real_escape_string($this->dbConnection, $_POST['confirmpassword']);


        $thingsToValidate = [
            $email.'|Email|email|empty',
            $newpassword.'|Newpassword|newpassword|empty',
            $confirmpassword.'|Confirmpassword|confirmpassword|empty'
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            // print_r( $_SESSION['formError']); die();
            header('location:../forgetpassword.php');
            return;
        }

        if ($newpassword !== $confirmpassword) {
            $_SESSION['formError'] = ['general_error' => ['New Password and Confirm New Password do not match']];
            header('location:../resetpassword.php');
            return;
        }

        $hashedPasword = $this->hasHer($newpassword);

        $query = "UPDATE user SET password='".$hashedPasword."' WHERE email='".$email."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../resetpassword.php");
            return;
        }

        header ('location:../login.php?&success=New_password was updated successfully');

    }

    function getsinglelocaltransfer($id) {
        $query = "SELECT * FROM local_tranfer WHERE local_id  = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function editLocal(){
        $id = $_SESSION['id']=mysqli_real_escape_string($this->dbConnection, $_POST['id']);
        $date = $_SESSION['date']=mysqli_real_escape_string($this->dbConnection, $_POST['date']);
        $thingsToValidate = [
            $date.'|Date|date',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/editDate.php?user=$id");
            return;
        }

        $query = "UPDATE local_tranfer SET created_at ='".$date."' WHERE local_id ='".$id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../admin/editDate.php");
            return;
        }

        header ("location:../admin/editDate.php?id=$id&success=User date was successfully Update");

    }

    function getsinglewiretransfer($id) {
        $query = "SELECT * FROM wire_tranfer WHERE wire_id  = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }
    function editDatewire(){
        $id = $_SESSION['id']=mysqli_real_escape_string($this->dbConnection, $_POST['id']);
        $date = $_SESSION['date']=mysqli_real_escape_string($this->dbConnection, $_POST['date']);
        $thingsToValidate = [
            $date.'|Date|date',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/editDatewire.php?user=$id");
            return;
        }

        $query = "UPDATE wire_tranfer SET created_at ='".$date."' WHERE wire_id ='".$id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../admin/editDatewire.php");
            return;
        }

        header ("location:../admin/editDatewire.php?id=$id&success=User date was successfully Update");

    }

    function getsingleselftransfer($id) {
        $query = "SELECT * FROM self_tranfer WHERE self_id = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }
    
    function editDateself(){
        $id = $_SESSION['id']=mysqli_real_escape_string($this->dbConnection, $_POST['id']);
        $date = $_SESSION['date']=mysqli_real_escape_string($this->dbConnection, $_POST['date']);
        $thingsToValidate = [
            $date.'|Date|date',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/editDateself.php?user=$id");
            return;
        }

        $query = "UPDATE self_tranfer SET created_at ='".$date."' WHERE self_id ='".$id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../admin/editDateself.php");
            return;
        }

        header ("location:../admin/editDateself.php?id=$id&success=User date was successfully Update");

    }

    function getsingleusertransfer($id) {
        $query = "SELECT * FROM user_transfer WHERE user_id = '$id'";
        $details = $this->runMysqliQuery($query);
    
        // Check for errors or no data found
        if ($details['error_code'] == 1) {
            return $details['error'];
        }
        $result = $details['data'];
        if (mysqli_num_rows($result) == 0) {
            return 'No Data was returned';
        } else{
            while($row = mysqli_fetch_object($result)){
                $UserDetails = $row;
               //print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function editDatewireuser(){
        $id = $_SESSION['id']=mysqli_real_escape_string($this->dbConnection, $_POST['id']);
        $date = $_SESSION['date']=mysqli_real_escape_string($this->dbConnection, $_POST['date']);
        $thingsToValidate = [
            $date.'|Date|date',
        ];

        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header("location:../admin/editDatewireuser.php?user=$id");
            return;
        }

        $query = "UPDATE user_transfer SET created_at ='".$date."' WHERE user_id ='".$id."' ";
        $back = $this->runMysqliQuery($query);
        if($back['error_code'] == 1){
            $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
            header("location:../admin/editDatewireuser.php");
            return;
        }

        header ("location:../admin/editDatewireuser.php?id=$id&success=User date was successfully Update");

    }

    



    


    
    

    
    
    
  


}
$for = new main_work();
?>