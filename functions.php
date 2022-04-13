<?php
add_action('after_setup_theme', 'metamedicina_setup');
function metamedicina_setup(){
    load_theme_textdomain('metamedicina', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'metamedicina')));
}

add_action('admin_notices', 'metamedicina_admin_notice');
function metamedicina_admin_notice(){
    $user_id = get_current_user_id();
    if (!get_user_meta($user_id, 'metamedicina_notice_dismissed_5') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p>' . __('<big><strong>metamedicina</strong>:</big> Help keep the project alive! <a href="?notice-dismiss" class="alignright">Dismiss</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">Make a Donation</a>', 'metamedicina') . '</p></div>';
}

add_action('admin_init', 'metamedicina_notice_dismissed');
function metamedicina_notice_dismissed(){
    $user_id = get_current_user_id();
    if (isset($_GET['notice-dismiss']))
        add_user_meta($user_id, 'metamedicina_notice_dismissed_5', 'true', true);
}

add_action('wp_enqueue_scripts', 'metamedicina_enqueue');
function metamedicina_enqueue(){
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/node_modules/bootstrap/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri().'/node_modules/bootstrap-icons/font/bootstrap-icons.css');
    wp_enqueue_style('owl-carousel-css', get_template_directory_uri().'/node_modules/owl.carousel/dist/assets/owl.carousel.min.css');
    wp_enqueue_style('animate-css', get_template_directory_uri().'/node_modules/animate.css/animate.min.css');
    wp_enqueue_style('owl-carousel-theme-css', get_template_directory_uri().'/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css');
    wp_enqueue_style('metamedicina-style', get_stylesheet_uri(),'',rand(0,9999));
    wp_enqueue_style('calendar-main', get_template_directory_uri().'/node_modules/fullcalendar/main.css'); 


    wp_enqueue_script('jquery');
    wp_enqueue_script('owl-carousel', get_template_directory_uri().'/node_modules/owl.carousel/dist/owl.carousel.min.js');
    wp_enqueue_script('calendar-main', get_template_directory_uri().'/node_modules/fullcalendar/main.js');
    wp_enqueue_script('scripts', get_template_directory_uri().'/js/scripts.js',['calendar-main']);
}

add_action('wp_footer', 'metamedicina_footer');


add_filter( 'rest_calendar_query', function( $args ) {

    $filters = [
         'relation' => 'AND',
    ];

    foreach($_GET as $key => $value){
         $filter = [
              'key' => $key,
              'value' => $value,
              'compare' => 'like'
         ];
         array_push($filters, $filter);
    }

    $args['meta_query'] = $filters;

    return $args;
} );

/* js modules */

function metamedicina_footer(){
?>
    <script>
        jQuery(document).ready(function($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
<?php
}

add_filter('document_title_separator', 'metamedicina_document_title_separator');
function metamedicina_document_title_separator($sep){
    $sep = '|';
    return $sep;
}

add_filter('the_title', 'metamedicina_title');
function metamedicina_title($title){
    if ($title == '') {
        return '...';
    } else {
        return $title;
    }
}

function metamedicina_schema_type(){
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . $schema . $type . '"';
}

add_filter('nav_menu_link_attributes', 'metamedicina_schema_url', 10);
function metamedicina_schema_url($atts){
    $atts['itemprop'] = 'url';
    return $atts;
}

if (!function_exists('metamedicina_wp_body_open')) {
    function metamedicina_wp_body_open() {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'metamedicina_skip_link', 5);

function metamedicina_skip_link(){
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'metamedicina') . '</a>';
}
add_filter('the_content_more_link', 'metamedicina_read_more_link');

function metamedicina_read_more_link(){
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'metamedicina'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
//add_filter('excerpt_more', 'metamedicina_excerpt_read_more_link');

function metamedicina_excerpt_read_more_link($more){
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'metamedicina'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'metamedicina_image_insert_override');
function metamedicina_image_insert_override($sizes){
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

add_action('widgets_init', 'metamedicina_widgets_init');
function metamedicina_widgets_init(){
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'metamedicina'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('wp_head', 'metamedicina_pingback_header');
function metamedicina_pingback_header(){
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('comment_form_before', 'metamedicina_enqueue_comment_reply_script');
function metamedicina_enqueue_comment_reply_script(){
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function metamedicina_custom_pings($comment){
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}

add_filter('get_comments_number', 'metamedicina_comment_count', 0);
function metamedicina_comment_count($count){
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}


include('inc/cpt.php');