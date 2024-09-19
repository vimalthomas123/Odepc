<?php 
/*Template Name: Home Page*/
get_header();
?>

    <section id="new-jobs" class="top-padding-md bottom-padding-md" data-bg="<?php bloginfo('template_url'); ?>/contents/new-job-vector.png">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title desc center">
                        <h2><?php the_field('job_section_title'); ?></h2>
                        <p><?php the_field('job_section_description'); ?></p>
                    </div>
                </div>
                <?php 
                  $posts = get_field('job_relationship');
                  $closing_date = get_field('closing_date');
                  if( $posts ): ?>
                      <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
                          <?php setup_postdata($post); 
                          
                      $job_close = get_field('closing_date', $post->ID);
                      $today = date("Ymd");
                      $date = strtotime($job_close);
                      $now = strtotime($today);

                      $isPastJob = $date < $now;
                      if(!$isPastJob){
                         
                          ?>
                          
                          <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="details-wrap">
                                        <h6 class="card-subtitle text-muted">Job Title:</h6>
                                        <h4 class="card-title" data-mh="news-title"><?php the_title(); ?></h4>
                                    </div>
                                    <div class="details-wrap">
                                        <h6 class="card-subtitle text-muted">Location:</h6>
                                        <h5 class="card-title"> <?php 
                                        $terms = get_the_terms($post->ID, 'locations', array('parent'=>'0'));
                                            foreach( $terms as $loc)
                                            {
                                                if($loc->parent==0)
                                                {
                                                    echo $loc->name;  
                                                }
                                            } ?>
                                        </h5>
                                    </div>
                                    <div class="details-wrap">
                                      <?php if($closing_date): ?>
                                        <h6 class="card-subtitle text-muted">Closing Date:</h6>
                                        <h5 class="card-title"><?php echo $closing_date; ?></h5>
                                      <?php endif; ?>
                                    </div>
                                    <a href="<?php the_permalink();?>" class="btn btn-danger btn-sm">Apply Now</a>
                                </div>
                            </div>
                          </div>
                      <?php } endforeach; ?>
                      <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                  <?php endif; ?>
                <div class="col-md-12 center top-padding-sm">
                    <a href="<?php echo get_post_type_archive_link('jobs'); ?>" class="btn btn-outline-primary btn-lg">Browse all</a>
                </div>
            </div>
        </div>
    </section>
    <section id="hire-jobs" class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <?php
                  $i = 1;
                    if(have_rows('hire_job_fields')):
                    while(have_rows('hire_job_fields')):the_row(); 
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
                                <?php $description = get_sub_field('description'); ?>
                                <h2 class="card-title"><?php the_sub_field('title'); ?></h2>
                                <p class="card-text"><?php echo $description; ?></p>
                                <a href="<?php the_sub_field('link'); ?>" class="btn btn-outline-primary"><?php the_sub_field('button_name'); ?></a>
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
                                <?php $description = get_sub_field('description'); ?>
                                <h2 class="card-title"><?php the_sub_field('title'); ?></h2>
                                <p class="card-text"><?php echo $description; ?></p>
                                <a href="<?php the_sub_field('link'); ?>" class="btn btn-outline-primary"><?php the_sub_field('button_name'); ?></a>
                            </div>
                        </div>
                    </div>
                  <?php }$i++; endwhile;else:endif; ?>
                </div>
              </div>
              <hr class="top-margin-md">
        </div>
    </section>
    <section id="why-odepc" class="top-padding-md bottom-padding-md">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title desc center">
                        <h2><?php the_field('why_title'); ?></h2>
                        <p><?php the_field('why_us_descriptions'); ?></p>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="counter-up-wrap top-padding-md">
                      <?php
                      $i = 1;
                      if(have_rows('why_us_counter_info')):
                      while(have_rows('why_us_counter_info')):the_row();
                      ?>
                          <div class="counter-up  inline">
                              <div class="counter-block">
                                  <div class="counter-wrap">
                                      <span class="c-wrapper c-wrapper-<?php echo $i; ?>">
                                          <h3 class="counter"><?php the_sub_field('counter'); ?></h3><span>+</span>
                                      </span>
                                  </div>
                                  <p class="center"><?php the_sub_field('caption'); ?></p>
                              </div>
                              <?php $desc = get_sub_field('description');?>
                              <p><?php echo $desc;  ?></p>
                          </div>
                      <?php $i++; endwhile; else: endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="latest-updates" class="top-padding-md bottom-padding-md">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title center">
                        <h2><?php the_field('news_title'); ?></h2>
                    </div>
                </div>
                <?php 
                $posts = get_field('news_lists');
                if( $posts ): ?>
                <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
                <?php setup_postdata($post); 
                $ftrd_img = get_the_post_thumbnail_url(get_the_ID(),'news_thumb');
                $alt_text = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );
                $post_date = get_the_date( 'j M Y' );
                ?>
                <div class="col-md-4">
                  <div class="card">
                    <img class="card-img-top" src="<?php echo $ftrd_img; ?>" alt="Card image cap">
                    <div class="card-body bottom-space">
                      <h3 class="card-title" data-mh="news-title"><?php the_title(); ?></h3>
                      <h5 class="card-subtitle title-sm"><?php echo $post_date; ?></h5>
                      <p class="card-text" data-mh="news-content"><?php the_excerpt(); ?></p>
                      <a href="<?php the_permalink(); ?>" class="card-link">Read More</a>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
                  <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                <?php endif; ?>
                <div class="col-md-12 center top-padding-sm">
                    <a href="<?php echo site_url(); ?>/news" class="btn btn-outline-primary btn-lg">Browse all</a>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>