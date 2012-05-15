<?php
/**
 * Sked functions and definitions
 *
 * @package Sked
 * @since Sked 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Sked 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'sked_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Sked 1.0
 */
function sked_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Sked, use a find and replace
	 * to change 'sked' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sked', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sked' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // sked_setup
add_action( 'after_setup_theme', 'sked_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Sked 1.0
 */
function sked_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'sked' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'sked_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function sked_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_style( 'webfonts', 'http://fonts.googleapis.com/css?family=Aldrich|Open+Sans:400,600' );
	
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.css' );
	
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', 'jquery', '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'sked_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Register Game post type
 *
 * @since Sked 1.0
 */
 function sked_game_register() {
 
	$labels = array(
		'name' => _x('Games', 'post type general name'),
		'singular_name' => _x('Game', 'post type singular name'),
		'add_new' => _x('Add New Game', 'portfolio item'),
		'add_new_item' => __('Add New Game'),
		'edit_item' => __('Edit Game'),
		'new_item' => __('New Game'),
		'view_item' => __('View Game'),
		'search_items' => __('Search Games'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		// 'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail'),
		'taxonomies' => array('category')
	  ); 
 
	register_post_type( 'game' , $args );
}
add_action('init', 'sked_game_register');

/**
 * Set up custom meta boxes for opponent and game details
 *
 * @since Sked 1.0
 */
/* function sked_opponent(){
  global $post;
  $custom = get_post_custom($post->ID);
  $opponent = $custom["opponent"][0];
  ?>
  <label>Opponent:</label>
  <input name="opponent" value="<?php echo $opponent; ?>" />
  <?php
} */
 
function sked_gamemeta() {
	global $post;
	$custom = get_post_custom($post->ID);
	$opponent = $custom["opponent"][0];
	$gametime = $custom["gametime"][0];
	$gamedate = $custom["gamedate"][0];
	$gamelocation = $custom["gamelocation"][0];
	$gametv = $custom["gametv"][0];
	$gameresult = $custom["gameresult"][0];
	echo '<input type="hidden" name="sked_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<p><label>Opponent:</label><br />
	<input name="opponent" value="<?php echo $opponent; ?>" /></p>
	<p><label>Game time:</label><br />
	<input type="text" name="gametime" value="<?php echo $gametime; ?>"></p>
	<p><label>Game result:</label><br />
	<input type="text" name="gameresult" value="<?php echo $gameresult; ?>"></p>
	<p><label>Game date:</label><br />
	<input type="text" name="gamedate" value="<?php echo $gamedate; ?>"></p>
	<p><label>Game location:</label><br />
	<input type="text" name="gamelocation" value="<?php echo $gamelocation; ?>"></p>
	<p><label>TV info:</label><br />
	<input type="text" name="gametv" value="<?php echo $gametv; ?>"></p>
	<?php
	}

/**
 * Add the meta boxes
 */
function sked_admin_init(){
	// add_meta_box("opponent-meta", "Opponent", "sked_opponent", "game", "normal", "high");
	add_meta_box("game-meta", "Game info", "sked_gamemeta", "game", "normal", "high");
}

add_action("admin_init", "sked_admin_init");

/**
 * Save the game posts 
 *
 * @since Sked 1.0
 */
function sked_save_details(){
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return; 
	}
	if (!wp_verify_nonce($_POST['sked_meta_box_nonce'], basename(__FILE__))) {
	     return $post_id;
	}
	global $post;
	update_post_meta($post->ID, "opponent", $_POST["opponent"]);
	update_post_meta($post->ID, "gametime", $_POST["gametime"]);
	update_post_meta($post->ID, "gamedate", $_POST["gamedate"]);
	update_post_meta($post->ID, "gamelocation", $_POST["gamelocation"]);
	update_post_meta($post->ID, "gametv", $_POST["gametv"]);
	update_post_meta($post->ID, "gameresult", $_POST["gameresult"]);
}

add_action('save_post', 'sked_save_details');

/* set up ajax requests for different seasons */


function get_season_games() {
    if(isset($_POST['season'])) $season = $_POST['season'];
        show_season_games($season);
        die();
	die();
}



function show_season_games($season){
   get_template_part( 'game', 'list' );
}

add_action('wp_ajax_nopriv_load_season_games', 'get_season_games');
add_action('wp_ajax_load_season_games', 'get_season_games');

?>