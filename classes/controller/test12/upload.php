<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_upload extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        if (!$loginuser)
            $this->request->redirect('test12');
        isset($_GET['page']) ? $page = $_GET['page'] : $page = NULL;
        isset($_GET['p']) ? $p = $_GET['p'] : $p = NULL;

        $user_ID = Auth_Wplogin::instance()->user_ID($loginuser);

        $view = view::factory('test12/upload/upload');
        $view->head02 = view::factory('test12/postnew/head02');
        $view->adminmenu = view::factory('test12/postnew/adminmenu');
        $view->help = view::factory('test12/postnew/help');
        $view->screen_option = view::factory('test12/postnew/screen_option');
        if($p=='upload'){
            $view->media = view::factory('test12/postnew/uploadify');
            $view->media->folder = $loginuser;
        }else{
            $view->media = Contents_Upload::images($page, $user_ID);
        }
        $view->wpadminbar = view::factory('test12/postnew/wpadminbar');
        $view->wpadminbar->loginuser = $loginuser;

        $this->response->body($view);
    }

}

?>
