<?php get_header(); ?>


<section id="single" class="top-padding-md page-builder">
  <div class="container">
    <div class="row builder-row">
      <div class="col-md-12 plain_content">
        <?php
        if (have_posts()) : while (have_posts()) : the_post();
        $ftrd_img = get_the_post_thumbnail_url(get_the_ID(),'large');
        $alt_text = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );
        $post_date = get_the_date( 'j M Y' );
        ?>

        <div class="post" id="post-<?php the_ID(); ?>">
          <h3 class="title" style="display: none;">
            <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>">
              <?php the_title(); ?>
            </a>
          </h3>

          <div class="video-slider">
            <?php

              if(have_rows('slider_items')):
              while(have_rows('slider_items')):the_row(); 
              $image = get_sub_field('image');
              $youtube_url = get_sub_field('youtube_url');
              $alt = $image['alt'];
              $slider_img = $image['sizes']['img_1149x680'];
            ?>
            <?php
            $type = get_sub_field('choose_type');
            if($type =='imagetype'){
            ?>
                <div class="item image">
                    <figure>
                        <div class="slide-image slide-media" style="background-image:url('<?php echo $slider_img; ?>');">
                            <img data-lazy="<?php echo $slider_img; ?>"
                                class="image-entity" />
                        </div>
                        <!-- <figcaption class="caption">Static Image</figcaption> -->
                    </figure>
                </div>
            <?php } elseif($type=='videotype') { ?>
                <div class="item youtube">
                    <iframe class="embed-player slide-media" width="980" height="520"
                        src="<?php echo $youtube_url; ?>"frameborder="0" allowfullscreen></iframe>
                    <!-- <p class="caption">YouTube</p> -->
                </div>
            <?php } endwhile; else:endif; ?>

          </div>
            

          </div>

          <hr class="top-margin-xs bottom-margin-xs" />
          <h6>Posted Date: <?php echo $post_date; ?></h6>
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