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

<section id="pwpp-single-portfolio" class="">
	
	<div class="pwpp-container">
		
		<?php if ( have_posts() ) :
			
			while ( have_posts() ) : the_post(); ?>
				
				<!-- The title -->
				<div class="pwpp-post-title">
					<h1><?php the_title(); ?></h1>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<!-- The featured image -->
					<div class="pwpp-post-thumbnail">
						<?php the_post_thumbnail( 'full', array( 'class' => 'premise-responsive' ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $pwpp_cta_url ) : ?>
					<!-- The CTA -->
					<div class="pwpp-post-cta">
						<a href="<?php echo esc_url( $pwpp_portfolio['cta-url'] ); ?>" class="pwpp-post-cta-url">
							
							<?php if ( '' !== $pwpp_cta_text ) : ?>
								<span class="pwpp-post-cta-text">
									<?php echo esc_html( $pwpp_portfolio['cta-text'] ); ?>
								</span>
							<?php endif; ?>

						</a>
					</div>
				<?php endif; ?>

				<!-- The content -->
				<div class="pwpp-post-content">
					<?php the_content(); ?>
				</div>

			<?php endwhile;

		else :
			
			# what happens if there are no posts?

		endif; ?>

	</div>

</section>

<?php get_footer(); ?>