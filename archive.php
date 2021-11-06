<?php get_header(); $description = get_the_archive_description(); ?>
<div id="content" class="content">	
	<?php if (have_posts()) : ?>
		<div class="archive-title">
			<?php the_archive_title( '<h4>', '</h4>' ); ?>
			<?php if ( $description ) echo $description; ?>
		</div>
					<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="post-header">
					<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="打开 <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="post-meta">
						<?php the_author() ?> | <?php the_time('Y-m-d') ?> | 浏览：<?php lmsim_theme_views(); ?> | <?php comments_popup_link('评论：0', '评论：1', '评论：%', '', '评论已关闭'); ?>
					</div>
				</div>
				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>
				<div class="post-footer">分类：<?php the_category(', ') ?><?php the_tags(' | 标签：', ', ', ''); ?></div>
			</div>
		<?php endwhile; ?>
		<div class="site-navigation">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">不好意思，您所查看的内容不再这里，您可以通过侧栏搜索工具查一下。</p>
	<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>