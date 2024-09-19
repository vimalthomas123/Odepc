<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>
  <meta name="author" content="<?php bloginfo('author'); ?>" />
  <meta name="description" content="<?php bloginfo('description'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php bloginfo('template_directory');?>/assets/favicon/favicon.ico" type="image/x-icon">

  <?php wp_head(); ?>
  
</head>

<body <?php body_class(); ?>>

<?php $countryData = json_encode(get_taxonomy_hierarchy('locations')); ?>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
    var terms = JSON.parse('<?php echo $countryData ?>');
</script>

    <?php if( is_post_type_archive('jobs') ): ?>
    <header id="inner-hero-banner-sm">
    <?php elseif (is_front_page()) : ?>
    <header>
    <?php else: ?>
    <header id="inner-hero-banner-xs">
    <?php endif; ?>


        <div class="main-nav">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand white-brand navbar-brand-1" href="#">
                                <img src="<?php the_field('brand_logo','option'); ?>" alt="ODEPC">
                            </a>
                            <a class="navbar-brand navbar-brand-2" href="<?php echo get_home_url(); ?>">
                                <img src="<?php the_field('brand_logo2','option'); ?>" alt="ODEPC">
                            </a>
                            <a class="navbar-brand navbar-brand-3" href="<?php echo get_home_url(); ?>">
                            <?php the_field('header_descriptions','option'); ?>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">

                                <span></span>
                                <span></span>
                                <span></span>
                            </button>

                            <div class="collapse navbar-collapse"><!--id="navbarSupportedContent"-->
                                <!-- navbar-nav ml-auto -->
                                <!-- nav-item -->
                                <!-- nav-link -->
                                  <?php 

                                    wp_nav_menu( array(
                                      'theme_location'  => 'primary',
                                      'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                                      'container'       => 'ul',
                                      'menu_class'      => 'navbar-nav ml-auto',
                                      'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                                      'walker'          => new WP_Bootstrap_Navwalker(),
                                  ) );
                                  ?>
                                  
                            </div>
                        </nav>
                        <a href="http://www.odepc.in" target="_blank" class="login-register">Register/Login</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if( is_post_type_archive('jobs') ): ?>

            <?php get_template_part( 'job-search' ); ?>

        <?php elseif ( is_front_page() ): ?>
            <div class="container-fluid">
              <div class="hero-slider" id="hero-slider">

                <?php
                if(have_rows('banner_slider')):
                  while(have_rows('banner_slider')):the_row(); 
                  $banner_image = get_sub_field('banner_image');
                  $banner = $banner_image['sizes']['img_488x550'];
                  $bg_image = get_sub_field('background_image');
                  $bg_image = $bg_image['sizes']['bg_800x560'];
                  $desc = get_sub_field('description');
                ?>

                <div class="hero-out" data-bg="<?php echo $bg_image; ?>">
                  <div class="hero-slider-item" data-bg="<?php echo $banner; ?>">
                      <div class="hero-slider-caption">
                        <h1><?php the_sub_field('title'); ?></h1>
                    
                        <p><?php echo $desc; ?></p>
                        <?php 
                     $btn_name = get_sub_field('button_name'); 
                     if($btn_name)
                     {
                       ?>
                      <a href="<?php the_sub_field('button_link'); ?>" class="btn btn-outline-light"><?php the_sub_field('button_name'); ?></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                
                <?php endwhile;else: endif; ?>

              </div>
            </div>
        <?php elseif ( is_singular('jobs') ): ?>
        <?php elseif(is_archive()): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <div class="title bottom-margin-lg">
                          <h1><?php echo str_replace("Archives: ", "", get_the_archive_title()); ?></h1>
                        </div>
                        <?php bootstrap_breadcrumb(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <div class="title bottom-margin-lg">
                          <h1><?php the_title(); ?></h1>
                        </div>
                        <?php bootstrap_breadcrumb(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php endif; ?>

      </div>
    </header>
