<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12 extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        View::bind_global('loginuser', $loginuser);

        isset($_GET['page']) ? $page = $_GET['page'] : $page = NULL;
        isset($_GET['author']) ? $author = $_GET['author'] : $author = NULL;
        isset($_GET['p']) ? $p = $_GET['p'] : $p = NULL;

        $view = view::factory('test12/toppage/test12');
        $view->head01 = view::factory('test12/toppage/head01');
        $view->header01 = view::factory('test12/toppage/header01');
        $view->primary01 = view::factory('test12/toppage/primary01');
        $view->primary01->nav_above = view::factory('test12/toppage/nav_above');
        $view->primary01->article01 = Contents_Toppage::blogs($page, $author, $p);
        $view->primary01->nav_below = view::factory('test12/toppage/nav_below');
        $view->secondary01 = view::factory('test12/toppage/secondary01');
        $view->secondary01->search_2 = view::factory('test12/toppage/search_2');
        $view->secondary01->recent_posts_2 = Contents_Toppage::recentposts2();
        $view->secondary01->recent_comments_2 = view::factory('test12/toppage/recent_comments_2');
        $view->secondary01->archives_2 = view::factory('test12/toppage/archives_2');
        $view->secondary01->categories_2 = view::factory('test12/toppage/categories_2');
        $view->secondary01->meta_2 = view::factory('test12/toppage/meta_2');
        $view->footer01 = view::factory('test12/toppage/footer01');
        $view->adminbar = view::factory('test12/toppage/adminbar');

        $this->response->body($view);
    }

}

?>
