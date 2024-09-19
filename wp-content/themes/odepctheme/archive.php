<?php get_header(); ?>


<section class="page-builder fill">
    <div class="builder-row">
        <div class="container">
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
              $closing_date = get_field('closing_date');
              $locations = get_the_term_list( $post->ID, 'locations', '', ', ' );
              ?>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="details-wrap">
                                <h6 class="card-subtitle text-muted">Job Title:</h6>
                                <h4 class="card-title" data-mh="jtitle"><?php the_title(); ?></h5>
                            </div>
                            <div class="details-wrap">
                                <h6 class="card-subtitle text-muted">Location:</h6>
                                <h5 class="card-title"><?php echo $locations; ?></h5>
                            </div>
                            <div class="details-wrap">
                                <?php if($closing_date): ?>
                                <h6 class="card-subtitle text-muted">Closing Date:</h6>
                                <h5 class="card-title"><?php echo date("d F, Y", strtotime($closing_date)); ?></h5>
                                <?php endif; ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-danger btn-sm">Apply Now</a>
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