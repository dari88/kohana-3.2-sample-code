<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_edit extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        if (!$loginuser)
            $this->request->redirect('test12');
        $page = isset($_GET['page']) ? $_GET['page'] : NULL;
        $option = isset($_GET['option']) ? $_GET['option'] : NULL;

        $user_ID = Auth_Wplogin::instance()->user_ID($loginuser);

        $action = isset($_GET['action']) ? $_GET['action'] : FALSE;
        if ($action) {
            $model = model::factory('test12_posts');
            switch ($action) :
                case 'trash':
                    foreach ($_GET['post'] as $id) {
                        if ($model->getpost($id, 'post_author') == $user_ID) {
                            $model->editpost($id, array('post_status' => 'trash'));
                        } else {
                            die('Invalid!');
                        }
                    }
                    break;
                case 'delete':
                    foreach ($_GET['post'] as $id) {
                        if ($model->getpost($id, 'post_author') == $user_ID) {
                            $model->deletepost($id);
                        } else {
                            die('Invalid user!!');
                        }
                    }
                    break;
            endswitch;
        }

        $view = view::factory('test12/edit/edit');
        $view->head02 = view::factory('test12/postnew/head02');
        $view->adminmenu = view::factory('test12/postnew/adminmenu');
        $view->adminmenu->menu = 'post';
        $view->help = view::factory('test12/postnew/help');
        $view->screen_option = view::factory('test12/postnew/screen_option');
        $view->posts = Contents_Edit::posts($page, $user_ID ,$option);
        $view->wpadminbar = view::factory('test12/postnew/wpadminbar');
        $view->wpadminbar->loginuser = $loginuser;

        $this->response->body($view);
    }

}

?>
