<?php
/**
 * Custom query functions.
 *
 * @package bellaworks
 */

/**
 * Get the earliest calendar date for a given day of week from published events
 * in the current year.
 *
 * @param string       $day        Event day: 'saturday' or 'sunday'.
 * @param string|array $post_types Post type slug or array of slugs.
 * @return string|null Date string (Y-m-d) or null when none found.
 */
function flowfest_get_earliest_event_date_by_day( $day, $post_types ) {
	static $cache = array();

	$day = strtolower( $day );

	if ( is_string( $post_types ) ) {
		$post_types = array( $post_types );
	}

	sort( $post_types );
	$current_year = (int) date( 'Y' );
	$cache_key    = $day . '|' . implode( ',', $post_types ) . '|' . $current_year;

	if ( array_key_exists( $cache_key, $cache ) ) {
		return $cache[ $cache_key ];
	}

	$day_map = array(
		'saturday' => 7,
		'sunday'   => 1,
	);

	if ( ! isset( $day_map[ $day ] ) || empty( $post_types ) ) {
		$cache[ $cache_key ] = null;
		return null;
	}

	global $wpdb;

	$post_types_in = implode( ', ', array_map( function( $type ) {
		return "'" . esc_sql( $type ) . "'";
	}, $post_types ) );

	$earliest = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT MIN( DATE( pm.meta_value ) )
			FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = 'date_and_time'
			AND pm.meta_value != ''
			AND p.post_status = 'publish'
			AND p.post_type IN ( {$post_types_in} )
			AND YEAR( pm.meta_value ) = %d
			AND DAYOFWEEK( pm.meta_value ) = %d",
			$current_year,
			$day_map[ $day ]
		)
	);

	$cache[ $cache_key ] = $earliest ? $earliest : null;

	return $cache[ $cache_key ];
}

/**
 * Get published posts for the earliest Saturday or Sunday event date.
 *
 * @param string       $day        Event day: 'saturday' or 'sunday'.
 * @param string|array $post_types Post type slug or array of slugs. Defaults to 'practices'.
 * @return WP_Query
 */
function get_event_details_by_event_day( $day, $post_types = array( 'practices' ) ) {
	$day = strtolower( $day );

	if ( is_string( $post_types ) ) {
		$post_types = array( $post_types );
	}

	$day_map = array(
		'saturday' => 7,
		'sunday'   => 1,
	);

	if ( ! isset( $day_map[ $day ] ) ) {
		return new WP_Query(
			array(
				'post_type' => $post_types,
				'post__in'  => array( 0 ),
			)
		);
	}

	$earliest_date = flowfest_get_earliest_event_date_by_day( $day, $post_types );

	if ( ! $earliest_date ) {
		return new WP_Query(
			array(
				'post_type' => $post_types,
				'post__in'  => array( 0 ),
			)
		);
	}

	$date_filter = function( $where ) use ( $earliest_date ) {
		global $wpdb;

		$where .= $wpdb->prepare(
			" AND DATE({$wpdb->postmeta}.meta_value) = %s",
			$earliest_date
		);

		return $where;
	};

	add_filter( 'posts_where', $date_filter );

	$query = new WP_Query(
		array(
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'meta_value',
			'meta_key'       => 'date_and_time',
			'meta_type'      => 'DATETIME',
			'order'          => 'ASC',
		)
	);

	remove_filter( 'posts_where', $date_filter );

	return $query;
}
