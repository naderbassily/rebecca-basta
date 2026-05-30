<?php
/**
 * Template Name: Contact
 *
 * @package Rebecca-Basta
 */

// Handle form submission
$form_sent    = false;
$form_error   = false;
$form_message = '';

if ( isset( $_POST['rb_contact_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rb_contact_nonce'] ) ), 'rb_contact_form' ) ) {

	$name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
	$type    = sanitize_text_field( wp_unslash( $_POST['contact_type'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

	if ( empty( $name ) || empty( $email ) || empty( $message ) || ! is_email( $email ) ) {
		$form_error   = true;
		$form_message = __( 'Please fill in all required fields with a valid email address.', 'rebecca' );
	} else {
		$to      = 'me@naderramsis.com';
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		);

		$email_subject = '[Rebecca Basta] ' . ( $subject ?: $type ?: __( 'New Contact Message', 'rebecca' ) );

		$email_body  = '<p><strong>' . esc_html__( 'Name:', 'rebecca' ) . '</strong> ' . esc_html( $name ) . '</p>';
		$email_body .= '<p><strong>' . esc_html__( 'Email:', 'rebecca' ) . '</strong> ' . esc_html( $email ) . '</p>';
		if ( $type ) {
			$email_body .= '<p><strong>' . esc_html__( 'Inquiry type:', 'rebecca' ) . '</strong> ' . esc_html( $type ) . '</p>';
		}
		$email_body .= '<hr>';
		$email_body .= '<p>' . nl2br( esc_html( $message ) ) . '</p>';

		$sent = wp_mail( $to, $email_subject, $email_body, $headers );

		if ( $sent ) {
			$form_sent    = true;
			$form_message = __( 'Thank you — your message has been received. I\'ll be in touch shortly.', 'rebecca' );
		} else {
			$form_error   = true;
			$form_message = __( 'Something went wrong. Please try again or email directly.', 'rebecca' );
		}
	}
}

get_header();
?>

<main id="primary" class="cp-page">

	<!-- ── Hero ──────────────────────────────────────────────────── -->
	<section class="cp-hero">
		<div class="container">
			<span class="cp-kicker"><?php esc_html_e( 'Get in Touch', 'rebecca' ); ?></span>
			<h1 class="cp-heading"><?php the_title(); ?></h1>
			<?php if ( get_the_content() ) : ?>
				<div class="cp-hero-text wp-content"><?php the_content(); ?></div>
			<?php else : ?>
				<p class="cp-hero-sub"><?php esc_html_e( 'Whether you\'re interested in speaking engagements, consulting, media inquiries, academic collaboration, or simply want to connect — I\'d love to hear from you.', 'rebecca' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ── Main body ─────────────────────────────────────────────── -->
	<section class="cp-body">
		<div class="container cp-body-inner">

			<!-- ── Left: Form ────────────────────────────────────── -->
			<div class="cp-form-col">

				<?php if ( $form_sent ) : ?>
					<div class="cp-success">
						<div class="cp-success-icon">✓</div>
						<h3><?php esc_html_e( 'Message Sent', 'rebecca' ); ?></h3>
						<p><?php echo esc_html( $form_message ); ?></p>
					</div>
				<?php else : ?>

				<?php if ( $form_error ) : ?>
					<div class="cp-alert"><?php echo esc_html( $form_message ); ?></div>
				<?php endif; ?>

				<form class="cp-form" method="post" action="<?php the_permalink(); ?>#contact-form" id="contact-form" novalidate>
					<?php wp_nonce_field( 'rb_contact_form', 'rb_contact_nonce' ); ?>

					<div class="cp-form-row">
						<div class="cp-field">
							<label for="contact_name"><?php esc_html_e( 'Full Name', 'rebecca' ); ?> <span>*</span></label>
							<input type="text" id="contact_name" name="contact_name"
								   value="<?php echo esc_attr( $_POST['contact_name'] ?? '' ); ?>"
								   placeholder="<?php esc_attr_e( 'Rebecca M. Basta', 'rebecca' ); ?>"
								   required>
						</div>
						<div class="cp-field">
							<label for="contact_email"><?php esc_html_e( 'Email Address', 'rebecca' ); ?> <span>*</span></label>
							<input type="email" id="contact_email" name="contact_email"
								   value="<?php echo esc_attr( $_POST['contact_email'] ?? '' ); ?>"
								   placeholder="you@example.com"
								   required>
						</div>
					</div>

					<div class="cp-field">
						<label for="contact_type"><?php esc_html_e( 'Inquiry Type', 'rebecca' ); ?></label>
						<div class="cp-select-wrap">
							<select id="contact_type" name="contact_type">
								<option value=""><?php esc_html_e( 'Select a topic', 'rebecca' ); ?></option>
								<option value="Speaking" <?php selected( $_POST['contact_type'] ?? '', 'Speaking' ); ?>><?php esc_html_e( 'Speaking Engagement', 'rebecca' ); ?></option>
								<option value="Consulting" <?php selected( $_POST['contact_type'] ?? '', 'Consulting' ); ?>><?php esc_html_e( 'Consulting', 'rebecca' ); ?></option>
								<option value="Media" <?php selected( $_POST['contact_type'] ?? '', 'Media' ); ?>><?php esc_html_e( 'Media & Press', 'rebecca' ); ?></option>
								<option value="Academic" <?php selected( $_POST['contact_type'] ?? '', 'Academic' ); ?>><?php esc_html_e( 'Academic Collaboration', 'rebecca' ); ?></option>
								<option value="Book" <?php selected( $_POST['contact_type'] ?? '', 'Book' ); ?>><?php esc_html_e( 'Book / Publishing', 'rebecca' ); ?></option>
								<option value="Other" <?php selected( $_POST['contact_type'] ?? '', 'Other' ); ?>><?php esc_html_e( 'Other', 'rebecca' ); ?></option>
							</select>
							<svg class="cp-select-arrow" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
						</div>
					</div>

					<div class="cp-field">
						<label for="contact_subject"><?php esc_html_e( 'Subject', 'rebecca' ); ?></label>
						<input type="text" id="contact_subject" name="contact_subject"
							   value="<?php echo esc_attr( $_POST['contact_subject'] ?? '' ); ?>"
							   placeholder="<?php esc_attr_e( 'How can I help?', 'rebecca' ); ?>">
					</div>

					<div class="cp-field">
						<label for="contact_message"><?php esc_html_e( 'Message', 'rebecca' ); ?> <span>*</span></label>
						<textarea id="contact_message" name="contact_message" rows="6"
								  placeholder="<?php esc_attr_e( 'Tell me about your project or inquiry…', 'rebecca' ); ?>"
								  required><?php echo esc_textarea( $_POST['contact_message'] ?? '' ); ?></textarea>
					</div>

					<button type="submit" class="cp-submit">
						<?php esc_html_e( 'Send Message', 'rebecca' ); ?>
						<svg viewBox="0 0 24 24"><path d="M5 12H19M12 5L19 12L12 19"/></svg>
					</button>
				</form>

				<?php endif; ?>
			</div>

			<!-- ── Right: Info ───────────────────────────────────── -->
			<div class="cp-info-col">

				<div class="cp-info-block">
					<h3 class="cp-info-title"><?php esc_html_e( 'Let\'s Connect', 'rebecca' ); ?></h3>
					<p class="cp-info-text"><?php esc_html_e( 'I welcome inquiries from educators, researchers, organizations, and media professionals interested in AI, cybersecurity, and data science.', 'rebecca' ); ?></p>
				</div>

				<div class="cp-info-items">
					<div class="cp-info-item">
						<div class="cp-info-icon">
							<svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						</div>
						<div>
							<div class="cp-info-label"><?php esc_html_e( 'Email', 'rebecca' ); ?></div>
							<a href="mailto:contact@rebeccabasta.com" class="cp-info-value">contact@rebeccabasta.com</a>
						</div>
					</div>

					<div class="cp-info-item">
						<a href="https://www.linkedin.com/in/rebecca-basta/" target="_blank" rel="noopener noreferrer" class="cp-info-icon cp-info-icon--link" aria-label="<?php esc_attr_e( 'LinkedIn Profile', 'rebecca' ); ?>">
							<svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
						</a>
					</div>
				</div>

			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
