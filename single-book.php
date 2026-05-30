<?php
/**
 * Single Book template.
 *
 * @package Rebecca-Basta
 */

get_header();

function rb_field( $key, $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $key, $post_id );
		if ( $val ) return $val;
	}
	return get_post_meta( $post_id ?: get_the_ID(), $key, true );
}

while ( have_posts() ) :
	the_post();

	$post_id    = get_the_ID();
	$genre_terms = get_the_terms( $post_id, 'genre' );
	$genre_label = ( ! is_wp_error( $genre_terms ) && ! empty( $genre_terms ) )
		? implode( ' · ', wp_list_pluck( $genre_terms, 'name' ) ) : '';

	$publisher  = rb_field( 'publisher', $post_id ) ?: rb_field( 'book_publisher', $post_id );
	$amazon_url = rb_field( 'amazon_link', $post_id )
		?: rb_field( 'amazon_url', $post_id )
		?: rb_field( 'amazon', $post_id )
		?: rb_field( 'buy_link', $post_id );
	$wiley_url  = rb_field( 'wiley_link', $post_id ) ?: rb_field( 'wiley_url', $post_id ) ?: rb_field( 'publisher_url', $post_id );
	$isbn_13    = rb_field( 'isbn-13', $post_id ) ?: rb_field( 'isbn_13', $post_id ) ?: rb_field( 'isbn13', $post_id );
	$isbn_10    = rb_field( 'isbn-10', $post_id ) ?: rb_field( 'isbn_10', $post_id ) ?: rb_field( 'isbn10', $post_id );
	$asin       = rb_field( 'asin', $post_id ) ?: rb_field( 'amazon_asin', $post_id );
	$primary_id = $isbn_13 ?: $isbn_10 ?: $asin;
	$primary_id_label = $isbn_13 ? __( 'ISBN-13', 'rebecca' ) : ( $isbn_10 ? __( 'ISBN-10', 'rebecca' ) : __( 'ASIN', 'rebecca' ) );
	$subtitle   = rb_field( 'subtitle', $post_id ) ?: rb_field( 'book_subtitle', $post_id );
	$year       = rb_field( 'year', $post_id ) ?: rb_field( 'publication_date', $post_id );
	$page_count = rb_field( 'pages', $post_id ) ?: rb_field( 'page_count', $post_id ) ?: rb_field( 'pages_count', $post_id );
	$sample_url = rb_field( 'sample_url', $post_id ) ?: rb_field( 'sample_chapter', $post_id );
	$features   = rb_field( 'features', $post_id ); // ACF repeater: [ ['icon','text'], ... ]
	$raw_pages   = is_numeric( $page_count ) ? (int) $page_count : 0;
	$thickness   = $raw_pages ? max( 14, min( 42, (int) round( $raw_pages / 15 ) ) ) : 28;
	$is_coming_soon = ! is_wp_error( $genre_terms ) && ! empty( $genre_terms )
		&& in_array( 'coming-soon', wp_list_pluck( $genre_terms, 'slug' ), true );
?>

