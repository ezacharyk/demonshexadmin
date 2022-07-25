<?php

class Player
{
	private $user_id;
	
	public function __construct($id = '')
	{
		$this->user_id = $id;

		//$this->loadUser();
	}
	
	public function __destruct()
	{
		
	}
	
	public function validateLogin($login_id,$password)
	{
		global $db;
		
		$sql = "select player_id from player where user_name = ? and password = ?";
		$params = array($login_id,hash('sha512',$password));
		
		return $db->getOne($sql,null,$params);
	}
	
	public function setValues($values)
	{
		$this->fields['user_name'] = $values['user_name'];
		$this->fields['email'] = $values['email'];
		$this->fields['password'] = $values['password'];
		$this->fields['conf_password'] = $values['conf_password'];

		$errors = $this->validateUser();

		return $errors;
	}

	protected function validateUser()
	{
		$errors = array();

		if($this->fields['user_name'] == '')
		{
			$errors[] = 'User Name is required';
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
		if(strlen($this->fields['login_id']) > 25)
		{
			$errors[] = 'Login ID Cannot be longer than 25 characters';
		}
		if(strlen($this->fields['email']) > 100)
		{
			$errors[] = 'Email Cannot be longer than 100 characters';
		}
		if($this->fields['password'] != $this->fields['conf_password'])
		{
			$errors[] = 'Passwords do not match.';
		}

		return $errors;
	}
	
	public function  getTokens()
	{
		global $db;

		$sql = "select
					t.token_id, 
					t.name,  
					t.image,
					t.attack,
					t.defense,
					t.cost,
					t.element_id,
					e.name as 'element_name',
					d.top_right,d.d_right,d.bottom_right,d.bottom_left,d.d_left,d.top_left,
					concat(d.top_right,',',d.d_right,',',d.bottom_right,',',d.bottom_left,',',d.d_left,',',d.top_left) as 'directions',
					t.rarity_id,
					r.name as 'rarity_name',
					t.class_id,
					c.name as 'class_name'
				from 
					token t, element e, direction d, rarity r, token_class c 
				where
					t.element_id = e.element_id
					and t.direction_id = d.direction_id
					and t.rarity_id = r.rarity_id
					and t.class_id = c.class_id
					and t.deleted = 0
					order by t.rarity_id, t.name";
		$params = array();

		return  $db->getAll($sql,null,$params);
	}
}

?>