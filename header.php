<!DOCTYPE html>
<html dir="ltr" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content ="initial-scale=1.0,user-scalable=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
	<div id="header">
		<div id="innerHeader" style="background-image:url(<?php echo get_template_directory_uri() . '/images/hbg/hbg' . mt_rand(1,5). '.jpg'; ?>)">
			<div id="blogLogo">
				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>
				<p><?php bloginfo('description'); ?></p>
			</div>
			<div id="menu">
				<?php 
					if(has_nav_menu('topbar')){
						wp_nav_menu( array(
							'menu'              => '',
							'theme_location'    => 'topbar',
							'depth'             => 0,
							'container'         => '',
							'container_class'   => '',
							'fallback_cb'     	=> false,
							'menu_class'        => 'nav navbar-nav',
							'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						)  );
					}
				?>
			</div>
		</div>
	</div>
	<div id="mainWrapper">
