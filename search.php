<?php
/**
 * Search results template.
 *
 * @package Rebecca-Basta
 */

get_header();

$search_query = get_search_query();

$page_results = new WP_Query(
	array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		's'              => $search_query,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	)
);

$paper_results = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		's'              => $search_query,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

$book_results = new WP_Query(
	array(
		'post_type'      => 'book',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		's'              => $search_query,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	)
);

$result_count = (int) $page_results->found_posts + (int) $paper_results->found_posts + (int) $book_results->found_posts;
?>

<main id="primary" class="sr-page">
	<section class="sr-hero">
		<div class="container">
			<span class="sr-kicker"><?php esc_html_e( 'Site Search', 'rebecca' ); ?></span>
			<h1 class="sr-title">
				<?php
				printf(
					esc_html__( 'Results for "%s"', 'rebecca' ),
					esc_html( $search_query )
				);
				?>
			</h1>
			<p class="sr-subtitle">
				<?php
				printf(
					/* translators: %d: result count. */
					_n( '%d result found across pages, papers, and books.', '%d results found across pages, papers, and books.', $result_count, 'rebecca' ),
					$result_count
				);
				?>
			</p>

			<form class="sr-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="searchResultsQuery"><?php esc_html_e( 'Search the site', 'rebecca' ); ?></label>
				<input id="searchResultsQuery" type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php esc_attr_e( 'Search pages, papers, and books', 'rebecca' ); ?>">
				<button type="submit"><?php esc_html_e( 'Search', 'rebecca' ); ?></button>
			</form>
		</div>
	</section>

	<section class="sr-results-section">
		<div class="container">
			<?php if ( $result_count > 0 ) : ?>
				<?php if ( $book_results->have_posts() ) : ?>
					<section class="sr-group">
						<div class="sr-group__header">
							<span class="sr-group__kicker"><?php esc_html_e( 'Category', 'rebecca' ); ?></span>
							<h2 class="sr-group__title"><?php esc_html_e( 'Books', 'rebecca' ); ?></h2>
						</div>

						<div class="ba-grid sr-book-grid">
							<?php
							$i = 0;
							while ( $book_results->have_posts() ) :
								$book_results->the_post();
								$post_id      = get_the_ID();
								$book_genres  = get_the_terms( $post_id, 'genre' );
								$genre_slugs  = ( ! is_wp_error( $book_genres ) && ! empty( $book_genres ) ) ? implode( ' ', wp_list_pluck( $book_genres, 'slug' ) ) : '';
								$is_coming_soon = ! is_wp_error( $book_genres ) && ! empty( $book_genres ) && in_array( 'coming-soon', wp_list_pluck( $book_genres, 'slug' ), true );
								$genre_label  = ( ! is_wp_error( $book_genres ) && ! empty( $book_genres ) ) ? $book_genres[0]->name : '';
								?>
								<a href="<?php the_permalink(); ?>"
								   class="ba-card<?php echo $is_coming_soon ? ' ba-card--coming-soon' : ''; ?>"
								   data-genres="<?php echo esc_attr( $genre_slugs ); ?>"
								   style="--i:<?php echo esc_attr( $i ); ?>">

									<div class="ba-card__cover">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
										<?php else : ?>
											<div class="ba-card__cover-fallback">
												<span><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></span>
												<strong><?php the_title(); ?></strong>
											</div>
										<?php endif; ?>
										<div class="ba-card__overlay">
											<span class="ba-card__view"><?php esc_html_e( 'View Book', 'rebecca' ); ?> &rarr;</span>
										</div>
									</div>

									<div class="ba-card__body">
										<?php if ( $genre_label ) : ?>
											<span class="ba-card__genre"><?php echo esc_html( $genre_label ); ?></span>
										<?php endif; ?>
										<h3 class="ba-card__title"><?php the_title(); ?></h3>
									</div>
								</a>
								<?php
								$i++;
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( $paper_results->have_posts() ) : ?>
					<section class="sr-group">
						<div class="sr-group__header">
							<span class="sr-group__kicker"><?php esc_html_e( 'Category', 'rebecca' ); ?></span>
							<h2 class="sr-group__title"><?php esc_html_e( 'Papers', 'rebecca' ); ?></h2>
						</div>

						<div class="sr-results-grid">
							<?php
							while ( $paper_results->have_posts() ) :
								$paper_results->the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'sr-card' ); ?>>
									<a class="sr-card__link" href="<?php the_permalink(); ?>">
										<div class="sr-card__media">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
											<?php else : ?>
												<div class="sr-card__fallback">
													<span><?php esc_html_e( 'Paper', 'rebecca' ); ?></span>
													<strong><?php the_title(); ?></strong>
												</div>
											<?php endif; ?>
										</div>

										<div class="sr-card__body">
											<div class="sr-card__meta">
												<span class="sr-card__type"><?php esc_html_e( 'Paper', 'rebecca' ); ?></span>
												<span class="sr-card__dot" aria-hidden="true"></span>
												<span class="sr-card__date"><?php echo esc_html( get_the_date() ); ?></span>
											</div>
											<h3 class="sr-card__title"><?php the_title(); ?></h3>
											<div class="sr-card__excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ), 24 ) ); ?></div>
										</div>
									</a>
								</article>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( $page_results->have_posts() ) : ?>
					<section class="sr-group">
						<div class="sr-group__header">
							<span class="sr-group__kicker"><?php esc_html_e( 'Category', 'rebecca' ); ?></span>
							<h2 class="sr-group__title"><?php esc_html_e( 'Pages', 'rebecca' ); ?></h2>
						</div>

						<div class="sr-results-grid">
							<?php
							while ( $page_results->have_posts() ) :
								$page_results->the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'sr-card' ); ?>>
									<a class="sr-card__link" href="<?php the_permalink(); ?>">
										<div class="sr-card__media">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
											<?php else : ?>
												<div class="sr-card__fallback">
													<span><?php esc_html_e( 'Page', 'rebecca' ); ?></span>
													<strong><?php the_title(); ?></strong>
												</div>
											<?php endif; ?>
										</div>

										<div class="sr-card__body">
											<div class="sr-card__meta">
												<span class="sr-card__type"><?php esc_html_e( 'Page', 'rebecca' ); ?></span>
											</div>
											<h3 class="sr-card__title"><?php the_title(); ?></h3>
											<div class="sr-card__excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ), 24 ) ); ?></div>
										</div>
									</a>
								</article>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</section>
				<?php endif; ?>
			<?php else : ?>
				<div class="sr-empty">
					<h2><?php esc_html_e( 'No results found', 'rebecca' ); ?></h2>
					<p><?php esc_html_e( 'Try a broader keyword or explore the books, blog, or about page instead.', 'rebecca' ); ?></p>
					<form class="sr-search sr-search--empty" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label class="screen-reader-text" for="searchResultsQueryEmpty"><?php esc_html_e( 'Search the site', 'rebecca' ); ?></label>
						<input id="searchResultsQueryEmpty" type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php esc_attr_e( 'Search again', 'rebecca' ); ?>">
						<button type="submit"><?php esc_html_e( 'Search', 'rebecca' ); ?></button>
					</form>
					<div class="sr-empty__actions">
						<a href="<?php echo esc_url( home_url( '/books/' ) ); ?>" class="sr-btn sr-btn--outline"><?php esc_html_e( 'Browse Books', 'rebecca' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="sr-btn"><?php esc_html_e( 'Read the Blog', 'rebecca' ); ?></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
