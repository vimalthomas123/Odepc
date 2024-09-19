		<section id="business-names" class="top-padding-md bottom-padding-md">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title desc center">
                        <h2><?php the_field('business_title','option'); ?></h2>
                        <p><?php the_field('business_description','option'); ?></p>
                    </div>
								</div>
                <div class="col-md-12">
								  <?php if(have_rows('business_logos','option')): ?>
										<div class="thumbnail-slider">
											<?php while(have_rows('business_logos','option')):the_row();
											$image = get_sub_field('logos');
											$alt = $image['alt'];
											$thumb = $image['sizes']['business_logos'];
								  ?>
												<figure><img src="<?php echo $thumb; ?>" alt="<? echo $alt; ?>"></figure>
									<?php endwhile;?>
										</div>
									<?php else:endif;?>
								</div>
            </div>
        </div>
    </section>
    <section id="social-strip">
        <div class="container">
            <div class="row">
								<div class="col-md-12">
									<?php if(have_rows('social_icons','option')): ?>
									<ul class="social-icon center">
												<?php while(have_rows('social_icons','option')):the_row();
										?>
											<li><a href="<?php the_sub_field('link','option');  ?>"><i class="fab <?php the_sub_field('icon_name','option');  ?>"></i></a></li>
									<?php endwhile;?>
									</ul>
									<?php else:endif;?>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <nav class="ft-nav-bar top-padding-sm bottom-padding-sm"">
            <div class="container">
                <div class="row" id="column-5">
                    <div class="col-md-3">
                        <h3 class="c-heading">CONTACT</h3>
                        <address>
												<?php the_field('contact_details','option'); ?>
                        </address>
                    </div>
                    <div class="col-md-2">
												<h3 class="c-heading">ODEPC</h3>
                        <?php 
													wp_nav_menu( array(
													'theme_location' => 'footer',
													'menu' => 'footer_navigation',
													'container' =>'ul',
													'menu_class'     => 'ft-nav-link',
													) ); 
												?>
                    </div>
                    <div class="col-md-2">
                        <h3 class="c-heading">FOR CANDIDATE</h3>
                        <?php 
													wp_nav_menu( array(
													'theme_location' => 'forcandidate',
													'menu' => 'candidate_navigation',
													'container' =>'ul',
													'menu_class'     => 'ft-nav-link',
													) ); 
												?>
                    </div>
                    <div class="col-md-2">
                        <h3 class="c-heading">PARTNERSHIP</h3>
												<?php 
													wp_nav_menu( array(
													'theme_location' => 'partnership',
													'menu' => 'partnership_navigation',
													'container' =>'ul',
													'menu_class'     => 'ft-nav-link',
													) ); 
												?>
                    </div>
                    <div class="col-md-2">
                        <h3 class="c-heading">TRAVEL SERVICE</h3>
												<?php 
													wp_nav_menu( array(
													'theme_location' => 'travel',
													'menu' => 'travel_navigation',
													'container' =>'ul',
													'menu_class'     => 'ft-nav-link',
													) ); 
												?>
                    </div>
                </div>
            </div>
        </nav>
        <div class="ft-base">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - A Government Of Kerala Undertaking. All Right Reserved</p>
                    </div>
                   <!--  <div class="col-md-6">
												<?php 
													wp_nav_menu( array(
													'theme_location' => 'footerend',
													'menu' => 'footerend_navigation',
													'container' =>'ul',
													'menu_class'     => 'tp-links end',
													) ); 
												?>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>
	<script src="https://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5dde56b03258ca0012c804cd&product=inline-share-buttons" async="async"></script>
	<?php wp_footer(); ?>
</body>
</html>


