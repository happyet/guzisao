<?php
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
function lmsim_widgets_init() {
    register_sidebar(array(
    	'id' => 'sidebar-1',
        'name' => 'Widget Area',
        'before_widget' => '<div class="side-box %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'lmsim_widgets_init' );
function lmsim_load() {
    register_nav_menus( array(
		'topbar' => 'Main Menu',
	) );
	add_theme_support( 'title-tag' );
    add_theme_support( 'custom-background' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );	
}
add_action( 'after_setup_theme', 'lmsim_load' );

function add_scripts() {
    wp_enqueue_style( 'happyet', get_stylesheet_uri() );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'add_scripts');

function lmsim_record_views() {
    if (is_singular()) {
        global $post, $user_ID;
        $post_ID = $post->ID;
        if (empty($_COOKIE[USER_COOKIE]) && intval($user_ID) == 0) {
            if ($post_ID) {
                $post_views = (int)get_post_meta($post_ID, 'views', true);
                if (!update_post_meta($post_ID, 'views', ($post_views + 1))) {
                    add_post_meta($post_ID, 'views', 1, true);
                }
            }
        }
    }
}
add_action('wp_head', 'lmsim_record_views');
function post_views($before = '', $after = '', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) {
        echo $before, number_format($views) , $after;
    } else {
        return $views;
    }
}
function lmsim_theme_views(){
	if(function_exists('the_views')) { 
		echo the_views(false); 
	}else{ 
		post_views();
	}
}

function lmsim_get_current_page_url(){
	global $wp;
	return get_option( 'permalink_structure' ) == '' ? add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) : home_url( add_query_arg( array(), $wp->request ) );
}

function lmsim_excerpt_length( $length ) {
	return 120;
}
add_filter( 'excerpt_length', 'lmsim_excerpt_length' );

function lmsim_auto_excerpt_more( $more ) {
		return ' &hellip;';
}
add_filter( 'excerpt_more', 'lmsim_auto_excerpt_more' );

function par_pagenavi($range = 8){
	global $paged,$max_page,$wp_query;
	if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }
	if($max_page > 1){
        if(!$paged) $paged = 1;
        if(get_previous_posts_link()){
            echo '<li class="page-item"><a class="page-link" href="' . previous_posts( false ) . '"><</a></li>';
        }
    	if($paged >= 4){
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link(1) . '" class="extend" title="' . _e('Home','lmsim') . '">1</a></li><li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        if($max_page > $range){
    		if($paged < $range){
                for($i = 1; $i <= ($range + 1); $i++){
                    echo '<li class="page-item';
                    if($i==$paged) echo ' active';
                    echo '"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
                }
            }elseif($paged >= ($max_page - ceil(($range/2)))){
                for($i = $max_page - $range; $i <= $max_page; $i++){
                    echo '<li class="page-item';
                    if($i==$paged) echo ' active';
                    echo '"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
                }
            }elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
                for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
                    echo '<li class="page-item';
                    if($i==$paged) echo ' active';
                    echo '"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
                }
            }
        }else{
            for($i = 1; $i <= $max_page; $i++){
                echo '<li class="page-item';
                if($i==$paged) echo ' active';
                echo '"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }
    	if($max_page > 5 && $paged < $max_page -2){
            echo '<li class="page-item disabled"><span class="page-link">...</span></li><li class="page-item"><a class="page-link" href="' . get_pagenum_link($max_page) . '" class="extend">' . $max_page . '</a></li>';
        }
        if(get_next_posts_link()){
            echo '<li class="page-item"><a class="page-link" href="' . next_posts( $max_page, false ) . '">></a></li>';
        }
    }
}
function get_cn_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cravatar.cn", $avatar);
    return $avatar;
}
add_filter('get_avatar', 'get_cn_avatar');
/*
????????????????????????????????????
??????wp-includes/comment.php???WP_Comment_Query::query??????
????????????????????????????????????
*/
add_filter( 'comments_clauses', 'wpdit_comments_clauses', 2, 10);
function wpdit_comments_clauses( $clauses, $comments ) {
    global $wpdb;
    if ( isset( $comments->query_vars['not_in__user'] ) && ( $user_id = $comments->query_vars['not_in__user'] ) ) {
         
        if ( is_array( $user_id ) ) {
            $clauses['where'] .= ' AND user_id NOT IN (' . implode( ',', array_map( 'absint', $user_id ) ) . ')';
        } elseif ( '' !== $user_id ) {
            $clauses['where'] .= $wpdb->prepare( ' AND user_id <> %d', $user_id );
        }
    }
    //var_dump($clauses);
    return $clauses;
}
/*
????????????????????????????????????
????????????wp-includes/default-widgets.php??? WP_Widget_Recent_Comments ??????
????????????not_in__user
*/
add_filter( 'widget_comments_args', 'wpdit_widget_comments_args' );
function wpdit_widget_comments_args( $args ){
    $args['not_in__user'] = array(1); //???????????????ID???
    return $args;
}