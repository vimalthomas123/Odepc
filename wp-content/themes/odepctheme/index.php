<?php get_header(); ?>

<section style="background-color: #f555ee">
	
<div class="container">
<div id="content">
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
   <div class="post" id="post-<?php the_ID(); ?>">
		<h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p class="meta"><small>Posted on <?php the_time('F jS, Y') ?> by <?php the_author() ?> <?php edit_post_link('Edit', ' | ', ''); ?></small></p>
		<div class="entry">
		<?php the_content('Read the rest of this entry &raquo;'); ?>
		</div>
        <div class="info">
		<p class="links">&raquo; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
		<p class="tags"><?php the_tags('Tags: ', ', ', ' '); ?></p>
        </div>
	</div>
    <?php endwhile; ?>
    	<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
<?php else : ?>
	<h2 class="center">Not Found</h2>
	<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
</div>

</div>

</section>

<?php get_footer(); ?>