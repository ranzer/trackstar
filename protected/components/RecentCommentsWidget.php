<?php
	class RecentCommentsWidget extends CWidget
	{
		private $_comment;
		public $displayLimit = 5;
		public $projectId = null;
		
		public function init()
		{
			if (null !== $this->projectId)
			{
				$this->_comments => Comment::model()->with(
					array('issue' => array('condition' => 'project_id=' . $this->projectId)))
					->recent($this->displayLimit)->findAll();
			}
			else
			{
				$this->_comments = Comment::model()->recent($this->displayLimit)->findAll();
			}
		}
		
		public function getData()
		{
			return $this->_comments;
		}
		
		public function run()
		{
			$this->render('recentCommentsWidget');
		}
	}
?>