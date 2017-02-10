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

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="pwpp-post-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'pwpp-loop-thumbnail', array( 'class' => 'pwp-responsive' ) ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php pwpp_the_custom_fields(); ?>

				<!-- The content -->
				<div class="pwpp-post-content">
					<?php the_content(); ?>
				</div>

				<!-- The category -->
				<div class="pwpp-post-category">
					<?php echo ( $category_list = get_the_term_list( get_the_id(), 'premise-portfolio-category' ) )
						? 'Categories: ' . $category_list
						: ''; ?>
				</div>

				<!-- The tags -->
				<div class="pwpp-post-tags">
					<?php echo ( $tag_list = get_the_term_list( get_the_id(), 'premise-portfolio-tag' ) )
						? 'Tags: ' . $tag_list
						: ''; ?>
				</div>

			<?php endwhile;

		else :

			echo '<p>It looks like no Portfolio Posts were found.</p>';

		endif; ?>

	</div>

</section>

<?php get_footer(); ?>
