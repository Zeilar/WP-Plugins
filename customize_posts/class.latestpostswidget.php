<?php

/**
 * Adds Latest Posts widget.
 */

class LatestPostsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'latest_posts_widget', // Base ID
			'Latest Posts Widget', // Name
			[
				'description' => __('Showing latest posts', 'cp_posts'),
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
        if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		else {
			$title = __('New title', 'cp_posts');
		}
		$amount = isset($instance['amount'])
			? (int)$instance['amount']
            : 3;

        $author = isset($instance['author'])
			? $instance['author']
            : 3;

        if(is_single()) {

		    echo $before_widget;

            if (!empty($title)) {
                echo $before_title . $title . $after_title;
            }
            
            echo $after_widget;
        }        
        $current_post_id = get_the_ID();
    	$category_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

		$posts = new WP_Query([
			'posts_per_page' => $amount,
			'post__not_in' => [$current_post_id],
			'category__in' => $category_ids,
		]);
		
        if ($posts->have_posts()) {
            
            //$today = new DateTime($today);
            $output .= "<ul>";

            while ($posts->have_posts()) {

                $posts->the_post();
                $output .= "<li>";
                $output .= "<a href='" . get_the_permalink() . "'>" . get_the_title() . "</a>";

                if ($author) {
                    $output .=  ' by <a href="' . get_the_author_link() . '">' . get_the_author() . '</a>';
                }

                $output .= ' in ' . get_the_category_list(', ') . "<br>";
				$post_date = new DateTime(get_the_date());
				
				/* 
				Get absolute time difference

				$age = date_diff($today, $post_date);
                $years = $age->y . ' years ';
                $months = $age->m . ' months ';
                $days = $age->d . ' days ';
				$age = $years . $months . $days;
				*/

                $output .= 'Posted ' . human_time_diff(get_the_time('U')) . ' ago'; 
                $output .= "</li>";
            }
            wp_reset_postdata();
            $output .= "</ul>";

        } else {
            $output .= "No posts were found :(";
        }

        if(is_single()) {
            echo $output;
        }
	} // function widget

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
		}
		else {
			$title = __('New title', 'cp_posts');
        }
        $amount = isset($instance['amount'])
			? (int)$instance['amount']
            : '';

        $author = isset($instance['author'])
			? $instance['author']
            : false;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title'); ?></label>
			<input 
                class="widefat" 
				id="<?php echo $this->get_field_id('title'); ?>" 
				name="<?php echo $this->get_field_name('title'); ?>" 
				type="text" 
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
        <p>
			<label for="<?php echo $this->get_field_name('amount'); ?>"><?php _e('Post Amount'); ?></label>
			<input 
                class="widefat" 
				id="<?php echo $this->get_field_id('amount'); ?>" 
				name="<?php echo $this->get_field_name('amount'); ?>" 
				type="number"
				min ="1"
                max="10" 
				value="<?php echo esc_attr($amount); ?>"
			/>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('author'); ?>">Author?</label>
            <input 
                class="checkbox" 
                type="checkbox" <?php checked($instance['author'], true); ?> 
                id="<?php echo $this->get_field_id('author'); ?>" 
                name="<?php echo $this->get_field_name('author'); ?>" 
            /> 
        </p>
	<?php
} // function form

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
			? strip_tags($new_instance['title']) // strip_tags removes HTML tags
            : '';
            
        $instance['amount'] = !empty($new_instance['amount'])
			? $new_instance['amount']
            : '';

        $instance['author'] = !empty($new_instance['author']);
        
		return $instance;
	}
} // class LatestPostsWidget