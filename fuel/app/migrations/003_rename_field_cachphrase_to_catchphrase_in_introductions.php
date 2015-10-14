<?php

namespace Fuel\Migrations;

class Rename_field_cachphrase_to_catchphrase_in_introductions
{
	public function up()
	{
		\DBUtil::modify_fields('introductions', array(
			'cachphrase' => array('name' => 'catchphrase', 'type' => 'varchar', 'constraint' => 255)
		));
	}

	public function down()
	{
	\DBUtil::modify_fields('introductions', array(
			'catchphrase' => array('name' => 'cachphrase', 'type' => 'varchar', 'constraint' => 255)
		));
	}
}