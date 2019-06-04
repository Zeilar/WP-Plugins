<?php

/**
 * Adds WeatherWidget widget.
 */

class WeatherWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	public function __construct() {
		parent::__construct(
			'weather-widget', // Base ID
			'Weather', // Name
			[
				'description' => __('A Widget for displaying the current weather for a loction', 'cool_plugin'),
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
        
        $city = $instance['city'];
        $country = $instance['country'];

		// start widget
		echo $before_widget;

		// title
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

        // content
		?>
			<div class="current-weather" data-city="<?php echo $city; ?>" data-country="<?php echo $country; ?>">
				<em><small>Loading...</small></em>
			</div>
		<?php

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
			$title = __('Current Weather', 'cool_plugin');
        }
        
        $city = isset($instance['city'])
            ? $instance['city']
            : 'Kristianstad';

        $country = isset($instance['country'])
            ? $instance['country']
            : 'SE';


		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:', 'cool_plugin'); ?>
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

        <!-- city -->
        <p>
			<label
				for="<?php echo $this->get_field_name('city'); ?>"
			>
				<?php _e('City:', 'cool_plugin'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('city'); ?>"
				name="<?php echo $this->get_field_name('city'); ?>"
				type="text"
				value="<?php echo esc_attr($city); ?>"
			/>
		</p>
        <!-- city -->

        <!-- country -->
        <p>
			<label
				for="<?php echo $this->get_field_name('country'); ?>"
			>
				<?php _e('Country:', 'cool_plugin'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('country'); ?>"
				name="<?php echo $this->get_field_name('country'); ?>"
				type="text"
				value="<?php echo esc_attr($country); ?>"
			/>
		</p>
        <!-- country -->

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
            
        $instance['country'] = (!empty($new_instance['country']))
			? strip_tags($new_instance['country'])
            : '';
            
        $instance['city'] = (!empty($new_instance['city']))
			? strip_tags($new_instance['city'])
			: '';

		return $instance;
	}

} // class WeatherWidget