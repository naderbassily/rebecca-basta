<?php
/**
 * Posts archive template.
 *
 * @package Rebecca-Basta
 */

get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
$archive_title = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Papers', 'rebecca' );
$archive_description = $posts_page_id ? get_post_field( 'post_excerpt', $posts_page_id ) : '';

if ( ! $archive_description ) {
	$archive_description = __( 'Published papers, articles, and research writing by Rebecca M. Basta.', 'rebecca' );
}
?>

<main id="primary" class="ba-page pa-page">
	<section class="ba-hero pa-hero">
		<div class="container">
			<span class="ba-kicker"><?php esc_html_e( 'Published Works', 'rebecca' ); ?></span>
			<h1 class="ba-heading"><?php echo esc_html( $archive_title ); ?></h1>
			<p class="ba-sub"><?php echo esc_html( $archive_description ); ?></p>
		</div>
	</section>

	<section class="ba-grid-section pa-grid-section">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="ba-grid pa-grid">
					<?php
					$i = 0;
					while ( have_posts() ) :
						the_post();

						$post_id = get_the_ID();
						$paper_url = '';
						$paper_keys = array( 'paper_url', 'paper_link', 'external_url', 'external_link', 'publication_url', 'pdf_url', 'url' );

						foreach ( $paper_keys as $paper_key ) {
							$value = '';
							if ( function_exists( 'get_field' ) ) {
								$value = get_field( $paper_key, $post_id );
							}
							if ( ! $value ) {
								$value = get_post_meta( $post_id, $paper_key, true );
							}
							if ( $value && filter_var( $value, FILTER_VALIDATE_URL ) ) {
								$paper_url = $value;
								break;
							}
						}

						$destination = $paper_url ? $paper_url : get_permalink();
						$target_attr = $paper_url ? ' target="_blank" rel="noopener noreferrer"' : '';
						?>
						<a href="<?php echo esc_url( $destination ); ?>"
						   class="pa-card"
						   style="--i:<?php echo esc_attr( $i ); ?>;"<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<div class="pa-card__panel">
								<h2 class="pa-card__title"><?php the_title(); ?></h2>
							</div>
							<div class="pa-card__meta">
								<span class="pa-card__date"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="pa-card__cta">
									<?php esc_html_e( 'Read Now', 'rebecca' ); ?>
									<span class="pa-card__arrow" aria-hidden="true">&rarr;</span>
								</span>
							</div>
						</a>
						<?php
						$i++;
					endwhile;
					?>
				</div>

				<div class="sr-pagination pa-pagination">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 1,
							'prev_text' => __( 'Previous', 'rebecca' ),
							'next_text' => __( 'Next', 'rebecca' ),
						)
					);
					?>
				</div>
			<?php else : ?>
				<p class="ba-empty"><?php esc_html_e( 'No papers published yet.', 'rebecca' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
