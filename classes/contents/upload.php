<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Contents_Upload {

    static function images($page, $author) {

        $model = Model::factory('test12_posts');
        if ($author) {
            $array = array('post_author' => $author);
        } else {
            $array = NULL;
        }

        $select = $model->selectimage($array);
        $paginator = Zend_Paginator::factory($select);

        if (!$page) {
            $page = 1;
        }

        $pagecount = $paginator->count();
        $page = ($page > $pagecount) ? $pagecount : $page;
        $paginator->setCurrentPageNumber($page);

        $url = '/kohana/test12_upload?page=';
        $pagination = Contents_Pagenation::setup($pagecount, $page, $url, 'pagination/floating');

        $view = View::factory('test12/upload/media');
        $view->data = $paginator;
        $view->single = FALSE;
        $view->page = $page;
        $view->pagination = $pagination;

        return $view->render();
    }

}

?>
