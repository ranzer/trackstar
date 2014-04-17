<?php
	class DBTest extends CTestCase
	{
		public function testConnection() 
		{
			$this->assertNotNull(Yii::app()->db->connectionString);
		}
	}
?>