<?php
	abstract class TrackStarActiveRecord extends CActiveRecord
	{
		protected function beforeSave()
		{
			if (null !== Yii::app()->user)
			{
				$id = Yii::app()->user->id;
			} 
			else 
			{
				$id = 1;
			}
			
			if ($this->isNewRecord) 
			{
				$this->create_user_id = $id;
			}
			
			$this->update_user_id = $id;
			
			return parent::beforeSave();
		}
		
		public function behaviors() 
		{
			return array(
				'CTimestampBehavior' => array(
					'class' => 'zii.behaviors.CTimestampBehavior',
					'createAttribute' => 'create_time',
					'updateAttribute' => 'update_time',
					'setUpdateOnCreate' => true,
				),
			);
		}
	}
?>