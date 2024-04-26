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
        // print_r($query); die();


        $result = $this->runMysqliQuery($query); 
        if ($result['error_code'] == 1){
            $_SESSION['formError']=['general_error' =>[$result['error']] ];
            header('location:../register.php');
            return;
        }
            // Send email
        $to = $email;
        $subject = 'Registration Successful';
        $message = 'Dear '.$name.',<br><br>Your registration was successful.<br><br>Thank you!';
        $headers = "From: your_email@example.com\r\n";
        $headers .= "Reply-To: your_email@example.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);

    
        header("location:../pincode.php?success=Register was successful");
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
        $thingsToValidate = [
            $idnumber.'|Idnumber|idnumber|empty',
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

        $query = "UPDATE user SET id_front = '".$id_front."',id_back = '".$id_back."',proof_address = '".$proof_address."',id_number = '".$idnumber."' WHERE user_unique_id = '$user_unique_id'";
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

        //print_r($account);die();

        
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
       // print_r($query); die();
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
        $account_number = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $account_name = $_SESSION['account_name']=mysqli_real_escape_string($this->dbConnection, $_POST['account_name']);
        $details = $_SESSION['details']=mysqli_real_escape_string($this->dbConnection, $_POST['details']);

        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $bank_name.'|Bank name|bank_name|empty',
            $account_number.'|Account number|account_number|empty',
            $account_name.'|Account name|account_name|empty',
            $details.'|Details|details|empty',
        ];
        $validationStatus = $this->callValidation($thingsToValidate);
        if($validationStatus === false){
            $_SESSION['formError'] = $this->errors;
            header('location:../user/domestic.php');
            return;
        }
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        $account_number = substr($account, 1, 11);
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
    
    
            $query = "INSERT INTO local_tranfer (id,local_id,amount,account,bank_name,account_numble,account_name,details,Refrence_id,user_unique_id)
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_number."','".$account_name."','".$details."','".$local_id."','".$user_unique_id."')";
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
            
            header ('location:../user/domestic.php?&success=Tranfer was successfully');
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
    
    
            $query = "INSERT INTO local_tranfer (id,local_id,amount,account,bank_name,account_numble,account_name,details,Refrence_id,user_unique_id)
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_number."','".$account_name."','".$details."','".$local_id."','".$user_unique_id."')";
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
            
            header ('location:../user/domestic.php?&success=Tranfer was successfully');
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
        $account_number = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $account_name = $_SESSION['account_name']=mysqli_real_escape_string($this->dbConnection, $_POST['account_name']);
        $bank_country = $_SESSION['bank_country']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_country']);
        $bank_code = $_SESSION['bank_code']=mysqli_real_escape_string($this->dbConnection, $_POST['bank_code']);
        $details = $_SESSION['details']=mysqli_real_escape_string($this->dbConnection, $_POST['details']);

        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $account_type.'|Account Type|account_type|empty',
            $bank_name.'|Bank name|bank_name|empty',
            $account_number.'|Account number|account_number|empty',
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
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        $account_number = substr($account, 1, 11);

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


        $query = "INSERT INTO wire_tranfer (id,wire_id,amount,account,account_type,bank_name,account_numble,account_name,details,bank_code,Refrence_id,user_unique_id)
        VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_type."','".$account_number."','".$account_name."','".$details."','".$bank_code."','".$local_id."','".$user_unique_id."')";
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

        header ('location:../user/wire.php?&success=Tranfer was successfully');


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
            VALUES (null,'".$local_id."', '".$amount."','".$account."','".$bank_name."','".$account_type."','".$account_number."','".$account_name."','".$details."','".$bank_code."','".$local_id."','".$user_unique_id."')";
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

            header ('location:../user/wire.php?&success=Tranfer was successfully');


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
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        $account_number = substr($from_account, 1, 11);
        $to_accou = substr($to_account, 1, 11);
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
    
    
            $query = "INSERT INTO self_tranfer (id,self_id,amount,account,to_account,Refrence_id,user_unique_id)
            VALUES (null,'".$self_id."', '".$amount."','".$from_account."','".$to_account."','".$self_id."','".$user_unique_id."')";
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
            
            $query = "UPDATE user SET saving_balance='".$total."',current_balance='".$ccurentTotal."'WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/self.php");
                return;
            }
    
            header ('location:../user/self.php?&success=Tranfer was successfully');

        }

        if($current == $account_number){
            $ass = $this->getsingledetail($user_unique_id);
            $fee = $this->feeself();
            $balance = $ass->current_balance;
            $subTotal = ($fee/100)*$amount;
            $sumTotal = $balance - $subTotal;
            $total = $sumTotal - $amount;
            //print_r($total);die();
    
            if ($total < 0) {
                $_SESSION['formError'] = ['general_error' => ['Insufficient balance.']];
                header('location:../user/self.php');
                return;
            }
    
            $self_id = $this->createUniqueID('self_tranfer', 'self_id');
    
    
            $query = "INSERT INTO self_tranfer (id,self_id,amount,account,to_account,Refrence_id,user_unique_id)
            VALUES (null,'".$self_id."', '".$amount."','".$from_account."','".$to_account."','".$self_id."','".$user_unique_id."')";
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
            
            $query = "UPDATE user SET current_balance='".$total."',saving_balance='".$savingTotal."'WHERE user_unique_id='".$user_unique_id."' ";
            $back = $this->runMysqliQuery($query);
            if($back['error_code'] == 1){
                $_SESSION['formError'] = ['general_error'=>[ $back['error'] ]];
                header("location:../user/self.php");
                return;
            }
    
            header ('location:../user/self.php?&success=Tranfer was successfully');

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
        $account_number = $_SESSION['account_number']=mysqli_real_escape_string($this->dbConnection, $_POST['account_number']);
        $pincode= $_SESSION['pincode']=mysqli_real_escape_string($this->dbConnection, $_POST['pincode']);


        $thingsToValidate = [
            $amount.'|Amount|amount|empty',
            $account.'|Account|account|empty',
            $account_number.'|Account Number|account_number|empty',
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
        $user_unique_id = $_SESSION['user_unique_id'];
        $current = $_SESSION['current'];
        $saving = $_SESSION['saving'];
        $account_number = substr($account, 1, 11);
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
    
    
            $query = "INSERT INTO user_transfer (id,user_id,amount,account,account_number,Refrence_id,user_unique_id)
            VALUES (null,'".$user_id."', '".$amount."','".$account."','".$account_number."','".$user_id."','".$user_unique_id."')";
           // print_r($query); die();
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
    
            header ('location:../user/user.php?&success=Tranfer was successfully');

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
            VALUES (null,'".$user_id."', '".$amount."','".$account."','".$account_number."','".$user_id."','".$user_unique_id."')";
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
    
            header ('location:../user/user.php?&success=Tranfer was successfully');

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
        

        $card_id = $this->createUniqueID('card', 'card_id');


        $query = "INSERT INTO card (id,card_id,account,user_unique_id)
        VALUES (null,'".$card_id."','".$account."','".$user_unique_id."')";
       // print_r($query); die();
       $result = $this->runMysqliQuery($query); 
       if ($result['error_code'] == 1){
           $_SESSION['formError']=['general_error' =>[$result['error']] ];
           header('location:../user/card.php');
           return;
       }
        

        header ('location:../user/card.php?&success=card was successfully');

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
//                print_r($UserDetails);die();
            }
            return $UserDetails;
        }
    }

    function toggleStatus() {
        // Check if the status is set in the POST data
        if(isset($_POST['status'])) {
            // Get the current status from the POST data
            $currentStatus = $_POST['status'];
            $user_unique_id = $_SESSION['user_unique_id'];
            
            $newStatus = ($currentStatus === 'suspended') ? 'active' : 'suspended';
            
            $query = "UPDATE user SET status = '$newStatus' WHERE user_unique_id = '$user_unique_id'";
            
            $result = $this->runMysqliQuery($query); 
            if ($result['error_code'] == 1){
                $_SESSION['formError']=['general_error' =>[$result['error']] ];
                header('location:../admin/dashborad.php');
                return;
            }
            
            // Send the new status back to the client as JSON response
            echo json_encode(array('newStatus' => $newStatus));
        } else {
            // Handle the case when the status is not set
            echo json_encode(array('error' => 'Status not provided'));
        }
    }



    


    
    

    
    
    
  


}
$for = new main_work();
?>