<?php

/**
 * Archives widget class
 */
class chimp_Widget_Archives extends WP_Widget {

    function chimp_Widget_Archives() {
        $widget_ops = array('classname' => 'widget_archive', 'description' =>'A monthly archive Widget');
        $this->WP_Widget('chimp_archives', 'Archives', $widget_ops);
    }

    function widget($args, $instance) {
        global $wpdb, $wp_locale;
        $output = $selectbox = '';

        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? 'Archives' : $instance['title']);
        $count = $instance['count'];
        $dropdown = $instance['dropdown'];

        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        $post_types = array('post', 'albums', 'events');

        // 
        $where = apply_filters('getarchives_where', "WHERE (post_type='post'|| post_type='albums' || post_type='events') AND post_status = 'publish'", '');
        $join = apply_filters('getarchives_join', "", '');
        $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
        $key = md5($query);
        $cache = wp_cache_get('wp_get_archives', 'general');
        if (!isset($cache[$key])) {
            $arcresults = $wpdb->get_results($query);
            $cache[$key] = $arcresults;
            wp_cache_add('wp_get_archives', $cache, 'general');
        } else {
            $arcresults = $cache[$key];
        }
        if ($arcresults) {
            //$afterafter = $after;
            foreach ((array) $arcresults as $arcresult) {
                $url = get_month_link($arcresult->year, $arcresult->month);
                $text = sprintf(__('%1$s %2$d',CSDOMAIN), $wp_locale->get_month($arcresult->month), $arcresult->year);

                if (isset($count) && $count <> '')
                    $text .= '&nbsp;(' . $arcresult->posts . ')';


                $output .= get_archives_link($url, $text, '', '<li>', '</li>');
                if (isset($dropdown) && $dropdown <> '') {
                    $selectbox.='<option value="' . $url . '">' . $text . '</option>';
                }
            }
        }

        if (isset($dropdown) && $dropdown <> '') {
            ?>
            <ul>
            	<li>
                    <select name="archive-dropdown" onchange='document.location.href = this.options[this.selectedIndex].value;'>
                        <option value=""><?php echo _e('Select Month',CSDOMAIN); ?></option>
                        <?php echo $selectbox; ?>
                    </select>
                 </li>
            </ul>
            <?php
        } else {
            echo '<ul>' . $output . '</ul>';
        }
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>">Show post counts</label>
            <br />
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>">Display as a drop down</label>
        </p>
        <?php
    }

}

function chimp_widget_init() {
    // unregister some default widgets
    unregister_widget('WP_Widget_Archives');
    // register my own widgets
    register_widget('chimp_Widget_Archives');
}

add_action('widgets_init', 'chimp_widget_init');
?>