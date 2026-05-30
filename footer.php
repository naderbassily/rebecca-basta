<?php
/**
 * Theme footer — used on every page.
 *
 * @package Rebecca-Basta
 */
?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-top">

				<div class="footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<span class="footer-monogram">RMB</span>
					<?php endif; ?>
					<p class="footer-tagline"><?php esc_html_e( 'Author · Researcher · Educator', 'rebecca' ); ?></p>
				</div>

				<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'rebecca' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>

			</div>

			<div class="footer-bottom">
				<span class="footer-copy">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
					<?php esc_html_e( 'All rights reserved.', 'rebecca' ); ?>
				</span>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
