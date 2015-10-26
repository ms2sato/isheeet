<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'email',
		'password',
		'name',
		'profile',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'users';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);

		if($factory == 'create'){
			$val->add_field('name', '名前', 'required|max_length[255]');
			$val->add_field('profile', 'プロフィール', 'required');
			$val->add_field('password', 'パスワード', 'required|max_length[20]|min_length[8]');
		} else {
			$val->add_field('password', 'パスワード', 'required|max_length[20]');
		}

		$val->add_field('email', 'E-mail', 'required|max_length[255]');
		return $val;
	}
}
