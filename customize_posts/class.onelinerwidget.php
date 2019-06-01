<?php

/**
 * Adds OneLiner widget.
 */

class OneLinerWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	public function __construct() {
		parent::__construct(
			'oneliner-widget', // Base ID
			'OneLiner', // Name
			[
				'description' => __('A widget that displays funny one liners', 'customize_posts'),
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

		// start widget
		echo $before_widget;

        // content
		?>
			<div class="content">
                Loading...
			</div>

			<script>
				jQuery(document).ready(function(){
					//var oneliner = cp_get_oneliner();
				});
			</script>
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
        // form settings would go here
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
        // stuff that needs updating in the databse would go here
	}

} // class WeatherWidget