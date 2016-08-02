<?php
/**
 * Premise Portfolio post view
 *
 * @package premise-portfolio\view
 */

// set our variables
$pwpp_portfolio = premise_get_value( 'premise_portfolio', 'post' );

// CTA
$pwpp_cta_url  = (string) isset( $pwpp_portfolio['cta-url'] )  ? $pwpp_portfolio['cta-url']  : '';
$pwpp_cta_text = (string) isset( $pwpp_portfolio['cta-text'] ) ? $pwpp_portfolio['cta-text'] : '';

get_header();

?>

<section id="pwpp-single-portfolio" class="premise-block premise-clear-float">

	<div class="pwpp-container premise-clear-float">

		<?php if ( have_posts() ) :

			while ( have_posts() ) : the_post(); ?>

				<!-- The title -->
				<div class="pwpp-post-title">
					<h1><?php the_title(); ?></h1>
				</div>

				<?php if ( '' !== $pwpp_cta_url ) : ?>
					<a href="<?php echo esc_url( $pwpp_cta_url ); ?>" class="premise-block" target="_blank">
						<?php pwpp_the_thumbnail(); ?>
					</a>
				<?php else : ?>
					<?php pwpp_the_thumbnail(); ?>
				<?php endif; ?>

				<!-- The content -->
				<div class="pwpp-post-content">
					<?php the_content(); ?>
				</div>

				<?php if ( '' !== $pwpp_cta_url ) : ?>
					<!-- The CTA -->
					<div class="pwpp-post-cta">
						<a href="<?php echo esc_url( $pwpp_portfolio['cta-url'] ); ?>" class="pwpp-post-cta-url" target="_blank">

							<?php if ( '' !== $pwpp_cta_text ) : ?>
								<span class="pwpp-post-cta-text">
									<?php echo esc_html( $pwpp_portfolio['cta-text'] ); ?>
								</span>
							<?php endif; ?>

						</a>
					</div>
				<?php endif; ?>

			<?php endwhile;

		else :

			echo '<p>It looks like no Portfolio Posts were found.</p>';

		endif; ?>

	</div>

</section>

<?php get_footer(); ?>