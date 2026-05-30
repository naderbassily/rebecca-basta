<?php
/**
 * Rebecca-Basta functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rebecca-Basta
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.3' );
}

/**
 * Read a GitHub token for private repository update checks.
 *
 * Prefer defining REBECCA_BASTA_GITHUB_TOKEN in wp-config.php. Environment
 * variables are also supported for hosts that manage secrets outside PHP files.
 *
 * @return string
 */
function rebecca_get_github_update_token() {
	if ( defined( 'REBECCA_BASTA_GITHUB_TOKEN' ) && REBECCA_BASTA_GITHUB_TOKEN ) {
		return (string) REBECCA_BASTA_GITHUB_TOKEN;
	}

	$token = getenv( 'REBECCA_BASTA_GITHUB_TOKEN' );

	return $token ? (string) $token : '';
}

/**
 * Initialize GitHub-based theme updates.
 *
 * Plugin Update Checker reads the local theme version from style.css and compares
 * it with GitHub releases, tags, or the configured stable branch.
 */
function rebecca_init_github_theme_updater() {
	$puc_loader = get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php';

	if ( ! file_exists( $puc_loader ) ) {
		return;
	}

	require_once $puc_loader;

	if ( ! class_exists( PucFactory::class ) ) {
		return;
	}

	$update_checker = PucFactory::buildUpdateChecker(
		'https://github.com/naderbassily/rebecca-basta/',
		__FILE__,
		'rebecca'
	);

	$update_checker->setBranch( 'main' );

	$github_token = rebecca_get_github_update_token();
	if ( '' !== $github_token ) {
		$update_checker->setAuthentication( $github_token );
	}
}
rebecca_init_github_theme_updater();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rebecca_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Rebecca-Basta, use a find and replace
		* to change 'rebecca' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rebecca', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-1'      => esc_html__( 'Primary', 'rebecca' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'rebecca' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'rebecca_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'rebecca_setup' );

/**
 * Register Book CPT with archive support.
 * Ensures has_archive is true so /books/ works.
 */
function rebecca_register_book_cpt() {
	$labels = array(
		'name'               => __( 'Books', 'rebecca' ),
		'singular_name'      => __( 'Book', 'rebecca' ),
		'add_new_item'       => __( 'Add New Book', 'rebecca' ),
		'edit_item'          => __( 'Edit Book', 'rebecca' ),
		'view_item'          => __( 'View Book', 'rebecca' ),
		'view_items'         => __( 'View Books', 'rebecca' ),
		'search_items'       => __( 'Search Books', 'rebecca' ),
		'not_found'          => __( 'No books found.', 'rebecca' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'rebecca' ),
	);

	register_post_type(
		'book',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => 'books',
			'rewrite'      => array( 'slug' => 'book' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'menu-order', 'page-attributes' ),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-book',
		)
	);

	register_taxonomy(
		'genre',
		'book',
		array(
			'label'        => __( 'Genre', 'rebecca' ),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'genre' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'rebecca_register_book_cpt' );

/**
 * Register a stable blog archive route at /blog/.
 */
function rebecca_register_blog_archive_route() {
	add_rewrite_rule( '^blog/?$', 'index.php?rebecca_papers_archive=1', 'top' );
	add_rewrite_rule( '^blog/page/([0-9]{1,})/?$', 'index.php?rebecca_papers_archive=1&paged=$matches[1]', 'top' );
}
add_action( 'init', 'rebecca_register_blog_archive_route' );

/**
 * Expose the custom papers archive query var.
 */
function rebecca_register_blog_archive_query_var( $vars ) {
	$vars[] = 'rebecca_papers_archive';

	return $vars;
}
add_filter( 'query_vars', 'rebecca_register_blog_archive_query_var' );

/**
 * Shape the /blog/ request like a posts archive.
 */
function rebecca_handle_blog_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->get( 'rebecca_papers_archive' ) ) {
		return;
	}

	$query->set( 'post_type', 'post' );
	$query->set( 'post_status', 'publish' );
	$query->set( 'paged', max( 1, (int) $query->get( 'paged' ) ) );
	$query->is_home     = true;
	$query->is_archive  = false;
	$query->is_singular = false;
}
add_action( 'pre_get_posts', 'rebecca_handle_blog_archive_query' );

/**
 * Render the custom /blog/ route with the posts archive template.
 */
