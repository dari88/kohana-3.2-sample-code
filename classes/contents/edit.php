<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Contents_Edit {

    static function posts($page, $author, $option = NULL) {

        $model = Model::factory('test12_posts');
        if ($author) {
            $array = array('post_author' => $author);
        } else {
            $array = array();
        }

        switch ($option) {
            case 'all':
                $op = 'option=all&';
                break;
            case 'draft':
                $array['post_status'] = 'draft';
                $op = 'option=draft&';
                break;
            case 'trash':
                $array['post_status'] = 'trash';
                $op = 'option=trash&';
                break;
            default:
                $array['post_status'] = 'publish';
                $op = '';
                break;
        }

        $select = $model->selectblogs($array);
        $paginator = Zend_Paginator::factory($select);

        if (!$page) {
            $page = 1;
        }

        $pagecount = $paginator->count();
        $page = ($page > $pagecount) ? $pagecount : $page;
        $paginator->setCurrentPageNumber($page);

        $url = '?' . $op . 'page=';
        $pagination = Contents_Pagenation::setup($pagecount, $page, $url, 'pagination/floating');

        $view = View::factory('test12/edit/posts');
        $view->data = $paginator;
        $view->option = $option;
        $view->single = FALSE;
        $view->page = $page;
        $view->pagination = $pagination;

        return $view->render();
    }

}

?>
