class RbacCommand extends CConsoleCommand 
{
	private $_authManager;
	
	public function getHelp()
	{
		$description = "DESCRIPTION\n";
		$description .= '     '."This command generates an initial RBAC authorization hierarchy.\n";
		
		return parent::getHelp() . $description;
	}
	
	public function actionIndex() 
	{
		$this->ensureAuthManagerDefined();
		
		//provide the oportunity for the use to abort the request
		$message = "This command will create three roles: Owner, Member, and Reader\n";
		$message .= " and the following permissions:\n";
		$message .= "create, read, update and delete user\n";
		$message .= "create, read, update and delete project\n";
		$message .= "create, read, update and delete issue\n";
		$message .= "Would you like to continue?";
		
		if ($this->confirm($message))
		{
			$this->_authManager->clearAll();
			
			$this->_authManager->createOperation(
				'createUser',
				'Create a new user');
			$this->_authManager->createOperation(
				'readUser',
				'Read user profile information');
			$this->_authManager->createOperation(
				'updateUser',
				'Update a users in-formation');
			$this->_authManager->createOperation(
				'deleteUser',
				'Remove a user from a project');
			$this->_authManager->createOperation(
				'createProject',
				'Create a new project');
			$this->_authManager->createOperation(
				'readIssue',
				'Read issue information');
			$this->_authManager->createOperation(
				'updateIssue',
				'Update issue information');
			$this->_authManager->createOperation(
				'deleteIssue',
				'Delete an issue from a project');
			
			$role = $this->_authManager->createRole('reader');
			$role->addChild('readUser');
			$role->addChild('readProject');
			$role->addChild('readIssue');
			
			$role = $this->_authManager->createRole('member');
			$role->addChild('reader');
			$role->addChild('createIssue');
			$role->addChild('updateIssue');
			$role->addChild('deleteIssue');
			
			$role = $this->_authManager->createRole('owner');
			$role->addChild('reader');
			$role->addChild('member');
			$role->addChild('createUser');
			$role->addChild('updateUser');
			$role->addChild('deleteUser');
			$role->addChild('createProject');
			$role->addChild('updateProject');
			$role->addChild('deleteProject');
			
			echo "Authorization hierarchy successfully generated.\n";
		}
		else
		{
			echo "Operation cancelled.\n";
		}
	}
	
	public function actionDelete()
	{
		$this->ensureAuthManagerDefined();
		
		$message = "This command will clear all RBAC definitions.\n";
		$message .= "Would you like to continue?";
		
		if ($this->confirm($message))
		{
			$this->_authManager->clearAll();
			
			echo "Authorization hierarchy removed.\n";
		}
		else
		{
			echo "Delete operation cancelled.\n";
		}
	}
	
	protected function ensureAuthManagerDefined()
	{
		if (($this->_authManager = Yii::app()->authManager) === null)
		{
			 $message = "Error: an authorization manager, named 'authManager' must be con-figured to use this command.";
				$this->usageError($message);
		}
	}
}