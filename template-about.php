<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * @package Rebecca-Basta
 */

get_header();

$research_areas = array(
	__( 'Artificial Intelligence & Machine Learning', 'rebecca' ),
	__( 'Cybersecurity & Threat Modeling', 'rebecca' ),
	__( 'Industrial Control Systems Security', 'rebecca' ),
	__( 'Data Science & Health Analytics', 'rebecca' ),
	__( 'Bioinformatics & Medical Research', 'rebecca' ),
	__( 'Applied Mathematics & Cryptography', 'rebecca' ),
	__( 'Governance, Risk & Compliance', 'rebecca' ),
	__( 'Medical Device & Supply Chain Security', 'rebecca' ),
);
?>

<main id="primary" class="about-page">

	<section class="about-hero">
		<div class="container">
			<div class="about-hero-content">
				<h1 class="about-hero-title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
				<div class="about-expert wp-content">
					<?php the_excerpt(); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php while ( have_posts() ) : the_post(); ?>

	<section class="about-content-section">
		<div class="container">
			<div class="about-layout">

				<div class="about-text">
					<div class="entry-content wp-content">
						<?php the_content(); ?>
					</div>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
				<div class="about-image-col">
					<div class="about-image">
						<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
					</div>
					<div class="about-stats">
						<div class="about-stat">
							<div class="about-stat-number"><span class="stat-count" data-target="20">0</span><span>+</span></div>
							<div class="about-stat-label"><?php esc_html_e( 'Published Titles', 'rebecca' ); ?></div>
						</div>
						<div class="about-stat">
							<div class="about-stat-number"><span class="stat-count" data-target="30">0</span><span>+</span></div>
							<div class="about-stat-label"><?php esc_html_e( 'Professional Certifications', 'rebecca' ); ?></div>
						</div>
						<div class="about-stat">
							<div class="about-stat-number"><span class="stat-count" data-target="8">0</span><span>+</span></div>
							<div class="about-stat-label"><?php esc_html_e( 'Research Domains', 'rebecca' ); ?></div>
						</div>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</section>

	<section class="section section-deep research-section">
		<div class="container">
			<span class="section-label"><?php esc_html_e( 'Areas of Focus', 'rebecca' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Research & Expertise', 'rebecca' ); ?></h2>

			<div class="research-grid">
				<?php foreach ( $research_areas as $index => $area ) : ?>
					<div class="research-item">
						<div class="research-number"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
						<div class="research-name"><?php echo esc_html( $area ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php endwhile; ?>

</main>

<?php
get_footer();
