<?php
// theme setup main function
add_action( 'after_setup_theme', 'agp_theme_setup' );
function agp_theme_setup() {

	/* Load JavaScript files */
	add_action( 'wp_print_scripts', 'elkartoki_load_frontend_scripts',100);

	// Adds new rewrite rules to Ridge parent theme existing ones
	add_action('after_switch_theme', 'agp_custom_rewrite_rules');

} // END theme setup main function

// load js scripts to avoid conflicts
function elkartoki_load_frontend_scripts() {
	wp_dequeue_script('ridge-functions');
	wp_enqueue_script(
		'agp-ridge-functions',
		get_stylesheet_directory_uri().'/js/theme_trust.js',
		array( 'jquery' ),
		'1.0',
		true
	);
	wp_enqueue_script(
		'agp-functions',
		get_stylesheet_directory_uri().'/js/agp.js',
		array( 'jquery' ),
		'1.0',
		true
	);

} // end load frontend js scripts to avoid conflicts

// custom rewrite rules to add to existing post types and taxonomies
function agp_custom_rewrite_rules() {

	// First, try to load up the rewrite rules. We do this just in case
	// the default permalink structure is being used.
	if( ($current_rules = get_option('rewrite_rules')) ) {

		// Next, iterate through each custom rule adding a new rule
		// that replaces 'movies' with 'films' and give it a higher
		// priority than the existing rule.
		foreach($current_rules as $key => $val) {
			if(strpos($key, 'skill') !== false) {
				add_rewrite_rule(str_ireplace('skill', 'serie', $key), $val, 'top');   
			} elseif(strpos($key, 'project') !== false) {
				add_rewrite_rule(str_ireplace('project', 'obra', $key), $val, 'top');   
			} // end if
		} // end foreach

	} // end if/else

	// ...and we flush the rules
	flush_rewrite_rules();

} // end add_custom_rewrite_rule

/**
 * Post navigation within single post views
 *
 * Based on ridge_post_nav function
 *
 * MODIF: Remove next and prev post titles
 *
 * @since 1.0
 */

if ( ! function_exists( 'agp_post_nav' ) ) :
	// Display navigation to next/previous post when applicable.
	function agp_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'ridge' ); ?></h1>
			<div class="nav-links">
				<?php
					next_post_link( '<div class="next-project"> %link</div>', '&#8594;',true,'','skill' );
					previous_post_link( '<div class="prev-project">%link</div>', '&#8592;',true,'','skill' );
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;


//////
// RIDGE FUNCTIONS REDEFINITION
//////
 
/**
 * Post meta data
 *
 * Create and print a string for the meta data, Posted by XX on XX in XX.
 *
 * MODIF: Remove author from output
 *
 * @since 1.0
 */

	function ridge_post_meta() {

		$categories  = get_the_category();
		$separator   = ' ';
		$output      = '';

		// Get the categories string
		if ( $categories ) {

			foreach ( $categories as $category ) {

				$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'ridge' ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;

			}

			$category_string = 'in ' . trim( $output, $separator );

		} else {

			$category_string = '';

		}

		// Get the time string
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		// Add the modified time, if applicable
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date( 'M j \<\s\u\p\>S\<\/\s\u\p\> Y' ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$output = sprintf( __( 'On %1$s %2$s<br /> ', 'ridge' ),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			),
			sprintf( '%s', $category_string )
		);

		echo $output;

	} // ridge_post_meta

/**
 * Builds and prints the skill filter nav, hiding any skills without associated projects
 *
 * MODIF: if only one skill, then doesn't print anything
 *
 * @param str $post_type    Optional. Accepts project or post for use in the portfolio
 *   and blog.
 * @since 1.0
 */
	function ridge_filter_nav( $post_type = 'project', $skill_filter = null ) {

		if( 'project' == $post_type )
			$tax = 'skill';
		else
			$tax = 'category';

		$args = array(
			'taxonomy'   => $tax,
			'orderby'    => 'slug',
			'hide_empty' => 1
		);

		/** @var string $filter Comma-separated list of IDs for skill(s) when using filtered portfolio pages */
		$filter = ridge_filtered_portfolio();

		if( $filter ){

			$filter = implode( ',', $filter);

			$args = array(
				'taxonomy'   => $tax,
				'orderby'    => 'slug',
				'include'    => $filter
			);

		}

		$categories = get_categories( $args );

		//Display FilterNav only if there is more than one skill

		if( sizeof( $categories ) > 1 ) { ?>
			<ul id="filter-nav" class="clearfix">
				<li class="all-btn"><a href="#" data-filter="*" class="selected"><?php _e( 'All', 'ridge' ); ?></a></li>
				<?php
				foreach( $categories as $pcat ) {

					$output = sprintf( '<li><a href="#" data-filter=".%1$s">%2$s</a></li>%3$s',
							esc_attr( $pcat->slug ),
							ucfirst( esc_attr( $pcat->name ) ),
							"\n"
						);

					echo $output;

				} // foreach

				?>
			</ul>
		<?php
		} // if

	} // ridge_filter_nav


