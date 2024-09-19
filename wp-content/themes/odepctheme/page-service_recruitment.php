<?php 
/*Template Name: Recruitment & Training*/
get_header();
?>

<section id="hire-jobs" class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <?php
                  $i = 1;
                    if(have_rows('hire_job_fields')):
                    while(have_rows('hire_job_fields')):the_row(); 
                    // $btn_name = get_sub_field('button_name');
                    $image = get_sub_field('image');
                    $title = $image['title'];
                    $alt = $image['alt'];
                    $cover = $image['sizes']['hire_job'];
                  ?>
                    <div class="card">
                        <div class="card-full-cover">
                            <div class="card-body">
                                <img src="<?php echo $cover; ?>" class="card-img-top" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
                                <?php the_sub_field('description'); ?>
                            </div>
                        </div>
                    </div>
                  <?php  $i++; endwhile;else:endif; ?>
                </div>
              </div>
              <hr class="top-margin-md">
        </div>
    </section>

    <?php get_footer(); ?> 