function rebecca_use_blog_archive_template( $template ) {
	if ( get_query_var( 'rebecca_papers_archive' ) ) {
		$home_template = locate_template( 'home.php' );
		if ( $home_template ) {
			return $home_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'rebecca_use_blog_archive_template' );

/**
 * Flush rewrites once when the custom blog archive route changes.
 */
function rebecca_maybe_flush_rewrite_rules() {
	$version = 'rebecca-blog-route-v1';
	if ( get_option( 'rebecca_rewrite_version' ) === $version ) {
		return;
	}

	flush_rewrite_rules( false );
	update_option( 'rebecca_rewrite_version', $version );
}
add_action( 'init', 'rebecca_maybe_flush_rewrite_rules', 20 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rebecca_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rebecca_content_width', 640 );
}
add_action( 'after_setup_theme', 'rebecca_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rebecca_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rebecca' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rebecca' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'rebecca_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rebecca_scripts() {
	wp_enqueue_style( 'rebecca-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'rebecca-style', 'rtl', 'replace' );

	// Shared fonts used on every page (header + footer need Cormorant Garamond).
	wp_enqueue_style(
		'rebecca-fonts-shared',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@200;300;400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Theme CSS powers the header, footer, and all inner pages.
	wp_enqueue_style(
		'rebecca-theme',
		get_template_directory_uri() . '/assets/css/theme.css',
		array( 'rebecca-style', 'rebecca-fonts-shared' ),
		_S_VERSION
	);

	wp_enqueue_script(
		'rebecca-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		_S_VERSION,
		true
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'rebecca-homepage',
			get_template_directory_uri() . '/assets/css/homepage.css',
			array( 'rebecca-theme' ),
			_S_VERSION
		);

		wp_enqueue_script(
			'rebecca-homepage',
			get_template_directory_uri() . '/assets/js/homepage.js',
			array(),
			_S_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rebecca_scripts' );

/**
 * Allow SVG uploads in the Media Library.
 *
 * SVGs can contain scripts, so only trusted users should upload them.
 */
function rebecca_allow_svg_uploads( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'rebecca_allow_svg_uploads' );

/**
 * Help WordPress validate SVG files during upload.
 */
function rebecca_validate_svg_filetype( $data, $file, $filename, $mimes ) {
	$filetype = wp_check_filetype( $filename, $mimes );

	if ( 'svg' === $filetype['ext'] ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'rebecca_validate_svg_filetype', 10, 4 );

/**
 * Add a homepage toggle column to the Book list table.
 */
function rebecca_book_columns( $columns ) {
	$offset = array_search( 'date', array_keys( $columns ), true );

	if ( false === $offset ) {
		$columns['on_home_page'] = __( 'Home Page', 'rebecca' );
		return $columns;
	}

	$before = array_slice( $columns, 0, $offset, true );
	$after  = array_slice( $columns, $offset, null, true );

	return $before + array( 'on_home_page' => __( 'Home Page', 'rebecca' ) ) + $after;
}
add_filter( 'manage_book_posts_columns', 'rebecca_book_columns' );

/**
 * Render the homepage toggle column value.
 */
function rebecca_book_column_content( $column, $post_id ) {
	if ( 'on_home_page' !== $column ) {
		return;
	}

	$value = get_post_meta( $post_id, 'on_home_page', true );
	echo '<span class="rebecca-home-page-flag" data-home-page="' . esc_attr( $value ? '1' : '0' ) . '">';
	echo $value ? esc_html__( 'Yes', 'rebecca' ) : esc_html__( 'No', 'rebecca' );
	echo '</span>';
}
add_action( 'manage_book_posts_custom_column', 'rebecca_book_column_content', 10, 2 );

/**
 * Add the homepage toggle to Quick Edit for books.
 */
function rebecca_book_quick_edit( $column_name, $post_type ) {
	if ( 'book' !== $post_type || 'on_home_page' !== $column_name ) {
		return;
	}
	?>
	<fieldset class="inline-edit-col-right">
		<div class="inline-edit-col">
			<?php wp_nonce_field( 'rebecca_book_quick_edit', 'rebecca_book_quick_edit_nonce' ); ?>
			<label class="alignleft">
				<input type="hidden" name="rebecca_on_home_page" value="0">
				<input type="checkbox" name="rebecca_on_home_page" value="1">
				<span class="checkbox-title"><?php esc_html_e( 'Show on home page', 'rebecca' ); ?></span>
			</label>
		</div>
	</fieldset>
	<?php
}
add_action( 'quick_edit_custom_box', 'rebecca_book_quick_edit', 10, 2 );

/**
 * Populate Quick Edit values for the Book homepage toggle.
 */
function rebecca_book_quick_edit_script() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-book' !== $screen->id ) {
		return;
	}
	?>
	<script>
	(function($) {
		var wpInlineEdit = inlineEditPost.edit;
		inlineEditPost.edit = function(postId) {
			wpInlineEdit.apply(this, arguments);
			var id = 0;
			if (typeof postId === "object") {
				id = parseInt(this.getId(postId), 10);
			}
			if (!id) {
				return;
			}
			var row = $("#post-" + id);
			var editRow = $("#edit-" + id);
			var flag = row.find(".rebecca-home-page-flag").data("home-page");
			editRow.find('input[name="rebecca_on_home_page"][type="checkbox"]').prop("checked", String(flag) === "1");
		};
	})(jQuery);
	</script>
	<?php
}
add_action( 'admin_footer-edit.php', 'rebecca_book_quick_edit_script' );

/**
 * Save the Book homepage toggle from Quick Edit.
 */
function rebecca_save_book_quick_edit( $post_id ) {
	if ( ! isset( $_POST['rebecca_book_quick_edit_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rebecca_book_quick_edit_nonce'] ) ), 'rebecca_book_quick_edit' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['rebecca_on_home_page'] ) ) {
		update_post_meta( $post_id, 'on_home_page', '1' === wp_unslash( $_POST['rebecca_on_home_page'] ) ? '1' : '0' );
	}
}
add_action( 'save_post_book', 'rebecca_save_book_quick_edit' );

/**
 * Enable the native WordPress excerpt field for pages.
 */
function rebecca_enable_page_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'rebecca_enable_page_excerpts' );

/**
 * Starter menu shown before a WordPress menu is assigned.
 */
function rebecca_default_menu() {
	$items = array(
		'Home'    => home_url( '/' ),
		'Books'   => home_url( '/books/' ),
		'Blogs'   => home_url( '/blog/' ),
		'About'   => home_url( '/about/' ),
		'Contact' => home_url( '/contact/' ),
	);

	echo '<ul id="primary-menu" class="menu">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
