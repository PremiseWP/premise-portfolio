<?php
/**
 * Premise Portfolio Loop Template
 *
 * This template is the default template for loading the premise portfolio loop. It can be useed as starter to create your own
 * loop template. Simply copy this file and paste in your theme's directory. You can change the html, classes, ids and create your own template
 * with very little work.
 *
 * @package premise-portfolio\view
 */

?>

<section id="pwpp-portfolio-grid" class="premise-block premise-clear-float">

	<div class="pwpp-container premise-clear-float">

		<?php if ( pwpp_have_posts() ) : ?>

			<div class="pwpp-the-loop">
				<div <?php pwpp_loop_class(); ?>>

					<?php while ( pwpp_have_posts() ) : pwpp_the_post(); ?>

							<div <?php pwpp_loop_item_class( 'pwpp-item' ); ?>>
									<div class="pwpp-item-inner">

										<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][title]' ) ) : ?>
											<div class="pwpp-post-title">
												<a href="<?php the_permalink(); ?>">
													<h3><?php the_title(); ?></h3>
												</a>
											</div>
										<?php endif; ?>

										<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][thumbnail]' ) ) : ?>
											<div class="pwpp-post-thumbnail">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail( 'pwpp-loop-thumbnail', array( 'class' => 'pwp-responsive' ) ); ?>
												</a>
											</div>
										<?php endif; ?>

										<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][excerpt]' ) ) : ?>
											<div class="pwpp-post-excerpt">
												<?php ( premise_get_value( 'pwpp_portfolio[loop][excerpt]' ) )
													? the_excerpt()
													: the_content(); ?>
											</div>
										<?php endif; ?>

										<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][meta]' ) ) : ?>
											<div class="pwpp-post-meta">
												<div class="pwpp-author">By: <?php the_author(); ?></div>
												<div class="pwpp-cats">Categories: <?php the_terms( get_the_ID(), 'premise-portfolio-category', '', ', ' ); ?></div>
												<div class="pwpp-tags">Tags: <?php the_terms( get_the_ID(), 'premise-portfolio-tag', '', ', ' ); ?></div>
											</div>
										<?php endif; ?>

									</div>
							</div>

					<?php endwhile; ?>

				</div>
			</div>

		<?php endif; ?>

	</div>

</section>
