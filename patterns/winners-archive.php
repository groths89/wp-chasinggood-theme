<?php

/**
 * Title: Winners Archive
 * Slug: chasing-good/winners-archive
 */

function display_winners_by_year()
{
	$years = array(2024, 2023, 2022); // Replace with your desired years

	echo '<div class="tabs">';
	echo '<ul class="tab-links">';
	foreach ($years as $year) {
		$active_class = ($year == 2024) ? 'active' : ''; // Set active class for the first year
		echo '<li class="tab-link ' . $active_class . '" data-year="' . $year . '">' . $year . '</li>';
	}
	echo '</ul>';
	echo '<div class="tab-content">';

	foreach ($years as $year) {
		$args = array(
			'post_type' => 'winners',
			'meta_key' => 'chasinggood_winner_year',
			'meta_value' => $year
		);
		$query = new WP_Query($args);

		echo '<div id="tab-' . $year . '" class="tab ' . $active_class . '">';
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$winner_image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); // Adjust image size as needed
				$winner_name = get_field('chasinggood_winner_name');
				$winner_year = get_field('chasinggood_winner_year'); // Get the year from the post date
				$winner_place = get_field('chasinggood_winner_place');
				$winner_location = get_field('chasinggood_winner_location');
				$winner_description = get_the_content(); // Get the full post content

				// Your winner display logic here
				echo '<div class="flex-container">';
				echo '<div class="winner-info">';
				echo '<div>';
				echo '<div class="winner-item">';
				if ($winner_image) :
					echo '<img src="' . $winner_image . '" />';
				endif;
				echo '<div class="winner-headline">';
				echo '<h4 class="winner-name">' . $winner_name . '</h4>';
				if ($winner_location) :
					echo '<h5 class="winner-location">' . $winner_location . '</h5>';
				endif;
				echo '<div class="winner-yearplace-container">'; # Class = winner-yearplace-container
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="winner-year">' . $winner_year . '</div>'; # Class = winner-year
				echo '</div>'; # End Div with no Class Name
				echo '</div>'; # End Div with no Class Name
				echo '</div>'; # End Div with no Class Name
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="">'; # Div with no Class Name
				echo '<div class="winner-place">' . $winner_place . '</div>'; # Class = winner-place
				echo '</div>'; # End Div with no Class Name
				echo '</div>'; # End Div with no Class Name
				echo '</div>'; # End Div with no Class Name
				echo '</div>'; # Class = winner-yearplace-container
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="winner-story">';
				echo '<p>' . $winner_description . '</p>';
				echo '</div>';
				echo '</div>';
			}
		} else {
			echo 'No winners for ' . $year;
		}
		echo '</div>';
		wp_reset_postdata();
	}

	echo '</div></div>';
	add_shortcode('winners_by_year', 'display_winners_by_year');
}
?>

<h1>Meet The Winners</h1>
<div>
	<div class="winner-container">
		<?php display_winners_by_year(); ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>