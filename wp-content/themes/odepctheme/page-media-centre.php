<?php get_header(); ?>

<section class="page-builder fill top-padding-md">
    <div class="builder-row">
        <div class="container">
            <div class="title desc center bottom-margin-md">
              <h2 class="primary-color">News</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic placeat quo ipsa incidunt eveniet iste. Saepe labore hic mollitia tempora! Laborum, officia inventore cupiditate error vero mollitia architecto ipsam aut.</p>
            </div>
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

              $news = new WP_Query(array('post_type' => 'news'));
              while ( $news->have_posts() ) : $news->the_post();

                global $post;
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

                <?php endwhile; ?>
                <?php else : ?>
                <h2 class="center">Not Found</h2>
                <!-- <?php //include (TEMPLATEPATH . '/searchform.php'); ?> -->
                <?php endif; 
                wp_reset_postdata(); ?>
                <!-- <div class="navigation">
                    <div class="alignleft"><?php //next_posts_link('&laquo; Older Entries') ?></div>
                    <div class="alignright"><?php //previous_posts_link('Newer Entries &raquo;') ?></div>
                </div> -->
          
                <div class="col-md-12 center top-padding-sm">
                  <a href="<?php echo site_url(); ?>/news" class="btn btn-outline-primary btn-lg">Browse all</a>
                </div>

            </div>
            <hr class="top-margin-md">
        </div>
    </div>
</section>

<section class="page-builder fill top-padding-md">
    <div class="builder-row">
        <div class="container">
            <div class="title desc center bottom-margin-md">
              <h2 class="primary-color">Events</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic placeat quo ipsa incidunt eveniet iste. Saepe labore hic mollitia tempora! Laborum, officia inventore cupiditate error vero mollitia architecto ipsam aut.</p>
            </div>
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
              $news = new WP_Query(array('post_type' => 'events'));
              while ( $news->have_posts() ) : $news->the_post();
              $ftrd_img = get_the_post_thumbnail_url(get_the_ID(),'news_thumb');
              $alt_text = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );
              $event_date = get_field( 'event_date' );
              $event_time = get_field( 'event_time' );
              $location = get_field( 'location' );
              $registration_link = get_field( 'registration_link' );
              $title = get_the_title();
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

                    <?php if($event_date): ?>
                    <div class="details-wrap">
                      <h6 class="card-subtitle text-muted">Event Date:</h6>
                      <h5 class="card-title"><?php echo $event_date['start_date']; ?> <?php echo ($event_date['end_date']) ? '- ' . $event_date['end_date'] : ''; ?> </h5>
                    </div>
                    <?php endif; ?>

                    <?php if($event_time): ?>
                    <div class="details-wrap">
                      <h6 class="card-subtitle text-muted">Event Time:</h6>
                      <h5 class="card-title"><?php echo $event_time['start_time']; ?> <?php echo ($event_time['end_time']) ? '- ' . $event_time['end_time'] : ''; ?> </h5>
                    </div>
                    <?php endif; ?>

                    <a href="<?php echo get_permalink(); ?>" class="btn btn-danger btn-sm">Read More</a>
                  </div>
                </div>
              </div>
              

              <?php
              endwhile;
              ?>

              <div class="col-md-12 center top-padding-sm">
                <a href="<?php echo site_url(); ?>/events" class="btn btn-outline-primary btn-lg">Browse all</a>
              </div>

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