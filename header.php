<?php
/**
 * Theme header — used on every page.
 *
 * @package Rebecca-Basta
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_front_page() && ! get_query_var( 'rebecca_papers_archive' ) ) : ?>
<div class="preloader" id="preloader">
	<div class="preloader-monogram">RMB</div>
	<div class="preloader-line"></div>
</div>
<?php endif; ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rebecca' ); ?></a>

	<header id="masthead" class="site-header<?php echo ( is_front_page() && ! get_query_var( 'rebecca_papers_archive' ) ) ? ' site-header--home' : ''; ?>">
		<div class="container">
			<div class="header-inner">

				<div class="site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<nav id="site-navigation" class="nav" aria-label="<?php esc_attr_e( 'Primary menu', 'rebecca' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => 'rebecca_default_menu',
						)
					);
					?>
				</nav>

				<form class="header-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="headerSearch"><?php esc_html_e( 'Search site', 'rebecca' ); ?></label>
					<input id="headerSearch" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'rebecca' ); ?>">
					<button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'rebecca' ); ?>">
						<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6"></circle><path d="M20 20L15.5 15.5"></path></svg>
					</button>
				</form>

				<button class="menu-toggle" id="menuToggle" type="button" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'rebecca' ); ?>">
					<span></span>
					<span></span>
					<span></span>
				</button>

			</div>
		</div>
	</header>

	<div class="mobile-menu" id="mobileMenu" aria-hidden="true">
		<form class="header-search header-search--mobile" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="mobileHeaderSearch"><?php esc_html_e( 'Search site', 'rebecca' ); ?></label>
			<input id="mobileHeaderSearch" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'rebecca' ); ?>">
			<button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'rebecca' ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6"></circle><path d="M20 20L15.5 15.5"></path></svg>
			</button>
		</form>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'mobile-primary-menu',
				'container'      => false,
				'fallback_cb'    => 'rebecca_default_menu',
			)
		);
		?>
	</div>
