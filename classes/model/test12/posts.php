<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Model_Test12_posts extends Model {

    public function postnew($array) {

        $date = Date::formatted_time();
        $post = array(
            'ID' => '',
            'post_author' => '0',
            'post_date' => $date,
            'post_date_gmt' => $date,
            'post_content' => 'NOT POSTED!!!',
            'post_title' => 'NOT POSTED!!!',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_password' => '',
            'post_name' => '',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $date,
            'post_modified_gmt' => $date,
            'post_content_filtered' => '',
            'post_parent' => '0',
            'guid' => '',
            'menu_order' => '0',
            'post_type' => 'post',
            'post_mime_type' => '',
            'comment_count' => '0',
        );

        foreach ($array as $key => $value) {
            $post[$key] = $value;
        }

        $id = DB::insert(array_keys($post))
                ->values($post)
                ->table('wp332_posts')
                ->execute();

        return $id;
    }

    public function selectblogs($array) {
        $select = DB::select('*')
                ->order_by('ID', 'DESC')
                ->from('wp332_posts');
        if ($array) {
            $select->where_open();
            foreach ($array as $key => $value) {
                $select->and_where($key, '=', $value);
            }
            $select->where_close();
        }

        return $select->execute();
    }

    public function id2name($id) {
        $select = DB::select('ID', 'user_login')
                ->where('ID', '=', $id)
                ->from('wp332_users')
                ->execute();

        return $select->get('user_login', FALSE);
    }

}

?>
