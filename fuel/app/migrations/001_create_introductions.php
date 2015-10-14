<?php

namespace Fuel\Migrations;

class Create_introductions
{
	public function up()
	{
		\DBUtil::create_table('introductions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'introducer_id' => array('constraint' => 11, 'type' => 'int'),
			'cachphrase' => array('constraint' => 255, 'type' => 'varchar'),
			'body' => array('type' => 'text'),
			'image_key' => array('constraint' => 1024, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('introductions');
	}
}