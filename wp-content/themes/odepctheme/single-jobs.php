<?php
get_header(); 
// acf_form_head();
?>

<?php
while ( have_posts() ) : the_post();
global $post;
gt_set_post_view();

$title = get_the_title();
$closing_date = get_field('closing_date');
$publish_date = $post->post_date;
$locations = get_the_term_list( $post->ID, 'locations', '', ', ' );
$industries = get_the_term_list( $post->ID, 'industries', '', ', ' );
$ind_terms = wp_get_post_terms($post->ID, 'industries');
$types = get_the_terms( $post->ID , 'types' );
$salary = get_field('salary');
$offered_salary = get_field('offered_salary');
$carrer_level = get_field('carrer_level');
$experience = get_field('experience');
$gender_preference = get_field('gender_preference');
$qualifications = get_field('qualifications');
$job_description = get_field('job_description');
$apply_job_url = get_field('apply_job_url');

$indname = array();
    foreach($ind_terms as $ind_term)
    {
        $indname[] = $ind_term->name;
    }
?>

<section id="job-strip">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo site_url(); ?>/jobs" class="btn-icon right-icon"><i class="fas fa-arrow-left"></i>Back to All Jobs</a>
                <div class="card-strip">
                    <div class="card-strip-body">
                        <h3 class="card-strip-title"><?php echo get_the_title(); ?></h3>
                        <div class="label-wrap">

                        <?php 
                        if($types):
                        $i = 1;
                        foreach ( $types as $term ) {
                          $term_link = get_term_link( $term, array( 'types') );
                          if( is_wp_error( $term_link ) )
                          continue;
                          echo '<a class="badge ' .$term->slug . ' ' .getBadgeClass($term->slug). '" href="' . $term_link . '">' . strtoupper($term->name) . '</a>';
                          echo ($i < count($types))? ", " : "";
                          $i++;
                        }
                        ?>
                        <?php else: ?>
                        <span class="badge badge-secondary">OTHERS</span>
                        <?php endif; ?>
                        
                        <p>Posted <?php echo timeago($publish_date); ?> In <?php echo $industries; ?> </p>
                        </div>
                        <ul class="top-margin-sm">

                          <?php if($locations): ?>
                          <li>
                            <i class="flaticon flaticon-placeholder-3"></i>
                            <?php echo $locations; ?>
                          </li>
                          <?php endif;?>

                          <?php if($publish_date || $closing_date): ?>
                          <li>
                          
                            <?php if($publish_date):?>
                            <i class="flaticon flaticon-calendar-5"></i>Post Date: <?php echo  date('d F, Y', strtotime($publish_date)); ?> - 
                            <?php endif;?>
                            <?php if($closing_date): ?>
                            <span class="danger">Closing Date : <?php echo date("d F, Y", strtotime($closing_date)); ?></span>
                            <?php endif;?>
                          </li>
                          <?php endif;?>

                          <?php if($salary): ?>
                          <li>
                            <i class="flaticon flaticon-briefcase"></i>Salary: <?php echo $salary; ?>
                          </li>
                          <?php endif; ?>
                        </ul>
                    </div>
                    <div class="card-strip-footer">
                           <?php
                      //$date = new DateTime( $start_date );
                      $today = date("Ymd");
                      $date = strtotime($closing_date);
                      $now = strtotime($today);

                      $isPastJob = $date < $now;
                      if(!$isPastJob):

                      ?>
                        <div class="card-strip-footer-item">
                          <?php if($apply_job_url != ''){ ?>
                            <a href="<?php echo $apply_job_url; ?>" class="btn btn-danger btn-xlg btn-block" target="_blank">Apply for this Job</a>
                          <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-xlg btn-block" data-toggle="modal" data-target="#applyJobForm">Apply for this Job</button>
                          <?php } ?>
                          <div class="modal fade" id="applyJobForm" tabindex="-1" role="dialog" aria-labelledby="applyJobFormLabel"
                              aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title" id="exampleModalLabel">Job Application Form</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true" class="flaticon-multiply"></span>
                                          </button>
                                      </div>
                                      <div class="modal-body">

                                        <?php
                                        /*
                                        $fields = array(
                                          'field_5dde57add90d2',
                                          'field_5dde12a6c559d',
                                          'field_5dde12b7c559e',
                                          'field_5dde12bec559f',
                                          'field_5dde12cbc55a0',
                                          'field_5dde12d8c55a2'
                                        );
                                        acf_register_form(array(
                                          'id'		    	=> 'new-job-application',
                                          'post_id'	    	=> 'job_application',
                                          'job_application'			=> array(
                                            'post_type'		=> 'job_applicants',
                                            'post_status'	=> 'draft'
                                          ),
                                          'post_title'		=> false,
                                          'post_content'  	=> false,
                                          'uploader'      	=> 'basic',
                                          'return'			=> home_url('thank-your-for-submitting-your-recipe'),
                                          'fields'				=> $fields,
                                          'submit_value'		=> 'Apply Job'
                                        ));
                                        acf_form('new-job-application');
                                        */
                                        ?>

                                        <script src="https://www.google.com/recaptcha/api.js?onload=reCaptchaCallback&render=explicit" async defer></script>
                                        <form id="applyJob" name="applyJob" type="POST" enctype="multipart/form-data" >

                                            <input type="hidden" id="jobTitle" name="jobTitle" value="<?php echo $title; ?>">
                                            <input type="hidden" id="closingDateApply" name="closingDateApply" value="<?php echo $closing_date; ?>">
                                            <input type="hidden" id="salaryApply" name="salaryApply" value="<?php echo $salary; ?>">
                                            <input type="hidden" id="offeredSalaryApply" name="offeredSalaryApply" value="<?php echo $offered_salary; ?>">
                                            <input type="hidden" id="carrerApply" name="carrerApply" value="<?php echo $carrer_level; ?>">
                                            <input type="hidden" id="experienceApply" name="experienceApply" value="<?php echo $experience; ?>">
                                            <input type="hidden" id="genderPreferenceApply" name="genderPreferenceApply" value="<?php echo $gender_preference; ?>">
                                            <input type="hidden" id="qualificationsApply" name="qualificationsApply" value="<?php echo $qualifications; ?>">
                                            <input type="hidden" id="industriesApply" name="industriesApply" value="<?php echo $indname[0]; ?>">
                                            <input type="hidden" id="jobDescriptionApply" name="jobDescriptionApply" value="<?php echo $job_description; ?>">

                                          <div class="row">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="firstName" class="col-form-label">First Name <span class="danger">*</span></label>
                                                <input type="text" class="form-control" name="firstName" id="firstName" maxlength="25">
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="lastName" class="col-form-label">Last Name <span class="danger">*</span></label>
                                                <input type="text" class="form-control" name="lastName" id="lastName" maxlength="25">
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="email" class="col-form-label">Email <span class="danger">*</span></label>
                                                <input type="text" class="form-control" name="email" id="email" maxlength="50">
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone No. <span class="danger">*</span></label>
                                                <input type="tel" class="form-control" name="phone" id="phone" maxlength="18">
                                              </div>
                                            </div>
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                <?php // wp_nonce_field('ajax_file_nonce', 'security'); ?>
                                                <label for="resume" class="col-form-label">Attach Resume <span class="danger">*</span></label>
                                                <input type="file" name="resume" id="resume" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"/>
                                              </div>
                                            </div>
                                            <div class="col-md-12">
                                              <div class="form-group top-padding-xs">
                                                <!--<div class="g-recaptcha" data-sitekey="6LcD4sQUAAAAAOzpw_28BC2GX78ym-A3QCTpk4Lu"></div>-->
                                                <div id="recaptcha1"></div>
                                              </div>
                                            </div>
                                            <div class="col-md-12">
                                              <div class="form-group top-padding-xs">
                                                <button type="submit" class="btn btn-danger" id="applyJobBtn">Apply Job</button>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                        <div class="confirmation-success">Thanks for contacting us! We will be in touch with you shortly.</div>
                                        <div class="confirmation-danger">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>

                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                      <?php endif; ?>
                        <script>
                          <?php $my_nonce = wp_create_nonce('media-form'); ?>
                          var nonce = "<?php echo $my_nonce; ?>";
                        </script>

                        <div class="card-strip-footer-item">
                            <a href="mailto:" class="mail-to-link" data-toggle="modal" data-target="#sendEmailPoupup">Email this Job</a>
                            <div class="modal fade" id="sendEmailPoupup" tabindex="-1" role="dialog" aria-labelledby="sendEmailPoupupLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Email this Job</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="flaticon-multiply"></span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="emailJob" name="emailJob" type="POST">

                                                <input type="hidden" id="jobTitle" name="jobTitle" value="<?php echo $title; ?>">
                                                <input type="hidden" id="closingDate" name="closingDate" value="<?php echo $closing_date; ?>">
                                                <input type="hidden" id="salary" name="salary" value="<?php echo $salary; ?>">
                                                <input type="hidden" id="offeredSalary" name="offeredSalary" value="<?php echo $offered_salary; ?>">
                                                <input type="hidden" id="carrerLevel" name="carrerLevel" value="<?php echo $carrer_level; ?>">
                                                <input type="hidden" id="experience" name="experience" value="<?php echo $experience; ?>">
                                                <input type="hidden" id="genderPreference" name="genderPreference" value="<?php echo $gender_preference; ?>">
                                                <input type="hidden" id="qualifications" name="qualifications" value="<?php echo $qualifications; ?>">
                                                <input type="hidden" id="industries" name="industries" value="<?php echo $indname[0]; ?>">
                                                <input type="hidden" id="jobDescription" name="jobDescription" value="<?php echo $job_description; ?>">
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                        <label for="user_name" class="col-form-label">Full Name <span class="danger">*</span></label>
                                                        <input type="text" class="form-control" name="user_name" id="user_name">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                        <label for="user_email" class="col-form-label">Email <span class="danger">*</span></label>
                                                        <input type="text" class="form-control" name="user_email" id="user_email">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <div class="form-group top-padding-xs">
                                                        <!--<div class="g-recaptcha" data-sitekey="6LcD4sQUAAAAAOzpw_28BC2GX78ym-A3QCTpk4Lu"></div>-->
                                                        <div id="recaptcha2"></div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <div class="form-group top-padding-xs">
                                                        <button type="submit"  class="btn btn-danger" id="emailJobbtn">Send Email</button>
                                                      </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="confirmation-success">Thanks for contacting us! We will be in touch with you shortly.</div>
                                            <div class="confirmation-danger">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-strip-footer-item">
                          <div>
                            <label class="note">SHARE</label>
                          </div>
                            <div class="social-icon-wrap">
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="page-builder job-detail">
    <div class="builder-row top-padding-md">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h5>Job Details</h5>
                    <ol class="icon-text top-margin-xs">
                    
                    <?php if($offered_salary) { ?>
                        <li>
                            <i class="flaticon flaticon-salary"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Offered Salary</span>
                                <span class="title"><?php echo $offered_salary; ?></span>
                            </span>
                        </li>
                    <?php }?> <?php  if($gender_preference) { ?>
                        <li>
                            <i class="flaticon flaticon-gender"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Gender Preference</span>
                                <span class="title"><?php echo $gender_preference; ?></span>
                            </span>
                        </li>
                    <?php } if($carrer_level) { ?>
                        <li>
                            <i class="flaticon flaticon-career"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Career Level</span>
                                <span class="title"><?php echo $carrer_level; ?></span>
                            </span>
                        </li>
                        <?php } if($industries) { ?>
                        <li>
                            <i class="flaticon flaticon-industry"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Industry</span>
                                <span class="title">
                                <?php $industry = get_the_terms( $post->ID, 'industries' );
                                foreach($industry as $term ){
                                    echo  '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
                                } ?>
                                </span>
                            </span>
                        </li>
                        <?php } if($experience) { ?>
                        <li>
                            <i class="flaticon flaticon-experience"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Experience</span>
                                <span class="title"> <?php echo $experience; ?> </span>
                            </span>
                        </li>
                        <?php } if($qualifications) { ?>
                        <li>
                            <i class="flaticon flaticon-qualifications"></i>
                            <span class="span-wrap">
                                <span class="sub-title">Qualifications</span>
                                <span class="title"><?php echo $qualifications; ?></span>
                            </span>
                        </li>
                        <?php }?>
                    </ol>
                    <?php if(get_field('job_description')): ?>
                    <hr class="top-margin-xs bottom-margin-sm">
                    <h5 class="bottom-margin-xs">Job Description</h5>
                    <div class="plain_content">
                    <?php echo get_field('job_description'); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                <?php 
                    $tags = get_the_tags($post->ID);
                    if($tags){
                ?>
                    <h5>Required skills</h5>
                    <div class="link-tag-grp top-margin-xs">
                        <?php
                        if ( $tags ) :
                            foreach ( $tags as $tag ) : ?>
                                <a href="javascript:void(0)?>"  class="link-tag text-decoration-none" title="<?php echo esc_attr( $tag->name ); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="page-builder fill">
    <div class="builder-row">
        <div class="container">
            <hr class="top-padding-md top-margin-md">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="bottom-margin-xs">Other jobs you may like</h5>
                </div>

                <?php
                $current_post_type = get_post_type($post->ID);
                $args = array(
                'post_type'=> $current_post_type,
                'posts_per_page'=>4,
                'post_not_in'    => array($post->ID),
                );
                $loop = new WP_Query($args);
                while ( $loop->have_posts() ) : $loop->the_post();
                $locations = get_the_term_list( $loop->ID, 'locations', '', ', ' );
                $closing_date = get_field('closing_date');
                ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div data-mh="jblock" style="margin-bottom: 20px; min-height: 215px">
                              <div class="details-wrap">
                                  <h6 class="card-subtitle text-muted">Job Title:</h6>
                                  <h4 class="card-title" data-mh="jtitle" style="min-height: 110px;"><?php the_title(); ?></h5>
                              </div>
                              <div class="details-wrap">
                                  <h6 class="card-subtitle text-muted">Location:</h6>
                                  <h5 class="card-title"><?php echo $locations; ?></h5>
                              </div>
                              <div class="details-wrap">
                                  <?php if($closing_date):?>
                                    <h6 class="card-subtitle text-muted">Closing Date:</h6>
                                    <h5 class="card-title"><?php echo date("d F, Y", strtotime($closing_date)); ?></h5>
                                  <?php endif; ?>
                              </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-danger btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; 
                wp_reset_postdata(); ?>
            </div>
            <hr class="top-margin-md">
        </div>
    </div>
</section>



<?php endwhile; ?>
<?php get_footer(); ?>