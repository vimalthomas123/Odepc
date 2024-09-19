<?php

function upload_resume( $file, $post_id = 0) {
  
  /*
  echo $filename;
  $wp_filetype = wp_check_filetype( basename($filename), null );
  $wp_upload_dir = wp_upload_dir();

  // Move the uploaded file into the WordPress uploads directory
  move_uploaded_file( $_FILES['file']['tmp_name'], $wp_upload_dir['path']  . '/' . $filename );

  $attachment = array(
      'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      'post_content' => '',
      'post_status' => 'inherit'
  );

  $filename = $wp_upload_dir['path']  . '/' . $filename;

  $attach_id = wp_insert_attachment( $attachment, $filename, 37 );
  update_field('field_5dde12d8c55a2', $attach_id, $post_id);
  */

}

add_action( 'wp_ajax_ajaxApplyJob', 'ajaxApplyJob' );
add_action( 'wp_ajax_nopriv_ajaxApplyJob', 'ajaxApplyJob' );
function ajaxApplyJob(){


  if(isset($_POST['captcha']) && !empty($_POST['captcha'])){ 
    $secretKey = '6LcD4sQUAAAAAHSRsK7nBONt0bkO-Fb6OFjfALfa'; 
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['captcha']); 
    $responseData = json_decode($verifyResponse); 
  
    if($responseData->success){ 
          
      // job detail
          $site_link = site_url();
          $jobTitle = $_POST['jobTitle'];
          $closingDate = $_POST['closingDateApply'];
          $salary = $_POST['salaryApply'];
          $offeredSalary = $_POST['offeredSalaryApply'];
          $carrerLevel = $_POST['carrerApply'];
          $experience = $_POST['experienceApply'];
          $gender = $_POST['genderPreferenceApply'];
          $industries = $_POST['industriesApply'];
          $qualifications = $_POST['qualificationsApply'];
          $jobDescription = $_POST['jobDescriptionApply'];
      // personal
          $firstName = $_POST['firstName'];
          $lastName = $_POST['lastName'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $resume = $_FILES['resume'];


          $applyJobId = strtoupper($jobTitle) . ' - ' . time();
          $post = array(
            'post_title'    => $applyJobId,
            'post_status'   => 'publish',   // Could be: publish
            'post_type' 	=> 'job_applicants' // Could be: `page` or your CPT
          );
          
          $postID = wp_insert_post($post);
          update_field('field_5dde57add90d2', $jobTitle, $postID);
          update_field('field_5dde12a6c559d', $firstName, $postID);
          update_field('field_5dde12b7c559e', $lastName, $postID);
          update_field('field_5dde12bec559f', $email, $postID);
          update_field('field_5dde12cbc55a0', $phone, $postID);

          require_once( ABSPATH . 'wp-admin/includes/file.php');
          $uploadedfile = $_FILES['resume'];
          $movefile = wp_handle_upload($uploadedfile, array('test_form' => false));


          if ($movefile) {
            $wp_upload_dir = wp_upload_dir();

            $attachment = array(
              'guid' => $wp_upload_dir['url'] . '/' . basename( $movefile['file'] ), 
              'post_mime_type' => $wp_filetype['type'],
              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $movefile['file']) ),
              'post_content' => '',
              'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $movefile['file']);
            update_field('field_5dde12d8c55a2', $attach_id, $postID);
          }

          if($postID){

            $resume_url = get_field('resume', $postID);
            $attachment = array( $resume_url );

            // Mail to Admin
            $admin_email = get_option('admin_email');
            $to1 = $admin_email;
            $headers1  = "MIME-Version: 1.0" . "\r\n";
            $headers1 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers1 .= "From: ODEPC - Job Application  <info@odepc.in> \r\n";
            $headers1 .= "Reply-To: info@odepc.in \r\n";
            $subject1 = "Job Applications";

            $email_body1 .="<table style='background-color:#eee;width: 100%'>
            <tr>
            <td style='padding:100px 0px'>
                <table align='center' cellpadding='0' cellspacing='0' style='width:800px;' bgcolor='#fff';>
                  <tr>
                  <td><img src='".$site_link."wp-content/uploads/2019/11/header-img.jpg'></td>
                  </tr>
                  <tr>
                    <tr>
                    <td style='padding:65px 80px 40px 80px;'>
                    <font size='4' face='gotham medium' color='#000'>Hi ".$admin_email."</font>
                    </td>
                    </tr>
                    <tr>
                    <td style='padding:0 80px;line-height: 25px;'>
                    <font size='5' face='gotham book' line-height='18px' color='#26247b'>
                    You have requested a Job Application at ODEPC.
                    </font>
                    </td>
                    </tr>
                    <tr>
                    <td style='padding:35px 80px 35px 80px;line-height: 25px;'>
                    <font size='4pt' face='gotham medium' color='#000'>
                      Request from Job Application - ODEPC.
                    </font>
                    </td>
                    </tr>
                    <tr>
                    <td style='padding:0 85px 60px;line-height: 25px;'>
                    <font size='4pt' face='gotham book' color='#000'>Our Representative will contact you shortly to confirm the job application,Your Job Application request details are as follows:
                    </td>
                    </tr>
                  <tr>
              <td style='padding: 0 85px 20px;'>
              <table width='400px'>
                <tr>
                  <td style='padding-bottom: 10px;'><font size='4' face='gotham medium' color='#000'>Personal Details</font></td>
                </tr>
                <tr>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>First Name</font></td>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$firstName."</font></td>
                </tr>
                <tr>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Last Name</font></td>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$lastName."</font></td>
                </tr>
                <tr>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Email</font></td>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$email."</font></td>
                </tr>
                <tr>
                  <td><font size='3' face='gotham book' color='#000'>Phone Number</font></td>
                  <td><font size='3' face='gotham medium' color='#000'>".$phone."</font></td>
                </tr>
              </table>
              </td>
              </tr>
                  <tr>
              <td style='padding: 0 85px 20px;'>
              <table width='600px'>
                <tr>
                  <td style='padding-top: 15px;padding-bottom: 10px;'><font size='4' face='gotham medium' color='#000'>Job Details</font></td>
                </tr>
                <tr>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Job Name</font></td>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$jobTitle."</font></td>
                </tr>
                <tr>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Salary</font></td>
                  <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$salary."</font></td>
                </tr>
                <tr>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Carrer Level</font></td>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$carrerLevel."</font></td>
                </tr>
                <tr>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'> Experience </font></td>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$experience."</font></td>
                </tr>
                <tr>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Gender</font></td>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$gender."</font></td>
                </tr>
                <tr>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Qualifications</font></td>
                <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$qualifications."</font></td>
                </tr>
                <tr>
                  <td><font size='3' face='gotham book' color='#000'> Offered Salary </font></td>
                  <td><font size='3' face='gotham medium' color='#000'>".$offeredSalary."</font></td>
                </tr>
              
              </table>
              </td>
              </tr>
                  <tr>
                  <td style='padding:0 85px 20px;'>
                  <font size='4' face='gotham medium' color='#000'>Job Description :</font>
                  </td>
                  </tr>
                  <tr>
                  <td style='padding:0 85px 100px;line-height: 25px'><font size='3' face='gotham book' color='#000'>".$jobDescription."</font>
                  </td>
                  </tr>
              
                  <tr>
                  <td style='padding: 0 85px 15px;'>
                  <hr>
                  </td>
                  </tr>
                  <tr>
                  <td style='padding:0 85px 5px;'><font size='2' face='gotham book' color='#4c4c4c'>This e-mail was sent from a Plan Your Trip on ODEPC</font><font size='2' face='gotham book' color='#26247b'> (http://odepc.kerala.gov.in)</font></td>
                  </tr>
                  <tr>
                  <td style='padding:0 85px 65px;'><font size='2' face='gotham book' color='#26247b'>Copyright © 2019 ODEPC- A Government of Kerala Undertaking. All rights reserved</font></td>
                  </tr>
                  </tr>
                </table>
           </td>
           </tr>
          </table>";
            // $email_body1 .="Resume: " .$resume. "<br>";

            $mail1 = wp_mail($to1, $subject1, $email_body1, $headers1, $attachment);

            // Mail to Patient
            $to2 = $email;
            $headers2  = "MIME-Version: 1.0" . "\r\n";
            $headers2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers2 .= "From: ODEPC - Job Application  <info@odepc.in> \r\n";
            $headers2 .= "Reply-To: info@odepc.in \r\n";
            $subject2 = "ODEPC - Job Application";

             // job detail
             $jobTitle = $_POST['jobTitle'];
             $closingDate = $_POST['closingDateApply'];
             $salary = $_POST['salaryApply'];
             $offeredSalary = $_POST['offeredSalaryApply'];
             $carrerLevel = $_POST['carrerApply'];
             $experience = $_POST['experienceApply'];
             $gender = $_POST['genderPreferenceApply'];
             $industries = $_POST['industriesApply'];
             $qualifications = $_POST['qualificationsApply'];
             $jobDescription = $_POST['jobDescriptionApply'];
            // personal
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $resume = $_FILES['resume'];

             $email_body2 .="<table style='background-color:#eee;width: 100%'>
             <tr>
             <td style='padding:100px 0px'>
                 <table align='center' cellpadding='0' cellspacing='0' style='width:800px;' bgcolor='#fff';>
                   <tr>
                   <td><img src='".$site_link."/wp-content/uploads/2019/11/header-img.jpg'></td>
                   </tr>
                   <tr>
                     <tr>
                     <td style='padding:65px 80px 40px 80px;'>
                     <font size='4' face='gotham medium' color='#000'>Hi ".ucfirst($firstName)."</font>
                     </td>
                     </tr>
                     <tr>
                     <td style='padding:0 80px;line-height: 25px;'>
                     <font size='5' face='gotham book' line-height='18px' color='#26247b'>
                     You have requested a Job Application at ODEPC.
                     </font>
                     </td>
                     </tr>
                     <tr>
                     <td style='padding:35px 80px 35px 80px;line-height: 25px;'>
                     <font size='4pt' face='gotham medium' color='#000'>
                       Request from Job Application - ODEPC.
                     </font>
                     </td>
                     </tr>
                     <tr>
                     <td style='padding:0 85px 60px;line-height: 25px;'>
                     <font size='4pt' face='gotham book' color='#000'>Our Representative will contact you shortly to confirm the job application,Your Job Application request details are as follows:
                     </td>
                     </tr>
                   <tr>
               <td style='padding: 0 85px 20px;'>
               <table width='400px'>
                 <tr>
                   <td style='padding-bottom: 10px;'><font size='4' face='gotham medium' color='#000'>Personal Details</font></td>
                 </tr>
                 <tr>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>First Name</font></td>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$firstName."</font></td>
                 </tr>
                 <tr>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Last Name</font></td>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$lastName."</font></td>
                 </tr>
                 <tr>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Email</font></td>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$email."</font></td>
                 </tr>
                 <tr>
                   <td><font size='3' face='gotham book' color='#000'>Phone Number</font></td>
                   <td><font size='3' face='gotham medium' color='#000'>".$phone."</font></td>
                 </tr>
               </table>
               </td>
               </tr>
                   <tr>
               <td style='padding: 0 85px 20px;'>
               <table width='600px'>
                 <tr>
                   <td style='padding-top: 15px;padding-bottom: 10px;'><font size='4' face='gotham medium' color='#000'>Job Details</font></td>
                 </tr>
                 <tr>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Job Name</font></td>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$jobTitle."</font></td>
                 </tr>
                 <tr>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Salary</font></td>
                   <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$salary."</font></td>
                 </tr>
                 <tr>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Carrer Level</font></td>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$carrerLevel."</font></td>
                 </tr>
                 <tr>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'> Experience </font></td>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$experience."</font></td>
                 </tr>
                 <tr>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Gender</font></td>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>". $gender ."</font></td>
                 </tr>
                 <tr>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham book' color='#000'>Qualifications</font></td>
                 <td style='padding-bottom: 5px;'><font size='3' face='gotham medium' color='#000'>".$qualifications."</font></td>
                 </tr>
                 <tr>
                   <td><font size='3' face='gotham book' color='#000'> Offered Salary </font></td>
                   <td><font size='3' face='gotham medium' color='#000'>".$offeredSalary."</font></td>
                 </tr>
               
               </table>
               </td>
               </tr>
                   <tr>
                   <td style='padding:0 85px 20px;'>
                   <font size='4' face='gotham medium' color='#000'>Job Description :</font>
                   </td>
                   </tr>
                   <tr>
                   <td style='padding:0 85px 100px;line-height: 25px'><font size='3' face='gotham book' color='#000'>".$jobDescription."</font>
                   </td>
                   </tr>
               
                   <tr>
                   <td style='padding: 0 85px 15px;'>
                   <hr>
                   </td>
                   </tr>
                   <tr>
                   <td style='padding:0 85px 5px;'><font size='2' face='gotham book' color='#4c4c4c'>This e-mail was sent from a Plan Your Trip on ODEPC</font><font size='2' face='gotham book' color='#26247b'> (http://odepc.kerala.gov.in)</font></td>
                   </tr>
                   <tr>
                   <td style='padding:0 85px 65px;'><font size='2' face='gotham book' color='#26247b'>Copyright © 2019 ODEPC- A Government of Kerala Undertaking. All rights reserved</font></td>
                   </tr>
                   </tr>
                 </table>
            </td>
            </tr>
           </table>";
            // $email_body2 .="Resume: " .$resume. "<br>";

            $mail2 = wp_mail($to2, $subject2, $email_body2, $headers2, $attachment);

            if($mail1 && $mail2) {
              echo 'SUCCESS';
            } else {
              echo 'Unable to send mail. Please try again later.';
            }

          } else {
            echo 'Unable to process. Please try again later.';
          }

    } else {
      echo 'Robot verification failed, please try again.';
    }

  } else { 
    echo 'Please check on the reCAPTCHA box.'; 
  } 

  die();
}