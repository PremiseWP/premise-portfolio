<?php
/**
 * Premise Portfolio post view
 *
 * @package premise-portfolio\view
 */

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

				<?php if ( pwpp_get_cta_url() ) : ?>
					<a href="<?php echo esc_url( (string) pwpp_get_cta_url() ); ?>" class="premise-block" target="_blank">
						<?php pwpp_the_thumbnail(); ?>
					</a>
				<?php else : ?>
					<?php pwpp_the_thumbnail(); ?>
				<?php endif; ?>

				<?php pwpp_the_custom_fields(); ?>

				<!-- The content -->
				<div class="pwpp-post-content">
					<?php the_content(); ?>
				</div>

				<!-- The category -->
				<div class="pwpp-post-category">
					<?php the_terms( get_the_id(), 'premise-portfolio-category' ); ?>
				</div>

				<!-- The tags -->
				<div class="pwpp-post-tags">
					<?php the_terms( get_the_id(), 'premise-portfolio-tag' ); ?>
				</div>

			<?php endwhile;

		else :

			echo '<p>It looks like no Portfolio Posts were found.</p>';

		endif; ?>

	</div>

</section>

<?php get_footer(); ?>
