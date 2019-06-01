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
				'description' => __('A Widget for displaying the current weather for a loction', 'customize_posts'),
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
        $weather = owm_get_current_weather($city, $country);
		$temperature = (int)$weather['temperature'];
		
		?>
			<div class="current-weather">
				<!-- js content -->
			</div>
			<script>
				jQuery(document).ready(function(){
					cp_get_current_weather(
						'<?php echo $widget_id; ?>',
						'<?php echo $city; ?>',
						'<?php echo $country; ?>'
					);
				});
			</script>
		<?php

        /*foreach ($weather['conditions'] as $condition) :
            ?>
                <div class="weather-widget">
                    <?php _e("Weather in <strong>{$city}</strong>, <strong>{$country}</strong>", 'customize_posts'); ?>
                    <br>
                    <br>
                    <?php _e('<strong>Weather: </strong>' . ucfirst($condition->description), 'customize_posts'); ?>
                    <br>
                    <?php _e("<strong>Temperature: </strong>{$temperature}C", 'customize_posts'); ?>
                    <br>
                    <?php _e("<strong>Humidity: </strong>{$weather['humidity']}%", 'customize_posts'); ?>
                    <br>
                    
                    <div class="weather-widget weather-widget-conditions">
                        <img
                            src="<?php echo 'http://openweathermap.org/img/w/' . $condition->icon . '.png' ?>"
                            title="<?php _e($condition->description, 'customize_posts'); ?>"
                            alt="<?php _e($condition->main, 'customize_posts'); ?>"
                        > <!-- img -->
                    </div> <!-- weather-widget-conditions -->
                </div> <!-- weeather-widget -->
            <?php
        endforeach;*/

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
			$title = __('Current Weather', 'customize_posts');
        }
        
        $city = isset($instance['city'])
            ? $instance['city']
            : 'Lund';

        $country = isset($instance['country'])
            ? $instance['country']
            : 'SE';


		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:', 'customize_posts'); ?>
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
				<?php _e('City:', 'customize_posts'); ?>
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
				<?php _e('Country:', 'customize_posts'); ?>
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