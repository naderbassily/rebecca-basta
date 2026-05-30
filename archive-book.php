<?php
/**
 * Book Archive template.
 *
 * @package Rebecca-Basta
 */

get_header();

// Get all genre terms that have books.
$genres = get_terms( array(
	'taxonomy'   => 'genre',
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'ASC',
) );

// All published books, ordered by menu_order then date.
$all_books = new WP_Query( array(
	'post_type'      => 'book',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
) );
?>

<main id="primary" class="ba-page">

	<!-- ── Hero ──────────────────────────────────────────────────── -->
	<section class="ba-hero">
		<div class="container">
			<span class="ba-kicker"><?php esc_html_e( 'Published Works', 'rebecca' ); ?></span>
			<h1 class="ba-heading"><?php esc_html_e( 'The Library', 'rebecca' ); ?></h1>
			<p class="ba-sub"><?php esc_html_e( 'Books by Rebecca M. Basta spanning Artificial Intelligence, Cybersecurity, Data Science, and more.', 'rebecca' ); ?></p>

			<!-- Filter bar -->
			<?php if ( ! is_wp_error( $genres ) && ! empty( $genres ) ) : ?>
			<div class="ba-filters" id="baFilters">
				<button class="ba-filter-btn is-active" data-filter="all">
					<?php esc_html_e( 'All', 'rebecca' ); ?>
				</button>
				<?php foreach ( $genres as $genre ) : ?>
					<button class="ba-filter-btn<?php echo $genre->slug === 'coming-soon' ? ' ba-filter-btn--coming-soon' : ''; ?>" data-filter="<?php echo esc_attr( $genre->slug ); ?>">
						<?php echo esc_html( $genre->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<div class="ba-search-wrap">
				<label class="screen-reader-text" for="baSearch"><?php esc_html_e( 'Search books', 'rebecca' ); ?></label>
				<div class="ba-search">
					<input id="baSearch" type="search" placeholder="<?php esc_attr_e( 'Search books', 'rebecca' ); ?>">
					<span class="ba-search__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"></circle><path d="M20 20L15.5 15.5"></path></svg>
					</span>
				</div>
			</div>
		</div>
	</section>

	<!-- ── Grid ──────────────────────────────────────────────────── -->
	<section class="ba-grid-section">
		<div class="container">
			<?php if ( $all_books->have_posts() ) : ?>
			<div class="ba-grid" id="baGrid">
				<?php
				$i = 0;
				while ( $all_books->have_posts() ) :
					$all_books->the_post();
					$post_id     = get_the_ID();
					$book_genres = get_the_terms( $post_id, 'genre' );
					$genre_slugs   = ( ! is_wp_error( $book_genres ) && ! empty( $book_genres ) )
						? implode( ' ', wp_list_pluck( $book_genres, 'slug' ) )
						: '';
					$is_coming_soon = ! is_wp_error( $book_genres ) && ! empty( $book_genres )
						&& in_array( 'coming-soon', wp_list_pluck( $book_genres, 'slug' ), true );
					$genre_label = ( ! is_wp_error( $book_genres ) && ! empty( $book_genres ) )
						? $book_genres[0]->name
						: '';
				?>
				<a href="<?php the_permalink(); ?>"
				   class="ba-card<?php echo $is_coming_soon ? ' ba-card--coming-soon' : ''; ?>"
				   data-genres="<?php echo esc_attr( $genre_slugs ); ?>"
				   data-title="<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>"
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
						<h2 class="ba-card__title"><?php the_title(); ?></h2>
					</div>

				</a>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
			</div>

			<p class="ba-empty" id="baEmpty" style="display:none;">
				<?php esc_html_e( 'No books found in this category.', 'rebecca' ); ?>
			</p>

			<?php else : ?>
			<p class="ba-empty"><?php esc_html_e( 'No books published yet.', 'rebecca' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main>

<script>
(function () {
	var filterBtns = document.querySelectorAll(".ba-filter-btn");
	var cards      = document.querySelectorAll(".ba-card");
	var emptyMsg   = document.getElementById("baEmpty");
	var searchInput = document.getElementById("baSearch");
	var activeFilter = "all";

	function applyFilters() {
		var query = searchInput ? searchInput.value.trim().toLowerCase() : "";
		var visible = 0;

		cards.forEach(function (card) {
			var genres = card.dataset.genres || "";
			var title = (card.dataset.title || "").toLowerCase();
			var matchesFilter = activeFilter === "all" || genres.indexOf(activeFilter) !== -1;
			var matchesQuery = ! query || title.indexOf(query) !== -1;
			var show = matchesFilter && matchesQuery;

			if (show) {
				card.style.setProperty("--i", visible);
				card.classList.remove("ba-card--hidden");
				visible++;
			} else {
				card.classList.add("ba-card--hidden");
			}
		});

		if (emptyMsg) {
			emptyMsg.style.display = visible === 0 ? "block" : "none";
		}
	}

	if (filterBtns.length) {
		filterBtns.forEach(function (btn) {
			btn.addEventListener("click", function () {
				activeFilter = btn.dataset.filter;

				filterBtns.forEach(function (b) { b.classList.remove("is-active"); });
				btn.classList.add("is-active");

				applyFilters();
			});
		});
	}

	if (searchInput) {
		searchInput.addEventListener("input", applyFilters);
	}
})();
</script>

<?php get_footer(); ?>
