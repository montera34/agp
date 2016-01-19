<?php
/**
 * The template for displaying archive pages
 *
 * @package Ridge
 * @since 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area middle portfolio">
		<main id="main" class="site-main" role="main">

			<header class="main entry-header">
				<?php
					//the_archive_title( '<h1 class="entry-title">', '</h1>' );
					echo "<h1 class='entry-title'>".single_cat_title( '', false )."</h1>";
					the_archive_description( '<div class="meta taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div id="projects" class="masonry">
				<div class="thumbs clearfix">

	              			<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post();
							global $ttrust_config;

								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								//get_template_part( 'content' );
								get_template_part( 'content', 'project-small-masonry' );
							?>

						<?php endwhile; ?>		

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>

	        		</div><!-- .thumbs -->
	        	</div><!-- #projects -->
			<?php ridge_paging_nav(); ?>
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
