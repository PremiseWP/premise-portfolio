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
get_header(); ?>

<section id="pwpp-portfolio-grid" class="premise-block premise-clear-float">

	<div class="pwpp-container premise-clear-float">

		<?php
		if ( pwpp_have_posts() ) : ?>
			<div class="pwpp-the-loop">
				<div class="premise-row"><?php
					while ( pwpp_have_posts() ) { pwpp_the_post(); ?>

						<div <?php pwpp_loop_item_attrs(); ?>>
								<div class="pwpp-item-inner">
									<?php if ( '' !== get_the_title() && ! premise_get_value( 'pwpp_portfolio[loop][hide][title]' ) ) : ?>
										<div class="pwpp-post-title">
											<a href="<?php the_permalink(); ?>">
												<h2><?php the_title(); ?></h2>
											</a>
										</div>
									<?php endif; ?>
									<a href="<?php the_permalink(); ?>">
										<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][thumbnail]' ) ) pwpp_the_thumbnail( 'loop' ); ?>
									</a>
									<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][excerpt]' ) ) : ?>
										<div class="pwpp-post-excerpt">
											<?php
											if ( premise_get_value( 'pwpp_portfolio[loop][excerpt]' ) ) {
												the_excerpt();
											}
											else {
												the_content();
											} ?>
										</div>
									<?php endif; ?>
									<?php if ( ! premise_get_value( 'pwpp_portfolio[loop][hide][meta]' ) ) : ?>
										<div class="pwpp-post-meta">
											By: <?php the_author(); ?>
										</div>
									<?php endif; ?>
								</div>
						</div>

					<?php
					} ?>
				</div>
			</div>
		<?php endif; ?>

	</div>

</section>

<?php get_footer(); ?>