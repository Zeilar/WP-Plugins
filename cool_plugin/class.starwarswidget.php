<?php

/**
 * Adds StarWars widget.
 */

class StarWarsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	public function __construct() {
		parent::__construct(
			'starwars-widget', // Base ID
			'Star Wars', // Name
			[
				'description' => __('A Widget for displaying some StarWars trivia', 'cool_plugin'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */

	public function widget($args, $instance) {
		
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		// start widget
		echo $before_widget;

		// title
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		$films = swapi_get_films();
		//$characters = swapi_get_characters();
		//$vehicles = swapi_get_vehicles();
		
		if ($films) {
			foreach ($films as $film) {
				_e("<strong>Title: </strong>{$film->title}<br>", 'cool_plugin');
				_e("<strong>Release Date: </strong>{$film->release_date}<br><br>", 'cool_plugin');
			}
		} else {
			_e('Oops, something went wrong!<br>', 'cool_plugin');
		}

		if ($characters) {
			foreach ($characters as $character) {
				_e("<strong>Characters: </strong>{$character->name}<br>");
			}
		} else {
			_e('Oops, here was supposed to be characters!<br>', 'cool_plugin');
		}

		?>
			<br>
		<?php

		if ($vehicles) {
			foreach ($vehicles as $vehicle) {
				_e("<strong>Vehicles: </strong>{$vehicle->name}<br>");
			}
		} else {
			_e('Oops, here was supposed to be vehicles!<br>', 'cool_plugin');
		}
	

		// close widget
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	
	public function form($instance) {

		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('StarWars Trivia', 'wcms18-starwars-widget');
		}

		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
		<!-- /title -->
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {

		$instance = [];

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';

		return $instance;
	}

} // class StarWarsWidget