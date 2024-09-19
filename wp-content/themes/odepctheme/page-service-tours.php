<?php 
/*Template Name: travels & tours */
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
                    $btn_name = get_sub_field('button_name');
                    $image = get_sub_field('image');
                    $title = $image['title'];
                    $alt = $image['alt'];
                    $cover = $image['sizes']['hire_job'];
                    if($i%2!=0)
                    {
                  ?>
                    <div class="card">
                        <div class="card-horizontal">
                            <figure>
                                <img src="<?php echo $cover; ?>" class="card-img-top" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title"><?php the_sub_field('title'); ?></h2>
                                <p class="card-text"><?php the_sub_field('description'); ?></p>
                                <?php  
                                if($btn_name):
                                ?>
                                <a href="<?php the_sub_field('link'); ?>" class="btn btn-outline-primary"><?php the_sub_field('button_name'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                  <?php } else {  ?>
                    <div class="card">
                        <div class="card-horizontal reverse">
                            <figure>
                                <img src="<?php echo $cover; ?>" class="card-img-top" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title"><?php the_sub_field('title'); ?></h2>
                                <p class="card-text"><?php the_sub_field('description'); ?></p>
                                <?php
                                if($btn_name):
                                ?>
                                <a href="<?php the_sub_field('link'); ?>" class="btn btn-outline-primary"><?php the_sub_field('button_name'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                  <?php }$i++; endwhile;else:endif; ?>
                </div>
              </div>
              <hr class="top-margin-md">
        </div>
    </section>


    <?php get_footer(); ?>  