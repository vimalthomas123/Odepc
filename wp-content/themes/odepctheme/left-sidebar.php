<div class="leftsidebar">
<div id="sidebar1" class="sidebar">
<ul>
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
		if ( function_exists('dynamic_sidebar')  && dynamic_sidebar('Left Sidebar'))  : else :  ?>
<li>
<h2><?php _e('Recent Posts'); ?></h2>
<ul>
<?php get_archives('postbypost', '10', 'custom', '<li>', '</li>'); ?>
</ul>
</li>
<?php endif; ?>
</ul>
</div>
</div>