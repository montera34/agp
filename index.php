<?php
/**
 * The main template file
 *
 * @package Ridge
 * @since 1.0
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
		
		<?php
		if ( ! is_front_page() ) {

			$blog_page_id = get_option( 'page_for_posts' );
			$blog_page 	  = get_post( $blog_page_id );

		?>

			<header class="main entry-header">
				<h1 class="entry-title"><?php echo $blog_page->post_title; ?></h1>

				<?php if( $blog_page->post_excerpt ) { ?>

				<p class="entry-excerpt">
					<?php echo $blog_page->post_excerpt; ?>
				</p>

				<?php } ?>

				<?php // categories menu
				$categories = get_categories();
				if ( count($categories) >> 0 ) {
					$c_out = "<ul id='filter-cat'>";
					foreach ( $categories as $c ) {
						$c_perma = get_category_link( $c->term_id );
						$c_out .= "<li><a href='".$c_perma."'>".$c->name."</a></li>";
					}
					$c_out .= "</ul>";
					echo $c_out;
				} ?>
			</header><!-- .entry-header -->
		<?php
		} // if()
		?>


        <div id="blog">
            
                <?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content' );
						?>

					<?php endwhile; ?>		

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>
        
        </div><!-- #blog -->
		<?php ridge_paging_nav(); ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
