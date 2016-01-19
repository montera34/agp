<?php
/**
 * @package Ridge
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php ridge_post_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ridge' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php //edit_post_link( __( 'Edit This Post', 'ridge' ), '<span class="edit-link">', '</span>' ); ?>
		<?php //ridge_post_nav();
		// go back buttons
		$s_out = "<span class='goback'>Volver a</span><ul class='filter-btns-small'><li><a href='".get_home_url()."'>Portada</a></li>
		<li><a title='Volver al listado de textos' href='".get_home_url()."/textos'>Textos</a></li>
		</ul>";
		echo $s_out; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
