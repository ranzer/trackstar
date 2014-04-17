<?php

class m140417_093149_create_project_table extends CDbMigration
{
	public function up()
	{
		$this->createTable("tbl_project", array(
			"id" => "pk",
			"name" => "string not null",
			"description" => "text not null",
			"create_time" => "datetime default null",
			"create_user_id" => "int(11) default null",
			"update_time" => "datetime default null",
			"update_user_id" => "int(11) default null",
		), "engine=innodb");
	}

	public function down()
	{
		$this->dropTable("tbl_project");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}