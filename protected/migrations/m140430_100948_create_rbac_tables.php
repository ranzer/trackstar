<?php

class m140430_100948_create_rbac_tables extends CDbMigration
{
	public function up()
	{
		$this->createTable('tbl_auth_item', array(
			'name' => 'varchar(64) not null',
			'type' => 'integer not null',
			'description' => 'text',
			'bizrule' => 'text',
			'data' => 'text',
			'primary key (`name`)',
		), 'engine=innodb');
		
		$this->createTable('tbl_auth_item_child', array(
			'parent' => 'varchar(64) not null',
			'child' => 'varchar(64) not null',
			'primary key (`parent`, `child`)',
		), 'engine=innodb');
		
		$this->addForeignKey('fk_auth_item_child_parent', 'tbl_auth_item_child', 
			'parent', 'tbl_auth_item', 'name', 'cascade', 'cascade');
		$this->addForeignKey('fk_auth_item_child_child', 'tbl_auth_item_child', 'child',
			'tbl_auth_item', 'name', 'cascade', 'cascade');
			
		$this->createTable('tbl_auth_assignment', array(
			'itemname' => 'varchar(64) not null',
			'userid' => 'int(11) not null',
			'bizrule' => 'text',
			'data' => 'text',
			'primary key (`itemname`, `userid`)',
		), 'engine=innodb');
		
		$this->addForeignKey(
			'fk_auth_assignment_itemname',
			'tbl_auth_assignment',
			'itemname',
			'tbl_auth_item',
			'name',
			'cascade',
			'cascade'
		);
		
		$this->addForeignKey(
			'fk_auth_assignment_userid',
			'tbl_auth_assignment',
			'userid',
			'tbl_user',
			'id',
			'cascade',
			'cascade'
		);
	}

	public function down()
	{
		$this->truncateTable('tbl_auth_assignment');
		$this->truncateTable('tbl_auth_item_child');
		$this->truncateTable('tbl_auth_item');
		$this->dropTable('tbl_auth_assignment');
		$this->dropTable('tbl_auth_item_child');
		$this->dropTable('tbl_auth_item');
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