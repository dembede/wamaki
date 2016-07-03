<?php 

ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
    
if(isset($_REQUEST['company_name'])){

	function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    
    $email_message = "Enquiry details below.\n\n";
    if(isset($_REQUEST['form'])){
        $form = clean_string($_REQUEST['form']);
        $form_title = "Form ".$form.": ";
        switch ($form) {
            case 'A':
                $form_title .= "Does not have a Chase Account and Does not have a Till Number. Requires account to be opened and be set up on Mfukoni!";
                break;
            case 'B':
                $form_title .= "Does not have a Chase Account and has a Till Number. Requires account to be opened riding on Safaricom KYC and be setup on Mfukoni!";
                break;
            case 'C':
                $form_title .= "Has a Chase Account but is not registered on Mfukoni. Requires to self-register for Mfukoni!";
                break;
            case 'D':
                $form_title .= "Has a Chase Account but is inactive on Mfukoni. Requires a pin reset for Mfukoni!";
                break;
            case 'E':
                $form_title .= "Has a Chase Account and is Active on Mfukoni!";
                break;
        }
        $email_message .= $form_title."\n";  
    }
    
    /*---- Business info -----*/
    $email_message .= "\n---- BUSINESS INFO ---- \n";
    $company_name = $_REQUEST['company_name'];
    $email_message .= "Company Name: ".clean_string($company_name)."\n";
    
    if(isset($_REQUEST['address'])){
        $address = $_REQUEST['address'];
        $email_message .= "Company Address: ".clean_string($address)."\n";  
    }
    if(isset($_REQUEST['nature'])){
        $nature = $_REQUEST['nature'];
        $email_message .= "Nature of Business: ".clean_string($nature)."\n";  
    }
    if(isset($_REQUEST['turnover'])){
        $turnover = $_REQUEST['turnover'];
        $email_message .= "Turnover: ".clean_string($turnover)."\n";  
    }
    if(isset($_REQUEST['business_no'])){
        $business_no = $_REQUEST['business_no'];
        $email_message .= "Business Reg. No.: ".clean_string($business_no)."\n";  
    }
    if(isset($_REQUEST['ac_number'])){
        $ac_number = $_REQUEST['ac_number'];
        $email_message .= "Account No.: ".clean_string($ac_number)."\n";  
    }
    
    /*---- Director's info -----*/
    $email_message .= "\n---- DIRECTOR'S INFO ----\n";
    if(isset($_REQUEST['director_fname'])){
        $director_fname = $_REQUEST['director_fname'];
        $email_message .= "First Name: ".clean_string($director_fname)."\n";  
    }
    if(isset($_REQUEST['director_mname'])){
        $director_mname = $_REQUEST['director_mname'];
        $email_message .= "Middle Name: ".clean_string($director_mname)."\n";  
    }
    if(isset($_REQUEST['director_lname'])){
        $director_lname = $_REQUEST['director_lname'];
        $email_message .= "Last Name: ".clean_string($director_lname)."\n";  
    }
    if(isset($_REQUEST['director_email'])){
        $director_email = $_REQUEST['director_email'];
        $email_message .= "Email: ".clean_string($director_email)."\n";  
    }
    if(isset($_REQUEST['director_tel'])){
        $director_tel = $_REQUEST['director_tel'];
        $email_message .= "Mobile No.: ".clean_string($director_tel)."\n";  
    }
    if(isset($_REQUEST['director_id'])){
        $director_id = $_REQUEST['director_id'];
        $email_message .= "ID No.: ".clean_string($director_id)."\n";  
    }
    if(isset($_REQUEST['gender'])){
        $gender = $_REQUEST['gender'];
        $email_message .= "Gender: ".clean_string($gender)."\n";  
    }
    
    /*---- Other info -----*/
    
    $email_message .= "\n---- ADDITIONAL INFO ----\n ";
    
    if(isset($_REQUEST['association'])){
        $association = $_REQUEST['association'];
        $email_message .= "Preferred Branch of Association: ".clean_string($association)."\n";  
    }
    if(isset($_REQUEST['account_type'])){
        $account_type = $_REQUEST['account_type'];
        $email_message .= "Preferred Account Type: ".clean_string($account_type)."\n";  
    }
    if(isset($_REQUEST['till_no'])){
        $till_no = $_REQUEST['till_no'];
        $email_message .= "Till Number: ".clean_string($till_no)."\n";  
    }
    if(isset($_REQUEST['reuse_details'])){
        $reuse_details = $_REQUEST['reuse_details'];
        $email_message .= "Reuse KYC details from Safaricom: ".clean_string($reuse_details)."\n";  
    }
    if(isset($_REQUEST['get_number'])){
        $get_number = $_REQUEST['get_number'];
        $email_message .= "Number Requested: ".clean_string($get_number)."\n";  
    }
    if(isset($_REQUEST['paybill_number'])){
        $paybill_number = $_REQUEST['paybill_number'];
        $email_message .= "Pay Bill Number: ".clean_string($paybill_number)."\n";  
    }
    if(isset($_REQUEST['buygoods_number'])){
        $buygoods_number = $_REQUEST['buygoods_number'];
        $email_message .= "Buy Goods Number: ".clean_string($buygoods_number)."\n";  
    }
    if(isset($_REQUEST['agenttill_number'])){
        $agenttill_number = $_REQUEST['agenttill_number'];
        $email_message .= "Agent Till Number: ".clean_string($agenttill_number)."\n";  
    }

    // Pear Mail Library
    require_once "Mail.php";

    $from = "Mobile2Bank <atyourservice@chasebank.co.ke>";
    $to = "marketingchasebank@gmail.com, cmaloba@chasebank.co.ke, lwambui@chasebank.co.ke, mobile2bank@chasebank.co.ke";
    $cc = "cmaloba@chasebank.co.ke, lwambui@chasebank.co.ke, anyenjeri@chasebank.co.ke";
    $subject = "Mobile2Bank - Submission from Website";

    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject
    );

    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'marketingchasebank@gmail.com',
            'password' => '{U9Y89DHwE'			
        ));

    $mail = $smtp->send($to, $headers, $email_message);

    if (PEAR::isError($mail)) {
        echo('<p>' . $mail->getMessage() . '</p>');
    } else {
        echo('<p>Message successfully sent!</p>');
    }

?>
	  

<?php
}
die();
?>


