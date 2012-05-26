<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_mediaview extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        if (!$loginuser)
            die();
        $user_ID = Auth_Wplogin::instance()->user_ID($loginuser);
        $id = $_GET['id'];
        $type = $_GET['type'];
        isset($_GET['html']) ? $html = 1 : $html = NULL;

        $model = Model::factory('test12_posts');
        $img = $model->getimage($id, $type . '_img');
        $ext = $model->getimage($id, 'extention');
        $org_name = $model->getimage($id, 'org_name');

        $content_type = array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        );

        if ($html) {
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /></head>";
            echo "<body><image src='test12_mediaview?id={$id}&type={$type}' /><br />{$org_name}</body></html>";
        } else {
            header('Content-type: ' . $content_type[$ext]);
            print $img;
        }
    }

}

?>
