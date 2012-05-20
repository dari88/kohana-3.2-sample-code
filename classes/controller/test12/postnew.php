<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_postnew extends Controller {

    public function action_index() {

        $loginuser = Auth_Wplogin::instance()->get_user();
        if (!$loginuser)
            $this->request->redirect('test12');

        $user_ID = Auth_Wplogin::instance()->user_ID($loginuser);

        $model = Model::factory('test12_posts');

        if (isset($_POST['post_title'])) {

            $post = Validation::factory($_POST)
                    ->rule('post_title', 'not_empty', array(':value', 'タイトル'))
                    ->rule('post_title', 'max_length', array(':value', 100))
                    ->rule('content', 'not_empty', array(':value', '記事'))
                    ->rule('content', 'max_length', array(':value', 10000));

            $posts = $post->data();

            if ($post->check()) {

                $post_array = array(
                    'post_author' => $user_ID,
                    'post_title' => $posts['post_title'],
                    'post_content' => $posts['content'],
                );
                
                $model->postnew($post_array);

                $this->request->redirect('test12');
            }

            $errors = $post->errors('test12');
            $post_title = HTML::chars($_POST['post_title']);
            $content = $_POST['content'];
        } else {
            $errors = '';
            $post_title = "";
            $content = "";
        }



        $view = view::factory('test12/postnew/postnew');
        $view->errors = $errors;
        $view->head02 = view::factory('test12/postnew/head02');
        $view->adminmenu = view::factory('test12/postnew/adminmenu');
        $view->help = view::factory('test12/postnew/help');
        $view->screen_option = view::factory('test12/postnew/screen_option');
        $view->form_1 = view::factory('test12/postnew/form_1');
        $view->form_1->post_title = $post_title;
        $view->form_1->content = $content;
        $view->form_2 = view::factory('test12/postnew/form_2');
        $view->wpadminbar = view::factory('test12/postnew/wpadminbar');
        $view->wpadminbar->loginuser = $loginuser;
        $view->form_3 = view::factory('test12/postnew/form_3');
        $view->fullscreen = view::factory('test12/postnew/fullscreen');

        $this->response->body($view);
    }

}

?>
