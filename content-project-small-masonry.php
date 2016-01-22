<?php
/**
 * The template used for displaying project thumbs
 *
 * @package Ridge
 * @since 1.0
 */

/** @var string $skills_class  Isotope-filterable skills for the project */
$skills = ridge_get_tax( $post ); /** @see inc/template-tags.php */
$skills_class = $skills['isotope_class'];

$project_perma = get_permalink();
if ( is_archive() ) { $project_perma .= "?ref=skill"; }
?>

					<figure class="project small<?php echo ' ' . $skills_class; ?>" id="<?php echo $post->ID; ?>">
						<div class="inside">
						<?php if( has_post_thumbnail() ) {
							the_post_thumbnail( 'ridge_thumb_masonry', array( 'class' => '', 'alt' => '' . the_title_attribute( 'echo=0' ) . '', 'title' => '' . the_title_attribute( 'echo=0' ) . '' ) );
						} else { ?>
							<span class="empty-project"></span>
						<?php } ?>

						<figcaption>
							<div class="inner">
								<?php ridge_the_thumb_title(); /** @see inc/template-tags.php */ ?>
							</div>
						</figcaption>

						<a href="<?php echo $project_perma; ?>" alt="<?php echo the_title_attribute( 'echo=0' ); ?>"></a>
						</div>
					</figure><!-- #post->ID -->
