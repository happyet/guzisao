<?php get_header(); ?>
	<div id="content" class="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<div class="post-header"><h2 class="post-title"><?php the_title(); ?></h2></div>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
		<?php endwhile; endif; ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>