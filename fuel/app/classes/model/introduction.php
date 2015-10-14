<?php
use Orm\Model;

class Model_Introduction extends Model
{
	protected static $_properties = array(
		'id',
		'introducer_id',
		'introduced_id',
		'catchphrase',
		'body',
		'image_key',
		'image_content_type',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('introducer_id', 'Introducer Id', 'required|valid_string[numeric]');
		$val->add_field('catchphrase', 'Catchphrase', 'required|max_length[255]');
		$val->add_field('body', 'Body', 'required');
		$val->add_field('image_key', 'Image Key', 'required|max_length[1024]');

		return $val;
	}

}
