<?php 
/*Template Name: Gallery Page*/
get_header();
?>


<section id="single" class="top-padding-md page-builder">
  <div class="container">
    <div class="row builder-row">
      <div class="col-md-12 plain_content">

          <div class="video-slider">
            <?php

              if(have_rows('gallery_items')):
              while(have_rows('gallery_items')):the_row(); 
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
                        	<h5> <?php echo get_sub_field('title'); ?> </h5>
                            <img data-lazy="<?php echo $slider_img; ?>" class="image-entity" />
                        	
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
    </div>
  </div>
</section>


<?php get_footer(); ?>