<?php

namespace Fuel\Migrations;

class Add_introduced_id_and_image_content_type_to_introductions
{
	public function up()
	{
		\DBUtil::add_fields('introductions', array(
			'introduced_id' => array('constraint' => 11, 'type' => 'int'),
			'image_content_type' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('introductions', array(
			'introduced_id'
,			'image_content_type'

		));
	}
}
