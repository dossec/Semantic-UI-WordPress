<?php
/**
 * The integrations class
 * 
 * @package Semanitic UI for WordPress
 */

/**
 * WordPress Integrations Class
 * 
 * This class interacts with WordPress to add, remove, and/or modify the
 * WordPress default functionality and content. Every method here should have
 * a corresponding add_filter() or add_action() in wp-init.php
 */
class wp_integrations {
	
	/**
	 * Registers various WordPress features
	 * 
	 * @return void
	 */
	public function init() {
		// Set the max content width (used by wordpress)
		global $content_width;
		$content_width = 1200;
		
		// Tell WordPress what this theme supports
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_theme_support('woocommerce');
		add_theme_support('html5', array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form'
		));
		// add_theme_support('post-formats', array(
		// 	'aside',
		// 	'image',
		// 	'link',
		// 	'quote',
		// 	'video'
		// ));
		
		// TIP: Use wp_nav_menu(array('theme_location' => 'menu-name')) to fetch these
		register_nav_menus(array(
			'main-menu'   => __('Main Menu', 'semantic-ui'),
			'footer-menu' => __('Footer Menu', 'semantic-ui')
		));
	}
	
	
	
	/**
	 * Registers the theme widget areas.
	 * 
	 * @return void
	 */
	public function widgets_init() {
		register_sidebar(array(
			'name'          => __('Left Sidebar Widget Area', 'semantic-ui'),
			'id'            => 'sidebar-widget-area-left',
			'description'   => 'These widgets are only visible when the siderbar is on the left side of the page',
			'before_widget' => '<aside id="%1$s" class="wp-widget sidebar-left-widget %2$s ui raised segment">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="ui dividing header widget-title">',
			'after_title'   => '</h4>'
		));
		register_sidebar(array(
			'name'          => __('Right Sidebar Widget Area', 'semantic-ui'),
			'id'            => 'sidebar-widget-area-right',
			'description'   => 'These widgets are only visible when the siderbar is on the right side of the page',
			'before_widget' => '<aside id="%1$s" class="wp-widget sidebar-right-widget %2$s ui raised segment">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="ui dividing header widget-title">',
			'after_title'   => '</h4>'
		));
		register_sidebar(array(
			'name'          => __('Footer Widget Area', 'semantic-ui'),
			'id'            => 'footer-widget-area-footer',
			'description'   => 'These widgets are visible in the footer',
			'before_widget' => '<div class="column"><aside id="%1$s" class="wp-widget sidebar-right-widget %2$s ui raised segment">',
			'after_widget'  => '</aside></div>',
			'before_title'  => '<h4 class="ui dividing header widget-title">',
			'after_title'   => '</h4>'
		));
	}
	
	
	
	/**
	 * Registers all the theme styles/scripts
	 * 
	 * @return void
	 */
	public function register_enqueue() {
		// Styles
		wp_register_style('style-semantic', theme::$styles_uri.'/semantic.min.css', array(), '0.18.0', 'all');
		wp_register_style('style-font-awesome', theme::$styles_uri.'/font-awesome.min.css', array(), '4.1.0', 'all');
		wp_register_style('style-webicons', theme::$styles_uri.'/webicons.min.css', array(), NULL, 'all');
		wp_register_style('style-highlightjs', theme::$styles_uri.'/highlight.js/github.css', array(), '8.0', 'all');
		wp_register_style('style-main', get_stylesheet_uri(), array('style-semantic'), NULL, 'all');
		// Scripts
		wp_register_script('script-headjs', theme::$scripts_uri.'/head.load.min.js', array(), '1.0.3', FALSE);
		wp_register_script('script-webfont', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', array(), NULL, FALSE);
		if (!is_admin()) {
			// Use any version jQuery (without loading it twice)
			wp_deregister_script('jquery');
			wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2', FALSE);
		}
		wp_register_script('script-semantic', theme::$scripts_uri.'/semantic.min.js', array('jquery'), '0.18.0', FALSE);
		wp_register_script('script-highlight', theme::$scripts_uri.'/highlight.pack.min.js', array(), '8.0', FALSE);
		wp_register_script('script-mousetrap', theme::$scripts_uri.'/mousetrap.min.js', array(), '1.4.6', FALSE);
		wp_register_script('script-main', theme::$scripts_uri.'/main.js', array('script-headjs', 'jquery', 'script-semantic', 'script-highlight', 'script-moustrap'), NULL, FALSE);
		wp_register_script('script-theme-options', theme::$scripts_uri.'/theme-options.js', array('script-headjs', 'jquery', 'script-semantic', 'script-highlight', 'script-moustrap'), NULL, FALSE);

	}
	
	
	
	/**
	 * Enqueues the theme styles/scripts
	 * 
	 * @return void
	 */
	public function enqueue() {
		// Styles
		wp_enqueue_style('style-semantic');
		wp_enqueue_style('style-font-awesome');
		wp_enqueue_style('style-webicons');
		wp_enqueue_style('style-highlightjs');
		wp_enqueue_style('style-main');
		
		// Scripts
		wp_enqueue_script('script-headjs', theme::$scripts_uri.'/head.load.min.js');
		/*** If no head.js uncomment the code below ***/
		//wp_enqueue_script('script-webfont');
		//wp_enqueue_script('script-jquery');
		//wp_enqueue_script('script-semantic');
		//wp_enqueue_script('script-highlight');
		//wp_enqueue_script('script-mousetrap');
		//wp_enqueue_script('script-main');
	}
	
	
	
	/**
	 * Registers the options page with WordPress, and enqueues style/scripts for
	 * the options page in the dashboard. Only visible to users who can edit theme
	 * options.
	 * 
	 * @return void
	 */
	public function options() {
		if (current_user_can('edit_theme_options')) {
			if (isset($_GET['page']) && $_GET['page'] === theme::$identifier.'_options') {
				// Styles
				wp_enqueue_style('style-semantic');
				wp_enqueue_style('style-font-awesome');
				wp_enqueue_style('style-webicons');
				wp_enqueue_style('style-highlight');
				wp_enqueue_style('style-main');
				wp_enqueue_style('style-theme-options');
				// Scripts
				wp_enqueue_script('script-webfont');
				wp_enqueue_script('script-semantic');
				wp_enqueue_script('script-highlight');
				wp_enqueue_script('script-mousetrap');
				// There are a few good reasons that you should replace your main.js with
				// the theme-options.js; such as, jQuery is already included in the
				// dashboard and it runs in safe mode.
				wp_enqueue_script('script-theme-options');
			}
			
			add_theme_page(
				'Theme Options',
				'Theme Options',
				'edit_theme_options',
				theme::$identifier.'_options',
				array($this, 'options_page')
			);
		}
	}
	
	
	
	/**
	 * Displays the options page content when called
	 * 
	 * @return void
	 */
	public function options_page() {
		theme::part('template', 'template', 'theme-options');
	}
	
	
	
	/**
	 * This adds a "Theme Options" link to the WordPress admin bar under the menu
	 * with the site name. Is only visible to users who can edit theme options.
	 * 
	 * @param  object $wp_admin_bar The wp_admin_bar object as supplied by WordPress
	 * @return void
	 */
	public function admin_bar_links($wp_admin_bar) {
		if (current_user_can('edit_theme_options')) {
			$wp_admin_bar->add_node(array(
				'id'     => 'theme-options',
				'parent' => 'site-name',
				'title'  => 'Theme Options',
				'href'   => theme::options_uri()
			));
		}
	}
	
	
	
	/**
	 * Improve the existing wp_title()
	 *
	 * @param  string $title Default HTML page title for current view.
	 * @param  string $sep   [optional] The separator to use.
	 * @return string        The resulting title.
	 */
	public function wp_title($title, $sep = '') {
		global $page, $paged;
		settype($title, 'string');
		settype($sep, 'string');
		$title = trim(trim(trim($title), $sep));
		$real_sep = trim($sep);
		$sep = ' '.$real_sep.' ';
		$t_arr = array();
		
		if (!empty($title)) {
			$t_arr[] = $title;
		}
		
		if (empty($real_sep)) {
			$sep = ' ';
		}
		
		if (is_feed()) {
			return $title;
		}
		
		// Add the blog name
		$t_arr[] = get_bloginfo('name', 'display');
		
		// Add a page number if necessary:
		if (($paged >= 2 || $page >= 2) && !is_404()) {
			$t_arr[] = sprintf('Page %1$s', max($paged, $page));
		}
		
		return implode($sep, $t_arr);
	}
	
	
	
	/**
	 * Adds a field to the user profile page so they can add their Google Plus URL
	 * and be correctly marked as an author in posts they create
	 * 
	 * @param  array $profile_fields The contact fields array as provided by wordpress
	 * @return array                 The resulting array after the field has been added.
	 */
	public function google_author($profile_fields) {
		$profile_fields['gplus'] = 'Google+ URL (for authorship)';
		return $profile_fields;
	}
	
	
	
	/**
	 * Adds the theme's stylesheets to the post/page editor. This allows the visual
	 * editor to more accurately represent what will be shown on the page.
	 * 
	 * @return void
	 */
	public function editor_styles() {
		add_editor_style('assets/styles/semantic.min.css');
		add_editor_style('assets/styles/font-awesome.min.css');
		add_editor_style('assets/styles/webicons.min.css');
		add_editor_style('style.css');
	}
	
	
	
	/**
	 * Adds the class "active" to the current menu item
	 * 
	 * @param  array $classes The array of classes as given by WordPress
	 * @return array          The modified array of classes
	 */
	public function current_nav($classes) {
		if(in_array('current-menu-item', $classes)) {
			$classes[] = 'active';
		}
		return $classes;
	}
	
	
	
	/**
	 * Replaces the default WordPress search form with one that uses Semantic UI.
	 * 
	 * @return string The resulting form
	 */
	public function search_form() {
		// Avoid extra whitespace when a return goes to WordPress
		$query = get_search_query();
		return sprintf(
			'<form role="search" method="GET" action="%1$s">'.
				'<div class="ui small fluid action input">'.
					'<input type="text" name="s" placeholder="%3$s">'.
					'<div type="submit" class="ui small button">%2$s</div>'.
				'</div>'.
			'</form>',
			home_url('/'),
			'Search',
			(empty($query) ? 'Search...' : $query)
		);
	}
	
	
	
	/**
	 * Replaces the default WordPress footer with one that has a paypal donation
	 * link.
	 * 
	 * @return void
	 */
	public function dashboard_footer() {
		echo '<b>Thank you for using Semantic UI for WordPress.</b> <br> If you found this WordPress theme useful, please consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F3WM94XKJH2LU" rel="nofollow" target="_blank">donating a few dollars</a> to help me pay rent.<br><br>';
	}
	
}
