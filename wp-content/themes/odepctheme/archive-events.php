<?php get_header(); ?>

<section class="page-builder fill">
    <div class="builder-row">
        <div class="container">
            <div class="title center top-margin-md">
              <h2 class="primary-color"><?php the_field('events_title','option'); ?></h2>
              <p><?php the_field('events_description','option'); ?></p>
            </div>
            <div class="top-padding-md"></div>
            <div class="row listing">

            <?php  is_tag(); ?>
            <?php if (have_posts()) : ?>
            <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php /* If this is a category archive */ if (is_category()) { ?>
                <h2 class="title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
            <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                <h2 class="title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                <h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                <h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                <h2 class="title">Archive for <?php the_time('Y'); ?></h2>
            <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                <h2 class="title">Author Archive</h2>
            <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <h2 class="title">Blog Archives</h2>
            <?php }
            ?>


              <?php
              while ( have_posts() ) : the_post();
              $ftrd_img = get_the_post_thumbnail_url(get_the_ID(),'news_thumb');
              $alt_text = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );
              $start_date = get_field( 'start_date' );
              $start_date_string = DateTime::createFromFormat('Ymd', $start_date);
              $end_date = get_field( 'end_date' );
              $end_date_string = DateTime::createFromFormat('Ymd', $end_date);
              $event_time = get_field( 'event_time' );
              $location = get_field( 'location' );
              $registration_link = get_field( 'registration_link' );
              $title = get_the_title();
              $id = get_the_ID();
              ?>

              <div class="col-md-4">
                <div class="card events">
                  <?php if($ftrd_img): ?>
                  <img class="card-img-top" src="<?php echo $ftrd_img; ?>" alt="<?php echo $alt_text; ?>">
                  <?php else: ?>
                  <img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/assets/images/news-placeholder.jpg" alt="<?php echo $title; ?>">
                  <?php endif; ?>
                  <div class="card-body bottom-padding">
                    <h4 class="card-title" data-mh="event-title"><a href="<?php echo get_permalink(); ?>"><?php echo $title; ?></a></h4>
                    
                    <?php if($location['place']): ?>
                    <div class="details-wrap">
                      <h6 class="card-subtitle text-muted">Location:</h6>
                      <h5 class="card-title"><?php echo $location['place']; ?></h5>
                    </div>
                    <?php endif; ?>

                    <?php if($start_date_string || $end_date_string): ?>
                    <div class="details-wrap">
                      <h6 class="card-subtitle text-muted">Event Date:</h6>
                      <h5 class="card-title" data-mh="event-date"><?php echo $start_date_string->format('j M Y'); ?> <?php echo ($end_date) ? '- ' . $start_date_string->format('j M Y') : ''; ?> </h5>
                    </div>
                    <?php endif; ?>

                    <?php if($event_time['start_time']): 

                    ?>
                    <div class="details-wrap">
                      <h6 class="card-subtitle text-muted">Event Time:</h6>
                      <h5 class="card-title"><?php echo $event_time['start_time']; ?> <?php echo ($event_time['end_time']) ? '- ' . $event_time['end_time'] : ''; ?> </h5>
                    </div>
                    <?php endif; 

                    ?>

                    <div class="btn-wrap">
                      <a href="<?php echo get_permalink(); ?>" class="btn btn-danger btn-sm">Read More</a>
                      <?php
                      //$date = new DateTime( $start_date );
                      $today = date("Ymd");
                      $date = strtotime($start_date);
                      $now = strtotime($today);

                      $isPastEvent = $date < $now;
                      if($registration_link && !$isPastEvent):

                      ?>
                        <!-- <a href="<?php //echo $registration_link; ?>" target="_blank" class="btn btn-outline-primary btn-sm">Register</a> -->
                        <div class="card-strip-footer-item">

                          <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#registerForm<?php echo $id; ?>">Register</button>
                            <div class="modal fade" id="registerForm<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="registerForm<?php echo $id; ?>"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleRegisterLabel">Register Form</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="flaticon-multiply"></span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                          <?php
                                            $reg_form = get_field('registration_form',$id);
                                            if($reg_form):
                                              echo do_shortcode($reg_form);
                                            endif;
                                           ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php endif; ?>
                    </div>
                    
                  </div>
                </div>
              </div>

              <?php
              endwhile;
              ?>

              <?php else : ?>
              <h2 class="center">Not Found</h2>
            <?php
            endif;
            wp_reset_postdata();
            ?>
                <!-- <div class="navigation">
                    <div class="alignleft"><?php //next_posts_link('&laquo; Older Entries') ?></div>
                    <div class="alignright"><?php //previous_posts_link('Newer Entries &raquo;') ?></div>
                </div> -->
            </div>
            <hr class="top-margin-md">
        </div>
    </div>
</section>

<?php get_footer(); ?>