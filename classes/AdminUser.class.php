<?php

class AdminUser
{
	protected $admin_id;
	protected $fields;

	public function __construct($id = '')
	{
		$this->admin_id = $id;

		$this->loadUser();
	}

	public function __destruct()
	{

	}

	public function validateLogin($login_id,$password)
	{
		global $db;

		$sql = "select admin_id from admin_user where login_id = ? and password = ?";
		$params = array($login_id,hash('sha512',$password));
		echo($db->getOne($sql,null,$params));
		return $db->getOne($sql,null,$params);
	}

	public function setValues($values)
	{
		$this->fields['login_id'] = $values['login_id'];
		$this->fields['email'] = $values['email'];
		$this->fields['password'] = $values['password'];
		$this->fields['conf_password'] = $values['conf_password'];
		$this->fields['status_id'] = $values['status_id'];

		$errors = $this->validateUser();

		return $errors;
	}

	protected function validateUser()
	{
		$errors = array();

		if($this->fields['login_id'] == '')
		{
			$errors[] = 'Login ID is required';
		}
		if($this->fields['email'] == '')
		{
			$errors[] = 'Email is required';
		}
		if($this->fields['password'] == '')
		{
			$errors[] = 'Password is required';
		}
		if($this->fields['conf_password'] == '')
		{
			$errors[] = 'Confirm Password is required';
		}
		if($this->fields['status_id'] == '')
		{
			$errors[] = 'Status is required';
		}
		if(strlen($this->fields['login_id']) > 25)
		{
			$errors[] = 'Login ID Cannot be longer than 25 characters';
		}
		if(strlen($this->fields['email']) > 100)
		{
			$errors[] = 'Email Cannot be longer than 100 characters';
		}
		if(!in_array($this->fields['status_id'],array_flip($this->fields['statuses'])))
		{
			$errors[] = 'Status is not a valid selection';
		}
		if($this->fields['password'] != $this->fields['conf_password'])
		{
			$errors[] = 'Passwords do not match.';
		}

		return $errors;
	}

	private function loadUser()
	{
		global $db;
		//if($this->admin_id)
		//{
			$sql = "select
					admin_id,
					login_id,
					email,
					status_id
					from
					admin_user
					where admin_id = ?";
			$params = array($this->admin_id);

			$this->fields =  $db->getRow($sql,null,$params);

			$sql = "select
					status_id,
					status_name
					from
					status ";
			$params = array();
			$this->fields['statuses'] =  $db->getAssoc($sql,null,$params);
		//}
	}

	public function getUsers()
	{
		global $db;

		$sql = "select
				a.admin_id,
				a.login_id,
				a.email,
				a.status_id,
				s.status_name
				from
				admin_user a, status s
				where
				a.status_id = s.status_id
				and a.deleted = 0";
		$params = array();

		return $db->getAll($sql,null,$params);
	}

	public function deleteUser()
	{
		global $db;
	}

	public function save()
	{
		if($this->admin_id)
		{
			$this->update();
		}
		else
		{
			$this->insert();
		}
	}

	private function insert()
	{
		global $db;

		$sql = "insert into admin_user (login_id, email, password, status_id, deleted)
				values (?,?,?,?,0)";
		$params = array($this->fields['login_id'],$this->fields['email'],hash('sha512',$this->fields['password']),$this->fields['status_id']);

		$query = $db->prepare($sql);
		$query->execute($params);
		$query->free();
		$db->commit();
	}

	private function update()
	{
		global $db;

		$sql = "update admin_user set
				login_id = ?,
				email = ?,
				password = ?,
				status_id = ?
				where admin_id = ?";
		$params = array($this->fields['login_id'],$this->fields['email'],hash('sha512',$this->fields['password']),$this->fields['status_id'],$this->admin_id);

		$query = $db->prepare($sql);
		$query->execute($params);
		$query->free();
		$db->commit();
	}

	public function __get($var)
	{
		switch ($var)
		{
			case 'admin_id':
			case 'fields':
				return $this->$var;
		}
	}
}
?>