<main id="primary" class="sb-page">

	<!-- ── HERO ─────────────────────────────────────────────────────── -->
	<section class="sb-hero">
		<div class="sb-hero-bg"></div>
		<div class="container sb-hero-inner">

			<div class="sb-cover-col sb-anim sb-anim--left">
				<div class="sb-book3d-wrap" style="<?php echo esc_attr( '--thickness:' . $thickness . 'px;' ); ?>">
					<div class="sb-book3d">
						<div class="sb-book3d__back"></div>
						<div class="sb-book3d__paper"></div>
						<div class="sb-book3d__front">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title(), 'class' => 'sb-book3d__cover' ) ); ?>
						<?php else : ?>
							<div class="sb-book3d__cover sb-book3d__cover--fallback">
								<span><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></span>
								<strong><?php the_title(); ?></strong>
							</div>
						<?php endif; ?>
						</div>
					</div>
					<div class="sb-book3d-shadow"></div>
				</div>
			</div>

			<div class="sb-info-col sb-anim sb-anim--right">
				<?php if ( $genre_label ) : ?>
					<span class="sb-genre"><?php echo esc_html( $genre_label ); ?></span>
				<?php endif; ?>

				<h1 class="sb-title"><?php the_title(); ?></h1>

				<?php if ( $subtitle ) : ?>
					<p class="sb-subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>

				<!-- Meta bar -->
				<div class="sb-meta-bar">
					<?php if ( $is_coming_soon && $amazon_url ) : ?>
					<div class="sb-meta-item">
						<a href="<?php echo esc_url( $amazon_url ); ?>" class="sb-btn sb-btn--preorder" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24"><path d="M12 2L12 12M12 12L8 8M12 12L16 8"/><path d="M3 17v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2"/></svg>
							<?php esc_html_e( 'Pre-order on Amazon', 'rebecca' ); ?>
						</a>
					</div>
					<?php endif; ?>
					<?php if ( $year ) : ?>
					<div class="sb-meta-item">
						<span class="sb-meta-label"><?php esc_html_e( 'Publication Date', 'rebecca' ); ?></span>
						<span class="sb-meta-value"><?php echo esc_html( $year ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $primary_id ) : ?>
					<div class="sb-meta-item">
						<span class="sb-meta-label"><?php echo esc_html( $primary_id_label ); ?></span>
						<span class="sb-meta-value"><?php echo esc_html( $primary_id ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $publisher ) : ?>
					<div class="sb-meta-item">
						<span class="sb-meta-label"><?php esc_html_e( 'Publisher', 'rebecca' ); ?></span>
						<span class="sb-meta-value"><?php echo esc_html( $publisher ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $isbn_10 ) : ?>
					<div class="sb-meta-item">
						<span class="sb-meta-label"><?php esc_html_e( 'ISBN-10', 'rebecca' ); ?></span>
						<span class="sb-meta-value"><?php echo esc_html( $isbn_10 ); ?></span>
					</div>
					<?php endif; ?>
				</div>

				<?php if ( has_excerpt() ) : ?>
					<div class="sb-excerpt"><p><?php echo wp_kses_post( get_the_excerpt() ); ?></p></div>
				<?php endif; ?>

				<div class="sb-ctas">
					<?php if ( $sample_url ) : ?>
						<a href="<?php echo esc_url( $sample_url ); ?>" class="sb-btn sb-btn--outline" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'View Sample Chapter', 'rebecca' ); ?>
							<svg viewBox="0 0 24 24"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
						</a>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</section>

	<!-- ── ABOUT THIS BOOK ──────────────────────────────────────────── -->
	<?php if ( get_the_content() ) : ?>
	<section class="sb-about">
		<div class="container sb-about-inner">

			<div class="sb-about-text sb-anim sb-anim--up">
				<span class="sb-kicker"><?php esc_html_e( 'About This Book', 'rebecca' ); ?></span>
				<h2 class="sb-about-title"><?php the_title(); ?></h2>
				<div class="sb-about-content wp-content">
					<?php the_content(); ?>
				</div>

				<?php if ( $wiley_url || $amazon_url ) : ?>
				<div class="sb-about-actions">
					<div class="sb-about-actions__intro">
						<img src="<?php echo esc_url( site_url( '/wp-content/uploads/2026/05/book-icon.svg' ) ); ?>" alt="" class="sb-about-actions__icon" aria-hidden="true">
						<?php if ( $page_count ) : ?>
							<span class="sb-about-actions__pages"><?php echo esc_html( $page_count . ' ' . __( 'Pages', 'rebecca' ) ); ?></span>
						<?php endif; ?>
					</div>
					<div class="sb-about-actions__btns">
						<?php if ( $wiley_url ) : ?>
							<a href="<?php echo esc_url( $wiley_url ); ?>" class="sb-btn sb-btn--outline" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'View on Wiley', 'rebecca' ); ?>
								<svg viewBox="0 0 24 24"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
							</a>
						<?php endif; ?>
						<?php if ( $amazon_url ) : ?>
							<a href="<?php echo esc_url( $amazon_url ); ?>" class="sb-btn sb-btn--gold" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'View on Amazon', 'rebecca' ); ?>
								<svg viewBox="0 0 24 24"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
							</a>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) && is_array( $features ) ) : ?>
				<div class="sb-features">
					<?php foreach ( $features as $feat ) : ?>
						<div class="sb-feature-item">
							<?php if ( ! empty( $feat['icon'] ) ) : ?>
								<div class="sb-feature-icon"><?php echo wp_kses_post( $feat['icon'] ); ?></div>
							<?php endif; ?>
							<span><?php echo esc_html( $feat['text'] ?? $feat['feature'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="sb-about-visual sb-anim sb-anim--right">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="sb-about-book-img">
						<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>
	<?php endif; ?>

	<!-- ── MORE BOOKS ───────────────────────────────────────────────── -->
	<?php
	$related = new WP_Query( array(
		'post_type'      => 'book',
		'posts_per_page' => 4,
		'post_status'    => 'publish',
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
	) );

	if ( $related->have_posts() ) :
	?>
	<section class="sb-related">
		<div class="container">
			<div class="sb-related-head sb-anim sb-anim--up">
				<div>
					<span class="sb-kicker sb-kicker--light"><?php esc_html_e( 'Related Books', 'rebecca' ); ?></span>
					<h2 class="sb-related-title"><?php esc_html_e( 'Explore More by Rebecca Basta', 'rebecca' ); ?></h2>
				</div>
			</div>
			<div class="sb-related-grid">
				<?php $ri = 0; while ( $related->have_posts() ) : $related->the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="sb-related-card sb-anim sb-anim--up" style="--delay:<?php echo esc_attr( $ri * 0.1 ); ?>s">
						<div class="sb-related-cover">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
							<?php else : ?>
								<div class="sb-cover-book--fallback sb-cover-book--sm">
									<span><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></span>
									<strong><?php the_title(); ?></strong>
								</div>
							<?php endif; ?>
						</div>
						<div class="sb-related-info">
							<div class="sb-related-book-title"><?php the_title(); ?></div>
							<?php
							$rg = get_the_terms( get_the_ID(), 'genre' );
							if ( ! is_wp_error( $rg ) && ! empty( $rg ) ) :
							?>
								<div class="sb-related-genre"><?php echo esc_html( $rg[0]->name ); ?></div>
							<?php endif; ?>
						</div>
					</a>
				<?php $ri++; endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<script>
(function () {
	var els = document.querySelectorAll(".sb-anim");
	if ( ! els.length ) return;
	var io = new IntersectionObserver( function(entries) {
		entries.forEach( function(e) {
			if ( e.isIntersecting ) {
				var el = e.target;
				var delay = el.style.getPropertyValue("--delay") || "0s";
				el.style.transitionDelay = delay;
				el.classList.add("sb-anim--in");
				io.unobserve(el);
			}
		});
	}, { threshold: 0.12 });
	els.forEach(function(el) { io.observe(el); });
})();
</script>

<?php endwhile; get_footer(); ?>
