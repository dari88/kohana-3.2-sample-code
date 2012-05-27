<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Test12_register extends Model {

    public function register($array) {
        $id = DB::insert(array_keys($array))
                ->values($array)
                ->table('wp332_users')
                ->execute();

        return $id;
    }

    public function unique_username($user_login) {

        $users = DB::SELECT('user_login')
                ->from('wp332_users')
                ->where('user_login', '=', $user_login)
                ->execute();

        $result = $users->get('user_login', FALSE);
        if ($result)
            return FALSE;
        return TRUE;
    }

    public function unique_email($user_email) {

        $emails = DB::SELECT('user_email')
                ->from('wp332_users')
                ->where('user_email', '=', $user_email)
                ->execute();

        $result = $emails->get('user_email', FALSE);
        if ($result)
            return FALSE;
        return TRUE;
    }

}

?>
