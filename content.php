<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Ridge
 * @since 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		
		
			<?php 
			the_post_thumbnail( 'ridge_full_width' );
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			?>
			<div class="entry-meta">
				<?php ridge_post_meta(); ?>
			</div><!-- .entry-meta -->
		<div class="inner">	
			<?php		
			ridge_the_excerpt( 300, $post ); 			
			?>
		</div>
		
	</div><!-- .entry-content -->

</article><!-- #post-## -->
