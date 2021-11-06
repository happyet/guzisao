<?php get_header(); ?>
	<div id="content" class="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="post-header">
					<h4 class="post-title"><?php the_title(); ?></h4>
					<div class="post-meta">
						<?php the_author() ?> | <?php the_time('Y-m-d') ?> | 浏览：<?php lmsim_theme_views(); ?> | <?php comments_popup_link('评论：0', '评论：1', '评论：%', '', '评论已关闭'); ?>
					</div>
				</div>
				<div class="post-content single-content">
					<?php the_content(); ?>
				</div>
				<div class="post-footer tags">分类：<?php the_category(', ') ?><?php the_tags(' | 标签：', ', ', ''); ?> <?php edit_post_link('Edit',''); ?></div>
			</div>

			<?php
				the_post_navigation(
					array(
						'next_text' => '<span>下一篇</span><p>%title</p>',
						'prev_text' => '<span>上一篇</span><p>%title</p>',
					)
				);
			?>

			<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
			<?php endwhile; else: ?>
				<p>对不起,没有找到符合的文章.<br />
				</p>
			</div>
		<?php endif; ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>