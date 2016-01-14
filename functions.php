<?php
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
