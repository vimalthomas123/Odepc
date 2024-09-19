<?php get_header(); ?>


<section id="single" class="top-padding-md page-builder">
  <div class="container">
    <div class="row builder-row">
      <div class="col-md-12 plain_content">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="post" id="post-<?php the_ID(); ?>">
          <h3 class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
          <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
          <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
          <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
        </div>
        <?php comments_template(); ?>
        <?php endwhile; else: ?>
        <p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>
      </div>      
    </div>
  </div>
</section>


<?php get_footer(); ?>