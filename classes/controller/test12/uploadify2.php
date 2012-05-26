<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Test12_uploadify2 extends Controller {

    public function action_index() {

        if (true) {

            $filename = 'IMG_018200.JPG';
            $fileParts = pathinfo($filename);
            $ext = strtolower($fileParts['extension']);
            $typesArray = array('jpg', 'gif', 'png');

            if (in_array($ext, $typesArray)) {

//                $timestamp = time();
//                $tempFile = $_FILES['Filedata']['tmp_name'];
                $targetPath = 'C:/xampp/htdocs/uploads/';
                $targetPath = str_replace('//', '/', $targetPath);
                $uniq_filename =  'IMG_016623';
                $targetFile = $targetPath . $uniq_filename . '.' . $ext;
                $thumbnail_1 = $targetPath . $uniq_filename . '_320x.' . $ext;
                $thumbnail_2 = $targetPath . $uniq_filename . '_1024x.' . $ext;
                $tempFile = $targetPath.$filename;

                try {
                    $imagick = new Imagick($tempFile);
                    $width = $imagick->getImageWidth();
                    $height = $imagick->getImageHeight();
                    $imagick->writeImage($targetFile);
                    if ($width > 1024 or $height > 1024) {
                        $imagick->thumbnailImage(1024, 1024, TRUE);
                        $imagick->writeImage($thumbnail_2);
                    } else {
                        $imagick->writeImage($thumbnail_2);
                    }
                    $imagick->thumbnailImage(320, 320, TRUE);
                    $imagick->writeImage($thumbnail_1);
                    
                    $blob = $imagick->getimageblob();
                    $blob = mysql_real_escape_string($blob);
                    $imagick->Destroy();
                    
                    $log = $blob . "\n";
                    $logfile = $targetPath . 'blob.txt';
                    file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);

//                    $loginuser = 'admin';
//                    $user_ID = Auth_Wplogin::instance()->user_ID($loginuser);
//                    $tn1_img = file_get_contents($thumbnail_1);
//                    $tn2_img = file_get_contents($thumbnail_2);
//                    $org_img = file_get_contents($targetFile);
//
//                    $post_array = array(
//                        'post_author' => $user_ID,
//                        'extention' => $ext,
//                        'org_name' => $filename,
//                        'uq_name' => $uniq_filename . '.' . $ext,
//                        'tn1_name' => $uniq_filename . '_320x.' . $ext,
//                        'tn2_name' => $uniq_filename . '_1024x.' . $ext,
//                        'tn1_img' => $tn1_img,
//                        'tn2_img' => $tn2_img,
//                        'org_img' => $org_img,
//                    );
//
//                    $model = Model::factory('test12_posts');
//                    $model->postnewimages($post_array);

//                    unlink($thumbnail_1);
//                    unlink($thumbnail_2);
//                    unlink($targetFile);

//                    echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $targetFile);
                    
                } catch (Exception $e) {
                    $log = print_r($e->getMessage(), TRUE) . "\n";
                    $logfile = $targetPath . 'log.txt';
                    file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
                    throw new Exception('File is corrupted!');
                    die('Invalid file type.');
                }
                
            } else {
                echo 'Invalid file type.';
            }
        } else {
            echo 'invalid';
        }
    }

}

?>