<?php get_header(); ?>
<section class="section-page">
	<div class="container">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<h1 class="title"><?php the_title(); ?></h1>
			<div class="post" >
				<div class="entry">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile; endif; ?>
		
		<div class="info"><?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?></div>
		
	</div>
</section>


<?php get_footer(); ?>