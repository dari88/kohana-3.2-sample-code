<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_mediaupload extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        if (!$loginuser)
            $this->request->redirect('test12');

        $view = view::factory('test12/postnew/uploadify');
        $view->folder = $loginuser;
        $this->response->body($view);
    }

}

?>
