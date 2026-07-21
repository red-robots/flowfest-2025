<?php
/**
 * Schedule helper functions.
 *
 * @package bellaworks
 */

/**
 * Time-of-day group definitions for the schedule.
 *
 * @return array<string, array{label: string, start: int, end: int|null}>
 */
function flowfest_get_schedule_time_groups() {
	return array(
		'morning'          => array(
			'label' => 'Morning',
			'start' => null,
			'end'   => 580,
		),
		'mid-morning'      => array(
			'label' => 'Mid-morning',
			'start' => 580,
			'end'   => 705,
		),
		'early-afternoon'  => array(
			'label' => 'Early afternoon',
			'start' => 720,
			'end'   => 825,
		),
		'late-afternoon'   => array(
			'label' => 'Late afternoon',
			'start' => 840,
			'end'   => 945,
		),
		'evening'          => array(
			'label' => 'Evening',
			'start' => 960,
			'end'   => null,
		),
	);
}

/**
 * Convert a date_and_time value to minutes since midnight.
 *
 * @param string $date_time ACF datetime value (Y-m-d H:i:s).
 * @return int|null Minutes since midnight, or null when invalid.
 */
function flowfest_get_minutes_from_datetime( $date_time ) {
	if ( empty( $date_time ) ) {
		return null;
	}

	$date = DateTime::createFromFormat( 'Y-m-d H:i:s', $date_time );

	if ( ! $date ) {
		return null;
	}

	return ( (int) $date->format( 'H' ) * 60 ) + (int) $date->format( 'i' );
}

/**
 * Determine which schedule time group a datetime belongs to.
 *
 * @param string $date_time ACF datetime value (Y-m-d H:i:s).
 * @return string|null Group slug or null when no group matches.
 */
function flowfest_get_schedule_time_group_slug( $date_time ) {
	$minutes = flowfest_get_minutes_from_datetime( $date_time );

	if ( null === $minutes ) {
		return null;
	}

	foreach ( flowfest_get_schedule_time_groups() as $slug => $group ) {
		$after_start = null === $group['start'] || $minutes >= $group['start'];
		$before_end  = null === $group['end'] || $minutes <= $group['end'];

		if ( $after_start && $before_end ) {
			return $slug;
		}
	}

	return null;
}

/**
 * Format a date_and_time value as a display time.
 *
 * @param string $date_time ACF datetime value (Y-m-d H:i:s).
 * @return string
 */
function flowfest_format_event_time( $date_time ) {
	$date = DateTime::createFromFormat( 'Y-m-d H:i:s', $date_time );

	if ( ! $date ) {
		return '';
	}

	return $date->format( 'g:i a' );
}

/**
 * Get published events for a day grouped by time-of-day.
 *
 * @param string       $day        Event day: 'saturday' or 'sunday'.
 * @param string|array $post_types Post type slug or array of slugs.
 * @return array{
 *     date: string|null,
 *     groups: array<string, array{
 *         label: string,
 *         events: array<int, array{
 *             post_id: int,
 *             post_type: string,
 *             title: string,
 *             date_and_time: string,
 *             time: string
 *         }>
 *     }>
 * }
 */
function flowfest_get_events_grouped_by_time( $day, $post_types ) {
	$groups = array();

	foreach ( flowfest_get_schedule_time_groups() as $slug => $group ) {
		$groups[ $slug ] = array(
			'label'  => $group['label'],
			'events' => array(),
		);
	}

	$earliest_date = flowfest_get_earliest_event_date_by_day( $day, $post_types );
	$events_query  = get_event_details_by_event_day( $day, $post_types );

	if ( $events_query->have_posts() ) {
		while ( $events_query->have_posts() ) {
			$events_query->the_post();

			$post_id   = get_the_ID();
			$date_time = get_field( 'date_and_time', $post_id );
			$group_slug = flowfest_get_schedule_time_group_slug( $date_time );

			if ( ! $group_slug || ! isset( $groups[ $group_slug ] ) ) {
				continue;
			}

			$groups[ $group_slug ]['events'][] = array(
				'post_id'       => $post_id,
				'post_type'     => get_post_type( $post_id ),
				'title'         => get_the_title(),
				'date_and_time' => $date_time,
				'time'          => flowfest_format_event_time( $date_time ),
			);
		}

		wp_reset_postdata();
	}

	return array(
		'date'   => $earliest_date,
		'groups' => $groups,
	);
}
