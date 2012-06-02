<?php defined('SYSPATH') or die('No direct script access.');

class Contents_Pagenation {

    static function setup($total_pages, $current_page, $url, $view = 'pagination/basic') {

        $previous_page = ($current_page > 1) ? $current_page - 1 : FALSE;
        $next_page = ($current_page < $total_pages) ? $current_page + 1 : FALSE;
        $first_page = ($current_page == 1) ? FALSE : 1;
        $last_page = ($current_page >= $total_pages) ? FALSE : $total_pages;

        $view = View::factory($view);
        $view->url = $url;
        $view->total_pages = $total_pages;
        $view->current_page = $current_page;
        $view->previous_page = $previous_page;
        $view->next_page = $next_page;
        $view->first_page = $first_page;
        $view->last_page = $last_page;

        return $view->render();
    }

}

?>
