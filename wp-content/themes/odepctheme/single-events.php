<?php get_header(); ?>

<section id="single" class="top-padding-md page-builder events-detail">
  <div class="container">
    <div class="row builder-row">
      <div class="col-md-8 plain_content">
        <?php
        if (have_posts()) : while (have_posts()) : the_post();
        $ftrd_img = get_the_post_thumbnail_url(get_the_ID(),'large');
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
        <div class="post" id="post-<?php the_ID(); ?>">
          <img src="<?php echo $ftrd_img; ?>" alt="<?php echo $title; ?>" style="width: 100%;" />
          <div class="top-margin-xs">
            <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
          </div>
        </div>
        <?php comments_template(); ?>
        <?php endwhile; else: ?>
        <p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>
      </div>  
      <div class="col-md-4">

        <?php
        $today = date("Ymd");
        $date = strtotime($start_date);
        $now = strtotime($today);
        $isPastEvent = $date < $now;
        if($registration_link && !$isPastEvent):
        ?>
                      <div class="card-strip-footer-item">
                          <button type="button" class="btn btn-danger btn-xlg btn-block" data-toggle="modal" data-target="#registerForm">Event Registration</button>
                            <div class="modal fade" id="registerForm" tabindex="-1" role="dialog" aria-labelledby="registerForm"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Register Form</h4>
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

        <div class="card-body well <?php echo ($registration_link && !$isPastEvent) ? 'top-margin-xs': ''; ?>">
          <?php if($location['place']): ?>
          <div class="details-wrap">
            <h6 class="card-subtitle text-muted">Location:</h6>
            <h5 class="card-title"><?php echo $location['place']; ?></h5>
          </div>
          <?php endif; ?>

          <?php if($start_date_string || $end_date_string): ?>
          <div class="details-wrap">
            <h6 class="card-subtitle text-muted">Event Date:</h6>
            <h5 class="card-title"><?php echo $start_date_string->format('j M Y'); ?> <?php echo ($end_date) ? '- ' . $start_date_string->format('j M Y') : ''; ?> </h5>
          </div>
          <?php endif; ?>

          <?php if($event_time): ?>
          <div class="details-wrap">
            <h6 class="card-subtitle text-muted">Event Time:</h6>
            <h5 class="card-title"><?php echo $event_time['start_time']; ?> <?php echo ($event_time['end_time']) ? '- ' . $event_time['end_time'] : ''; ?> </h5>
          </div>
          <?php endif; ?>

          <?php if($location['location_map']): ?>
          <a href="https://www.google.com/maps/place/<?php echo $location['place']; ?>/@<?php echo $location['location_map']; ?>,18z" alt="" class="card-link" target="_blank">View Map</a>
          <?php endif; ?>

        </div>

      </div>    
    </div>
  </div>
</section>


<?php get_footer(); ?>