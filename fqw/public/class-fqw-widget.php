<?php
/**
 * Adds WeatherWidget widget.
 */
class FamousQuoteWidget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'famous-quote-widget', // Base ID
			'Famous Quotes', // Name
			[
				'description' => __('A Widget for displaying some famous quotes.', 'fqw'),
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
		$category = $instance['category'];
		
		// start widget
        echo $before_widget;
        
		// title
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
        
        // content
		?>
			<div class="famous-quote" data-category="<?php echo $category; ?>">
				<span class="loading"><?php _e('Loading...', 'fqw'); ?></span>
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
			$title = __('Famous Quotes', 'fqw');
		}
		
		if (isset($instance['category'])) {
			$category = $instance['category'];
		} else {
			$category = __('Select', 'fqw');
		}
		?>

		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">
				<?php _e('Title:', 'fqw'); ?>
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

		<!-- category -->
		<p>
			<label 
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title') ?>"
				value="<?php echo esc_attr($title) ?>"
			>
				<?php _e('Category:', 'fqw'); ?>
			</label>
		
			<select 
				class="widefat" 
				name="<?php echo $this->get_field_name('category'); ?>"
			>
				<option value="<?php echo esc_attr('false'); ?>">
					Select
				</option>
				<option value='Famous'<?php echo ($category == 'Famous') ? 'selected' : ''; ?>>
					Famous
				</option>
				<option value='Movies'<?php echo ($category == 'Movies') ? 'selected' : ''; ?>>
					Movies
				</option>
			</select> 
		</p>
		<!-- /category -->
			
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
			
		$instance['category'] = (!empty($new_instance['category']))
			? strip_tags($new_instance['category'])
			: 'Select';
            
		return $instance;
	}
	
} // class FamousQuoteWidget