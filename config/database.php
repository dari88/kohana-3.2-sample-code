<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'kohana' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'kohana',
			'username'   => 'MySQLのユーザー名',
			'password'   => 'パスワード',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),

);