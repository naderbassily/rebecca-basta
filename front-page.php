<?php
/**
 * Homepage template.
 *
 * @package Rebecca-Basta
 */
$email_address = sanitize_email( get_option( 'admin_email' ) );
$email_link    = $email_address ? 'mailto:' . antispambot( $email_address ) : '#';

$pillars = array(
	array(
		'name' => __( 'Artificial Intelligence', 'rebecca' ),
		'desc' => __( 'AI governance, adversarial machine learning, federated learning, and AI-driven threat detection across offensive and defensive security domains', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><rect x="11" y="11" width="18" height="18" rx="2"/><path d="M15 11V8M20 11V8M25 11V8M15 29v3M20 29v3M25 29v3M11 15H8M11 20H8M11 25H8M29 15h3M29 20h3M29 25h3"/><rect x="16" y="16" width="8" height="8" rx="1"/></svg>',
	),
	array(
		'name' => __( 'Cybersecurity', 'rebecca' ),
		'desc' => __( 'Medical device security, industrial control systems, red team operations, governance, risk and compliance, and ISO 27001 / ISO 42001 frameworks', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><path d="M20 5L7 10v9c0 7.5 5.6 14.4 13 16.2C27.4 33.4 33 26.5 33 19v-9L20 5z"/><path d="M14 20l4 4 8-8"/></svg>',
	),
	array(
		'name' => __( 'Data Science', 'rebecca' ),
		'desc' => __( 'Advanced analytics with Python and R, bioinformatics, supply chain intelligence, anomaly detection, and health data analytics', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><rect x="6" y="22" width="7" height="12" rx="1"/><rect x="16" y="14" width="7" height="20" rx="1"/><rect x="26" y="7" width="7" height="27" rx="1"/><path d="M9 20L19 12L29 6" stroke-dasharray="2 2"/></svg>',
	),
	array(
		'name' => __( 'Mathematics', 'rebecca' ),
		'desc' => __( 'Applied mathematics, cryptography, quantum-resistant protocols, and the mathematical foundations of computation and security', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><path d="M6 28l6-16 6 10 6-16 6 16"/><path d="M6 34h28" stroke-dasharray="2 2"/></svg>',
	),
	array(
		'name' => __( 'Bioinformatics & Medical Research', 'rebecca' ),
		'desc' => __( 'MS in Bioinformatics and BS in Biochemistry, bridging healthcare data analytics, personalized medicine security, and medical device protection', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><path d="M15 4c0 6 10 7 10 12S15 23 15 28M25 4c0 6-10 7-10 12S25 23 25 28"/><line x1="15" y1="10" x2="25" y2="10"/><line x1="15" y1="16" x2="25" y2="16"/><line x1="15" y1="22" x2="25" y2="22"/></svg>',
	),
	array(
		'name' => __( 'Education', 'rebecca' ),
		'desc' => __( 'Curriculum development from K-12 cybersecurity awareness to higher education, with published standards for cybersecurity curricula and competency-based learning', 'rebecca' ),
		'icon' => '<svg viewBox="0 0 40 40" aria-hidden="true"><path d="M20 7L4 16L20 25L36 16L20 7Z"/><path d="M12 20.5v6c0 3.5 3.6 5.5 8 5.5s8-2 8-5.5v-6"/><path d="M34 17v8"/><circle cx="34" cy="26" r="2"/></svg>',
	),
);

$connect_types = array(
	__( 'Speaking', 'rebecca' ),
	__( 'Consulting', 'rebecca' ),
	__( 'Media', 'rebecca' ),
	__( 'Academic', 'rebecca' ),
	__( 'Collaboration', 'rebecca' ),
);

get_header();

$books_archive_url = get_post_type_archive_link( 'book' );
?>

<main id="primary" class="homepage-main">
	<section class="hero" id="hero">
		<div class="hero-gradient"></div>
		<div class="hero-photo">
			<img src="<?php echo esc_url( site_url( '/wp-content/uploads/2026/05/rb-hero-2.png' ) ); ?>" alt="<?php esc_attr_e( 'Rebecca M. Basta', 'rebecca' ); ?>">
		</div>
		<div class="hero-content" id="heroContent">
			<div class="hero-label" id="heroLabel"><?php esc_html_e( 'Author · Researcher · Educator', 'rebecca' ); ?></div>
			<h1 class="hero-name" id="heroName"><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></h1>
			<div class="hero-rule" id="heroRule"></div>
			<p class="hero-tagline" id="heroTagline"><?php esc_html_e( 'Architecting the future of Artificial Intelligence,', 'rebecca' ); ?><br><?php esc_html_e( 'Cybersecurity & Data Science', 'rebecca' ); ?></p>
		</div>
		<div class="hero-scroll" id="heroScroll">
			<span class="hero-scroll-text"><?php esc_html_e( 'Scroll', 'rebecca' ); ?></span>
			<div class="hero-scroll-line"></div>
		</div>
	</section>

	<section class="section section-cream pillars" id="about">
		<div class="container">
			<span class="section-label reveal"><?php esc_html_e( 'The Dimensions', 'rebecca' ); ?></span>
			<h2 class="section-title reveal reveal-delay-1"><?php esc_html_e( 'Author. Researcher. Educator.', 'rebecca' ); ?></h2>
			<p class="pillars-subtitle reveal reveal-delay-2"><?php esc_html_e( 'Bioinformatics specialist and cybersecurity educator with a Master of Science in Bioinformatics and a Bachelor of Science in Biochemistry, bridging healthcare technology, data science, and security through rigorous research, 30+ professional certifications, and published scholarship.', 'rebecca' ); ?></p>

			<div class="pillars-grid">
				<?php foreach ( $pillars as $index => $pillar ) : ?>
					<div class="pillar-card reveal reveal-delay-<?php echo esc_attr( min( $index + 1, 6 ) ); ?>">
						<div class="pillar-icon">
							<?php echo wp_kses( $pillar['icon'], array(
								'svg'     => array( 'viewbox' => true, 'aria-hidden' => true ),
								'path'    => array( 'd' => true, 'stroke-dasharray' => true ),
								'rect'    => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true ),
								'circle'  => array( 'cx' => true, 'cy' => true, 'r' => true, 'stroke-dasharray' => true ),
								'line'    => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
								'polygon' => array( 'points' => true ),
								'ellipse' => array( 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true ),
							) ); ?>
						</div>
						<div class="pillar-name"><?php echo esc_html( $pillar['name'] ); ?></div>
						<div class="pillar-desc"><?php echo esc_html( $pillar['desc'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section section-dark works-section" id="works">
		<div class="works-header">
			<span class="section-label reveal"><?php esc_html_e( 'Published Works', 'rebecca' ); ?></span>
			<h2 class="section-title reveal reveal-delay-1"><?php esc_html_e( 'Selected Works', 'rebecca' ); ?></h2>
		</div>

		<?php
		$books_query = new WP_Query(
			array(
				'post_type'      => 'book',
				'posts_per_page' => 8,
				'post_status'    => 'publish',
				'meta_key'       => 'on_home_page',
				'meta_value'     => '1',
				'tax_query'      => array(
					array(
						'taxonomy' => 'genre',
						'field'    => 'slug',
						'terms'    => array( 'coming-soon' ),
						'operator' => 'NOT IN',
					),
				),
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
			)
		);
		?>

		<div class="works-track-wrapper">
			<div class="works-track" id="worksTrack">
				<?php if ( $books_query->have_posts() ) : ?>
					<?php
					$book_index = 0;
					while ( $books_query->have_posts() ) :
						$books_query->the_post();
						$genre_terms = get_the_terms( get_the_ID(), 'genre' );
						$genre_label = '';

						if ( ! is_wp_error( $genre_terms ) && ! empty( $genre_terms ) ) {
							$genre_label = implode(
								' · ',
								wp_list_pluck( $genre_terms, 'name' )
							);
						}
						?>
						<a href="<?php the_permalink(); ?>" class="work-card" data-index="<?php echo esc_attr( $book_index ); ?>">
							<div class="work-cover">
								<div class="work-cover-accent"></div>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="work-cover-image">
										<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
									</div>
								<?php else : ?>
									<div class="work-cover-fallback">
										<div class="work-cover-author"><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></div>
										<div class="work-cover-title"><?php the_title(); ?></div>
									</div>
								<?php endif; ?>
							</div>
							<div class="work-title"><?php the_title(); ?></div>
							<div class="work-meta"><?php echo esc_html( $genre_label ? $genre_label : __( 'Book', 'rebecca' ) ); ?></div>
						</a>
						<?php
						$book_index++;
					endwhile;
					wp_reset_postdata();
					?>
				<?php else : ?>
					<div class="work-card active" data-index="0">
						<div class="work-cover">
							<div class="work-cover-accent"></div>
							<div class="work-cover-fallback">
								<div class="work-cover-author"><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></div>
								<div class="work-cover-title"><?php esc_html_e( 'Books Coming Soon', 'rebecca' ); ?></div>
							</div>
						</div>
						<div class="work-title"><?php esc_html_e( 'Selected Works', 'rebecca' ); ?></div>
						<div class="work-meta"><?php esc_html_e( 'Add Book posts to populate this section', 'rebecca' ); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="works-nav">
			<button class="works-nav-btn" id="worksPrev" type="button" aria-label="<?php esc_attr_e( 'Previous', 'rebecca' ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18L9 12L15 6"/></svg>
			</button>
			<div class="works-dots" id="worksDots"></div>
			<button class="works-nav-btn" id="worksNext" type="button" aria-label="<?php esc_attr_e( 'Next', 'rebecca' ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6L15 12L9 18"/></svg>
			</button>
		</div>

		<?php if ( $books_archive_url ) : ?>
			<div class="works-footer reveal reveal-delay-2">
				<a href="<?php echo esc_url( $books_archive_url ); ?>" class="works-all-link">
					<?php esc_html_e( 'View All Books', 'rebecca' ); ?>
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
				</a>
			</div>
		<?php endif; ?>
	</section>

	<?php
	$coming_soon_query = new WP_Query(
		array(
			'post_type'      => 'book',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'slug',
					'terms'    => array( 'coming-soon' ),
				),
			),
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
		)
	);

	if ( $coming_soon_query->have_posts() ) :
	?>
	<section class="section section-cream coming-books-section">
		<div class="container">
			<div class="coming-books-header">
				<span class="section-label reveal"><?php esc_html_e( 'On The Horizon', 'rebecca' ); ?></span>
				<h2 class="section-title reveal reveal-delay-1"><?php esc_html_e( 'Coming Soon Books', 'rebecca' ); ?></h2>
			</div>

			<div class="coming-books-grid">
				<?php
				$coming_index = 0;
				while ( $coming_soon_query->have_posts() ) :
					$coming_soon_query->the_post();
					$coming_terms = get_the_terms( get_the_ID(), 'genre' );
					$coming_label = '';

					if ( ! is_wp_error( $coming_terms ) && ! empty( $coming_terms ) ) {
						$coming_label = implode( ' · ', wp_list_pluck( $coming_terms, 'name' ) );
					}
					?>
					<a href="<?php the_permalink(); ?>" class="work-card reveal reveal-delay-<?php echo esc_attr( min( $coming_index + 1, 6 ) ); ?>">
						<div class="work-cover">
							<div class="work-cover-accent"></div>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="work-cover-image">
									<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
								</div>
							<?php else : ?>
								<div class="work-cover-fallback">
									<div class="work-cover-author"><?php esc_html_e( 'Rebecca M. Basta', 'rebecca' ); ?></div>
									<div class="work-cover-title"><?php the_title(); ?></div>
								</div>
							<?php endif; ?>
						</div>
						<div class="work-title"><?php the_title(); ?></div>
						<div class="work-meta"><?php echo esc_html( $coming_label ? $coming_label : __( 'Coming Soon', 'rebecca' ) ); ?></div>
					</a>
					<?php
					$coming_index++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>


	<section class="section section-cream authority-section">
		<div class="container">
			<div class="authority-publisher reveal">
				<div class="authority-publisher-label"><?php esc_html_e( 'Published By', 'rebecca' ); ?></div>
				<div class="authority-publisher-name">Wiley &amp; Kendall Hall</div>
				<div class="authority-publisher-sub"><?php esc_html_e( 'Among the world\'s most prestigious academic and technical publishers', 'rebecca' ); ?></div>
			</div>
		</div>
	</section>

	<section class="section section-dark quote-section">
		<div class="container reveal">
			<div class="quote-mark">"</div>
			<blockquote class="quote-text"><?php esc_html_e( 'The gap between cybersecurity professionals and healthcare practitioners is not a technical problem — it is a communication problem. Bridging it requires both rigorous science and the courage to speak plainly across disciplines.', 'rebecca' ); ?></blockquote>
			<div class="quote-attribution"><?php esc_html_e( '— Rebecca M. Basta', 'rebecca' ); ?></div>
		</div>
	</section>

	<section class="section section-cream connect-section" id="connect">
		<div class="container">
			<span class="section-label reveal"><?php esc_html_e( 'The Invitation', 'rebecca' ); ?></span>
			<h2 class="section-title reveal reveal-delay-1"><?php esc_html_e( 'Connect', 'rebecca' ); ?></h2>

			<div class="connect-types reveal reveal-delay-2">
				<?php foreach ( $connect_types as $type ) : ?>
					<span class="connect-type"><?php echo esc_html( $type ); ?></span>
				<?php endforeach; ?>
			</div>

			<div class="reveal reveal-delay-3">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="connect-cta">
					<?php esc_html_e( 'Get in Touch', 'rebecca' ); ?>
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
				</a>
			</div>

			<div class="connect-links reveal reveal-delay-4">
				<a href="#" class="connect-link"><?php esc_html_e( 'LinkedIn', 'rebecca' ); ?></a>
				<span class="connect-separator"></span>
				<a href="<?php echo esc_url( $email_link ); ?>" class="connect-link"><?php esc_html_e( 'Email', 'rebecca' ); ?></a>
				<span class="connect-separator"></span>
				<a href="#" class="connect-link"><?php esc_html_e( 'Publisher', 'rebecca' ); ?></a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
