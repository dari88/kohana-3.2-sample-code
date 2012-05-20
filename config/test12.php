<?php defined('SYSPATH') or die('No direct access allowed.');

$body1 = <<< EOT
WordPress風kohanaサイトへようこそ！
ユーザー登録を致しましたのでパスワードをお届けします。
EOT;

$body2 = <<< EOT
WordPress風kohanaサイトをよろしくお願いします。

                                     ウエッブマスター　kohana太郎
                                     
EOT;

return array
(
	'mail_register' => array
	(
		'from'       => 'kohana_master@gmail.com',
		'subject' => '[kohana] あなたのユーザー名とパスワード',
		'body1'      => $body1,
		'body2'      => $body2,
	),

);