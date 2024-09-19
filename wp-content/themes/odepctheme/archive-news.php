<?php get_header(); ?>

<section class="page-builder fill">
    <div class="builder-row">
        <div class="container">
        <div class="title center top-margin-md">
              <h2 class="primary-color"><?php the_field('news_title','option'); ?></h2>
              <p><?php the_field('news_description','option'); ?></p>
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

              while ( have_posts() ) : the_post();
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
            </div>
            <hr class="top-margin-md">
        </div>
    </div>
</section>

<?php get_footer(); ?>