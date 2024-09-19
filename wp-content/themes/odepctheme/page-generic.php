<?php 

/*Template Name: Generic Page*/

get_header(); ?>

  <?php if( have_rows('add_section') ): ?>
  <section class="page-builder">

    <?php
    while( have_rows('add_section') ): the_row();
      $top_margin = get_sub_field('top_margin');
      $bottom_margin = get_sub_field('bottom_margin');
      $top_padding = get_sub_field('top_padding');
      $bottom_padding = get_sub_field('bottom_padding');
      $fill_background = get_sub_field('fill_background');
      $classes = ($top_margin != 'none') ? $top_margin . ' ' : '';
      $classes .= ($bottom_margin != 'none') ? $bottom_margin . ' ' : '';
      $classes .= ($top_padding != 'none') ? $top_padding . ' ' : '';
      $classes .= ($bottom_padding != 'none') ? $bottom_padding . ' ' : '';
      ?>

      <?php if($fill_background): ?>
      <div class="builder-row <?php echo $classes; ?> fill" data-bg="<?php echo get_template_directory_uri(); ?>/contents/new-job-vector.png">
      <?php else: ?>
      <div class="builder-row <?php echo $classes; ?>">
      <?php endif; ?>

        <div class="container">
        <?php while( have_rows('generic_page_builder') ): the_row(); ?>
          
          <?php 
          if( get_row_layout() == 'heading' ):
          $title = get_sub_field('title');
          $settings = get_sub_field('settings');
          echo getStyles($title, $settings['heading'], $settings['color']);
          endif;
          ?>

          <?php 
          if( get_row_layout() == 'text_editor' ):
          $html_content = get_sub_field('html_content');
          echo $html_content;
          endif;
          ?>

          <?php
          if( get_row_layout() == 'title_group' ):
          $title = get_sub_field('title');
          $description = get_sub_field('description');
          $settings = get_sub_field('settings');
          ?>
          <div class="title <?php echo ($description)? 'desc' : ''; ?> <?php echo ($settings['align'])? 'center' : ''; ?> bottom-margin-xs">
            <?php echo getStyles($title, $settings['heading'], $settings['color']); ?>
            <?php if($description): ?>
            <p><?php echo $description; ?></p>
            <?php endif; ?>
          </div>
          <?php
          endif;
          ?>

          
          <?php
          if( get_row_layout() == 'accordion' ):
          $add_item = get_sub_field('add_item');
          ?>
          
          <div class="accordion" id="genericaccordion<?php echo get_row_index(); ?>">
          
            <?php
            $count = 1;
            while( have_rows('add_item') ): the_row();
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            ?>

            <div class="card">
              <div class="card-header <?php echo ($count != 1) ? 'collapsed':''; ?>" id="heading<?php echo $count;?>">
                  <h2 class="mb-0">
                      <button class="btn btn-link <?php echo ($count != 1) ? 'collapsed':''; ?>" type="button" data-toggle="collapse" data-target="#collapse<?php echo $count;?>" aria-expanded="true" aria-controls="collapse<?php echo $count;?>">
                         <?php echo $title; ?>
                      </button>
                  </h2>
              </div>
              <div id="collapse<?php echo $count;?>" class="collapse <?php echo ($count == 1) ? 'show':''; ?>" aria-labelledby="heading<?php echo $count;?>" data-parent="#genericaccordion<?php echo get_row_index(); ?>">
                  <div class="card-body"><?php echo $content; ?></div>
              </div>
            </div>

            <?php
            $count++;
            endwhile;
            ?>
          
          </div>
          <?php endif; ?>

          
          <?php
          if( get_row_layout() == 'news_card' ):
          $add_cards = get_sub_field('add_cards');
          $enable_slider = get_sub_field('enable_slider');
          ?>
          
          <?php if($enable_slider): ?>
          <div class="row slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row listing">
          <?php endif; ?>
          
            <?php
            while( have_rows('add_cards') ): the_row();
            $title = get_sub_field('title');
            $featured_type = get_sub_field('feutured_type');
            $image = get_sub_field('image');
            $video = get_sub_field('featured_video_url');
            $date = get_sub_field('date');
            $description = get_sub_field('description');
            $link_card = get_sub_field('link_card');
            ?>

            <div class="col-md-4">
              <div class="card">
                <?php 
                if($featured_type == 'featured image'): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['news_thumb']; ?>" alt="Card image cap">
                <?php else: ?>
                  <iframe class="border iframe-card-slider" width="100%" src="<?php echo $video; ?>"> </iframe>
                <? endif; ?>
                <div class="card-body bottom-padding">
                  <h3 class="card-title" data-mh="news-title">
                    <?php if($link_card['label'] && $link_card['link']): ?><a href="#"><?php endif; ?>
                    <?php echo $title; ?>
                    <?php if($link_card['label'] && $link_card['link']): ?></a><?php endif; ?>
                  </h3>
                  <h5 class="card-subtitle title-sm"><?php echo $date; ?></h5>
                  <p class="card-text" data-mh="news-content"><?php echo $description; ?></p>
                  <?php if($link_card['label'] && $link_card['link']): ?>
                  <a href="<?php echo $link_card['link']; ?>" class="card-link"><?php echo $link_card['label']; ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php
            endwhile;
            ?>

          </div>
          <?php endif; ?>
          
          <?php
          if( get_row_layout() == 'jobs_card' ):
          $add_cards = get_sub_field('add_cards');
          $enable_slider = get_sub_field('enable_slider');
          ?>
          
          <?php if($enable_slider): ?>
          <div class="row slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row listing">
          <?php endif; ?>
          
            <?php
            while( have_rows('add_cards') ): the_row();
            $card_title = get_sub_field('card_title');
            $link_card = get_sub_field('link_card');
            ?>

            <div class="col-md-3">
              <div class="card">
                <div class="card-body">
                  <div class="details-wrap">
                    <h6 class="card-subtitle text-muted"><?php echo $card_title['label']; ?>:</h6>
                    <h4 class="card-title"><?php echo $card_title['title']; ?></h5>
                  </div>

                  <?php
                  while( have_rows('card_info') ): the_row(); 
                  $label = get_sub_field('label');
                  $title = get_sub_field('title');
                  ?>
                  <div class="details-wrap">
                    <h6 class="card-subtitle text-muted"><?php echo $label; ?>:</h6>
                    <h5 class="card-title"><?php echo $title; ?></h5>
                  </div>
                  <?php endwhile; ?>

                  <?php if($link_card['label'] && $link_card['link']): ?>
                  <a href="<?php echo $link_card['link']; ?>" class="btn btn-danger btn-sm"><?php echo $link_card['label']; ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php
            endwhile;
            ?>

          </div>
          <?php endif; ?>
          
          <?php
          if( get_row_layout() == 'events_card' ):
          $add_cards = get_sub_field('add_cards');
          $enable_slider = get_sub_field('enable_slider');
          ?>
          
          <?php if($enable_slider): ?>
          <div class="row slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row listing">
          <?php endif; ?>
          
            <?php
            while( have_rows('add_cards') ): the_row();
            $card_title = get_sub_field('card_title');
            $link_card = get_sub_field('link_card');
            $image = get_sub_field('image');
            ?>

            <div class="col-md-4">
              <div class="card events">
                <?php if($image): ?>
                <img class="card-img-top" src="<?php echo $image['sizes']['news_thumb']; ?>" alt="Card image cap">
                <?php endif; ?>
                <div class="card-body bottom-padding">
                  <h4 class="card-title" data-mh="news-title">
                    <?php if($link_card['label'] && $link_card['link']): ?> <a href="#"> <?php endif; ?>
                      <?php echo $card_title; ?>
                    <?php if($link_card['label'] && $link_card['link']): ?> </a> <?php endif; ?>
                  </h4>
                  <?php
                  while( have_rows('card_info') ): the_row(); 
                  $label = get_sub_field('label');
                  $title = get_sub_field('title');
                  ?>
                  <div class="details-wrap">
                    <h6 class="card-subtitle text-muted"><?php echo $label; ?>:</h6>
                    <h5 class="card-title"><?php echo $title; ?></h5>
                  </div>
                  <?php endwhile; ?>
                  <?php if($link_card['label'] && $link_card['link']): ?>
                  <a href="<?php echo $link_card['link']; ?>" class="btn btn-danger btn-sm"><?php echo $link_card['label']; ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php
            endwhile;
            ?>

          </div>
          <?php endif; ?>
          
          
          
          <?php
          if( get_row_layout() == 'teams_card' ):
          $add_cards = get_sub_field('add_cards');
          $enable_slider = get_sub_field('enable_slider');
          $add_cards = get_sub_field('add_cards');
          $count_rows = count($add_cards);
          if($enable_slider && $count_rows > 3): ?>
          <div class="row slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row listing">
          <?php endif; ?>

            <?php if( $count_rows == 1 ): ?>
          
              <?php
              $count = 1;
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              $card_desc = get_sub_field('card_desc');
              $link_card = get_sub_field('link_card');
              ?>

              <div class="col-md-4 offset-md-4">
                <?php if($link_card['label'] && $link_card['link']): ?> <a href="#"> <?php endif; ?>
                <div class="card director">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5><?php echo $card_title; ?></h5>
                    <p><?php echo $card_desc; ?></p>
                  </div>
                </div>
                <?php if($link_card['label'] && $link_card['link']): ?> </a> <?php endif; ?>
              </div>

              <?php
              $count++;
              endwhile;
              ?>

            <?php elseif( $count_rows == 2 ): ?>
          
              <?php
              $count = 1;
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              $card_desc = get_sub_field('card_desc');
              $link_card = get_sub_field('link_card');
              ?>

              <div class="<?php echo ( $count == 1 ) ? 'col-md-4 offset-md-2':'col-md-4'; ?>">
                <?php if($link_card['label'] && $link_card['link']): ?> <a href="#"> <?php endif; ?>
                <div class="card director">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5><?php echo $card_title; ?></h5>
                    <p><?php echo $card_desc; ?></p>
                  </div>
                </div>
                <?php if($link_card['label'] && $link_card['link']): ?> </a> <?php endif; ?>
              </div>

              <?php
              $count++;
              endwhile;
              ?>

            <?php else: ?>

              <?php
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              $card_desc = get_sub_field('card_desc');
              $link_card = get_sub_field('link_card');
              ?>

              <div class="<?php echo getColClass($count_rows); ?>">
                <?php if($link_card['label'] && $link_card['link']): ?> <a href="#"> <?php endif; ?>
                <div class="card director">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body" data-mh="client-height">
                    <h5><?php echo $card_title; ?></h5>
                    <p><?php echo $card_desc; ?></p>
                  </div>
                </div>
                <?php if($link_card['label'] && $link_card['link']): ?> </a> <?php endif; ?>
              </div>

              <?php
              endwhile;
              ?>

            <?php endif; ?>

          </div>
          <?php endif; ?>

          <?php
          if( get_row_layout() == 'client_list' ):
          $add_cards = get_sub_field('add_cards');
          $enable_slider = get_sub_field('enable_slider');
          $add_cards = get_sub_field('add_cards');
          $count_rows = count($add_cards);
          if($enable_slider && $count_rows > 3): ?>
          <div class="row slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row listing">
          <?php endif; ?>

            <?php if( $count_rows == 1 ): ?>
          
              <?php
              $count = 1;
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              ?>

              <div class="col-md-4 offset-md-4">
                <div class="card director client">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 data-mh="client-height"><?php echo $card_title; ?></h5>
                  </div>
                </div>
              </div>

              <?php
              $count++;
              endwhile;
              ?>

            <?php elseif( $count_rows == 2 ): ?>
          
              <?php
              $count = 1;
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              ?>

              <div class="<?php echo ( $count == 1 ) ? 'col-md-4 offset-md-2':'col-md-4'; ?>">
                <div class="card director client">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 data-mh="client-height"><?php echo $card_title; ?></h5>
                  </div>
                </div>
              </div>

              <?php
              $count++;
              endwhile;
              ?>

            <?php else: ?>

              <?php
              while( have_rows('add_cards') ): the_row();
              $image = get_sub_field('image');
              $card_title = get_sub_field('card_title');
              ?>

              <div class="<?php echo getColClass($count_rows); ?>">
                <div class="card director client">
                  <?php if($image): ?>
                  <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" class="card-img-top" alt="Card image cap">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 data-mh="client-height"><?php echo $card_title; ?></h5>
                  </div>
                </div>
              </div>

              <?php
              endwhile;
              ?>

            <?php endif; ?>

          </div>
          <?php endif; ?>
          
          <?php
          if( get_row_layout() == 'block_quote' ):
          $add_blockquote = get_sub_field('add_blockquote');
          $enable_slider = get_sub_field('enable_slider');
          ?>
          
          <?php if($enable_slider): ?>
          <div class="row slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1}'>
          <?php else: ?>
          <div class="row">
          <?php endif; ?>
          
            <?php
            while( have_rows('add_blockquote') ): the_row();
            $designation = get_sub_field('designation');
            $name = get_sub_field('name');
            $image = get_sub_field('featured_image');
            $content = get_sub_field('content');
            ?>

            <div class="col-md-12">
              <blockquote class="blockquote auto">
                <div class="blockquote-items top-margin-lg">
                    <?php if($image): ?>
                    <figure>
                    <img class="card-img-top" src="<?php echo $image['sizes']['img_360x360']; ?>" alt="Card image cap">
                    </figure>
                    <?php endif; ?>
                    <div class="blockquote-body">
                      <p><?php echo $content; ?></p>
                      <div class="blockquote-author">
                        <h5 class="author-title"><?php echo $name; ?></h5>
                        <h6 class="author-sub-title"><?php echo $designation; ?></h6>
                      </div>
                    </div>
                </div>
              </blockquote>
            </div>

            <?php
            endwhile;
            ?>

          </div>
          <?php endif; ?>
          
          <?php if( get_row_layout() == 'divider' ): ?>
          <hr>
          <?php endif; ?>


           <?php
          if( get_row_layout() == 'image_texts' ):
          $add_items = get_sub_field('add_items');
          ?>
                  <?php
                  $i = 1;
                    if(have_rows('add_items')):
                    while(have_rows('add_items')):the_row(); 
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
                                <p class="card-text"><?php echo get_sub_field('description'); ?></p>
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
                                <p class="card-text"><?php echo get_sub_field('description'); ?></p>
                                <?php
                                if($btn_name):
                                ?>
                                <a href="<?php the_sub_field('link'); ?>" class="btn btn-outline-primary"><?php the_sub_field('button_name'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                  <?php }$i++; endwhile;else:endif; ?>
 
          <?php endif; ?>
          
          
          <?php if( get_row_layout() == 'columns' ): ?>
            <div class="plain_content">
              <div class="row">
                <?php
                $column_count = count( get_sub_field('add_columns') );
                $sidebar = get_sub_field('sidebar');

                if($sidebar == 'right'):
                  $count = 1;
                  while( have_rows('add_columns') ): the_row(); 
                  ?>
                  <div class="<?php echo($count == 1) ? 'col-md-7':'col-md-4 offset-md-1 well'; ?>">

                    <?php while( have_rows('column_content') ): the_row(); ?>

                    <?php 
                    if( get_row_layout() == 'heading' ):
                    $title = get_sub_field('title');
                    $settings = get_sub_field('settings');
                    echo getStyles($title, $settings['heading'], $settings['color']);
                    endif;
                    ?>

                    <?php 
                    if( get_row_layout() == 'text_editor' ):
                    $html_content = get_sub_field('html_content');
                    echo $html_content;
                    endif;
                    ?>  

                    <?php if( get_row_layout() == 'divider' ): ?>
                    <hr>
                    <?php endif; ?>

                    <?php endwhile; ?>
                  
                  </div>
                  <?php
                  $count++;
                  endwhile;
                elseif( $sidebar == 'left' ):
                  $count = 1;
                  while( have_rows('add_columns') ): the_row(); 
                  ?>
                  <div class="<?php echo($count == 1) ? 'col-md-4 well':'col-md-7 offset-md-1'; ?>">
  
                    <?php while( have_rows('column_content') ): the_row(); ?>
  
                    <?php 
                    if( get_row_layout() == 'heading' ):
                    $title = get_sub_field('title');
                    $settings = get_sub_field('settings');
                    echo getStyles($title, $settings['heading'], $settings['color']);
                    endif;
                    ?>
  
                    <?php 
                    if( get_row_layout() == 'text_editor' ):
                    $html_content = get_sub_field('html_content');
                    echo $html_content;
                    endif;
                    ?>  

                    <?php if( get_row_layout() == 'divider' ): ?>
                    <hr>
                    <?php endif; ?>
  
                    <?php endwhile; ?>
                  
                  </div>
                  <?php
                  $count++;
                  endwhile;
                else:
                  while( have_rows('add_columns') ): the_row(); 
                  ?>
                  <div class="<?php echo getColClass($column_count); ?>">

                    <?php while( have_rows('column_content') ): the_row(); ?>

                    <?php 
                    if( get_row_layout() == 'heading' ):
                    $title = get_sub_field('title');
                    $settings = get_sub_field('settings');
                    echo getStyles($title, $settings['heading'], $settings['color']);
                    endif;
                    ?>

                    <?php 
                    if( get_row_layout() == 'text_editor' ):
                    $html_content = get_sub_field('html_content');
                    echo $html_content;
                    endif;
                    ?>  

                    <?php if( get_row_layout() == 'divider' ): ?>
                    <hr>
                    <?php endif; ?>

                    <?php endwhile; ?>
                  
                  </div>
                  <?php
                  endwhile;
                endif;?>
              </div>
            </div>
          <?php endif; ?>

        <?php endwhile; ?>
        </div>

      </div>

    <?php endwhile; ?>
  </section>
  <?php endif; ?>

</section>


<?php get_footer(); ?>