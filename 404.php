<?php
/**
 * 404 template.
 *
 * @package Rebecca-Basta
 */

get_header();
?>

<main id="primary" class="nf-page">
	<section class="nf-hero">
		<div class="container">
			<div class="nf-panel">
				<span class="nf-code">404</span>
				<h1 class="nf-title"><?php esc_html_e( 'Page Not Found', 'rebecca' ); ?></h1>
				<p class="nf-copy"><?php esc_html_e( 'We couldn\'t find the page you were looking for. Try searching or head back to one of the main sections below.', 'rebecca' ); ?></p>

				<form class="sr-search nf-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="notFoundSearch"><?php esc_html_e( 'Search the site', 'rebecca' ); ?></label>
					<input id="notFoundSearch" type="search" name="s" placeholder="<?php esc_attr_e( 'Search the site', 'rebecca' ); ?>">
					<button type="submit"><?php esc_html_e( 'Search', 'rebecca' ); ?></button>
				</form>

				<div class="nf-actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sr-btn"><?php esc_html_e( 'Back Home', 'rebecca' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/books/' ) ); ?>" class="sr-btn sr-btn--outline"><?php esc_html_e( 'Browse Books', 'rebecca' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="sr-btn sr-btn--ghost"><?php esc_html_e( 'Contact', 'rebecca' ); ?></a>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
