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

if ( pwpp_have_posts() ) :
?>
<div id="pwpp-portfolio-grid">
	<div class="premise-row"><?php
		while ( pwpp_have_posts() ) {
			pwpp_the_post();
			?>
			<div class="pwpp-item <? echo pwpp_get_grid_param(); ?>">
				<a href="<?php the_permalink(); ?>" class="premise-block">
					<div class="pwpp-item-inner">
						<?php if ( '' !== get_the_title() ) : ?>
							<div class="pwpp-post-title">
								<h2><?php the_title(); ?></h2>
							</div>
						<?php endif; ?>
						<?php if ( has_post_thumbnail() ) : ?>
								<?php pwpp_the_thumbnail(); ?>
						<?php endif; ?>
						<?php if ( (boolean) $this->a['show-cta'] ) echo pwpp_get_the_call_to_action(); ?>
						<div class="pwpp-post-excerpt">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</a>
			</div>
			<?
		} ?>
	</div>
</div>
<?php endif; ?>