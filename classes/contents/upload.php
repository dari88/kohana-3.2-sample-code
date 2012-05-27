<?php defined('SYSPATH') OR die('No direct access allowed.');

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

        $paginator->setCurrentPageNumber($page);
        $pagecount = $paginator->count();

        $op = '';
        if ($author) {
            $op = '';
        }
        $hp = 'test12_upload';
        $firstpage = $hp . '?page=1' . $op;
        $beforepage = $hp . '?page=' . ($page - 1) . $op;
        $nextpage = $hp . '?page=' . ($page + 1) . $op;
        $lastpage = $hp . '?page=' . $pagecount . $op;
        if ($page == 1)
            $beforepage = $hp . '?page=1' . $op;
        if ($page == $pagecount)
            $nextpage = $hp . '?page=' . $pagecount . $op;

        $view = View::factory('test12/upload/media');
        $view->data = $paginator;
        $view->single = FALSE;
        $view->firstpage = $firstpage;
        $view->beforepage = $beforepage;
        $view->nextpage = $nextpage;
        $view->lastpage = $lastpage;

        return $view->render();
    }

}

?>
