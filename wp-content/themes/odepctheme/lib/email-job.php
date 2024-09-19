<?php

add_action( 'wp_ajax_ajaxEmailJob', 'ajaxEmailJob' );
add_action( 'wp_ajax_nopriv_ajaxEmailJob', 'ajaxEmailJob' );

function ajaxEmailJob(){
  if(isset($_POST['captcha']) && !empty($_POST['captcha'])){ 
  $secretKey = '6LcFLPYUAAAAAL8QpADn66KpNkOi1xv5ZmfdAAR7';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['captcha']); 
  $responseData = json_decode($verifyResponse); 

    if($responseData->success){ 

        $site_link = site_url();
        $user_name = $_REQUEST['user_name'];
        $user_email = $_REQUEST['user_email'];
        $jobTitle = $_REQUEST['jobTitle'];
        $closingDate = $_REQUEST['closingDate'];
        $salary = $_REQUEST['salary'];
        $offeredSalary = $_REQUEST['offeredSalary'];
        $carrerLevel = $_REQUEST['carrerLevel'];
        $experience = $_REQUEST['experience'];
        $gender = $_REQUEST['genderPreference'];
        $industries = $_REQUEST['industries'];
        $qualifications = $_REQUEST['qualifications'];
        $jobDescription = $_REQUEST['jobDescription'];

          $to = $user_email;
          $header = "MIME-Version: 1.0" . "\r\n";
          $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $header .= "From: ODEPC - Email this Job  <info@odepc.in> \r\n";
          $header .= "Reply-To: info@odepc.in \r\n";
          $subject = "Email this Job - " . $jobTitle;

          $email_body = "<h4>ODEPC Job Details. </h4>".

          $email_body .="Job Title: " .$jobTitle. "<br>";
          $email_body .="Closing Date: " .$closingDate. "<br><br>";
          
          $email_body .="<table style='background-color:#eee;width: 100%'>
          <tr>
          <td style='padding:100px 0px'>
          <table align='center' cellpadding='0' cellspacing='0' style='width:800px;' bgcolor='#fff';>
            <tr>
            <td><img src='".$site_link."/wp-content/uploads/2019/11/header-img.jpg'></td>
            </tr>
            <tr>
            <tr>
            <td style='padding:65px 80px 40px 80px;'>
            <font size='4' face='gotham medium' color='#000'>Hi ".ucfirst($user_name)." (".$user_email.")</font>
            </td>
            </tr>
            <tr>
            <td style='padding:0 80px;line-height: 25px;'>
            <font size='5' face='gotham book' line-height='18px' color='#26247b'>Here are the details of the job you have requested</font>
            </td>
            </tr>

            <tr>
              <td style='padding: 0 80px 80px;'>
              <table cellpadding='10'  bgcolor='#FFFFFC' border='' style='width:100%;text-align:left;border-collapse:collapse;'>
                      <tr>
                        <th colspan='3'>" .$jobTitle. "</th>
                        <th colspan='3'> Salary : " .$salary. "</th>
                      </tr>
                      <tr>
                        <th>Offered Salary</th>
                        <th>Career Level</th>
                        <th>Experience</th>
                        <th>Gender Preference</th>
                        <th>Industry</th>
                        <th>Qualifications</th>
                      </tr>
                      <tr>
                        <td>" .$offeredSalary. "</td>
                        <td>" .$carrerLevel. "</td>
                        <td>" .$experience. "</td>
                        <td>" .$gender. "</td>
                        <td>" .$industries. "</td>
                        <td>" .$qualifications. "</td>
                      </tr>
                      <tr>
                        <th colspan='6'>" .$jobDescription. "</th>
                      </tr>
                    </table>
              </td>
            </tr>
        
            <tr>
            <td style='padding: 0 85px 15px;'>
            <hr>
            </td>
            </tr>
            <tr>
            <td style='padding:0 85px 5px;'><font size='2' face='gotham book' color='#4c4c4c'>This e-mail was sent from a Plan Your Trip on ODEPC</font><font size='2' face='gotham book' color='#26247b'> (http://odepc.kerala.gov.in/)</font></td>
            </tr>
            <tr>
            <td style='padding:0 85px 65px;'><font size='2' face='gotham book' color='#26247b'>Copyright © 2019 ODEPC- A Government of Kerala Undertaking. All rights reserved</font></td>
            </tr>
            </tr>
          </table>
          </td>
          </tr>
        </table>";
          // $email_body .="Full Name: " .$user_name. "<br>";
          // $email_body .="User Email: " .$user_email. "<br>";
          // $email_body1 .="Resume: " .$resume. "<br>";

          $mail = wp_mail($to, $subject, $email_body, $header);

    

          if($mail) {
            echo 'SUCCESS';
          } else {
            echo 'Unable to send mail. Please try again later.';
          }
    } else {
      echo 'Robot verification failed, please try again.';
    }

  } else { 
    echo 'Please check on the reCAPTCHA box.'; 
  } 

  die();
}