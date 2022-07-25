<?php
class Token
{
	protected $token_id;
	protected $fields;

	public function __construct($id = '')
	{
		$this->token_id = $id;

		$this->loadToken();
	}

	public function __destruct()
	{

	}

	public function setValues($values)
	{
		$this->fields['name'] = $values['name'];
		$this->fields['attack'] = $values['attack'];
		$this->fields['defense'] = $values['defense'];
		$this->fields['cost'] = $values['cost'];
		$this->fields['element_id'] = $values['element_id'];
		$this->fields['direction_id'] = $values['direction_id'];
		$this->fields['class_id'] = $values['class_id'];
		$this->fields['rarity_id'] = $values['rarity_id'];

		$errors = $this->validateToken();
		
		if(!$this->token_id || $_FILES['image']['name'] != '')
		{
			$file_name = explode('.',$_FILES['image']['name']);
			
			$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/demonshex/images/characters/';
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir,0755,true);
			}
			$uploadfile = $uploaddir . basename($_FILES['image']['name']);
			
			if($file_name[count($file_name)-1] != 'png')
			{
				$errors[] = 'Image is not a png';
			}
			elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) 
			{
				$errors[] = "Image could not be uploaded";
			}
			else 
			{
				$this->fields['image'] = basename($_FILES['image']['name']);
			}
		}

		return $errors;
	}

	protected function validateToken()
	{
		$errors = array();

		if($this->fields['name'] == '')
		{
			$errors[] = 'Name is required';
		}
		if($this->fields['cost'] == '')
		{
			$errors[] = 'Cost is required';
		}
		if($this->fields['attack'] == '')
		{
			$errors[] = 'Attack is required';
		}
		if($this->fields['defense'] == '')
		{
			$errors[] = 'Defense is required';
		}
		if($this->fields['element_id'] == '')
		{
			$errors[] = 'Element is required';
		}
		if($this->fields['rarity_id'] == '')
		{
			$errors[] = 'Rarity is required';
		}
		if($this->fields['direction_id'] == '')
		{
			$errors[] = 'Direction is required';
		}
		if($this->fields['class_id'] == '')
		{
			$errors[] = 'Class is required';
		}
		if(strlen($this->fields['name']) > 50)
		{
			$errors[] = 'Name Cannot be longer than 50 characters';
		}
		if(!is_numeric($this->fields['cost']))
		{
			$errors[] = 'Cost must be numeric.';
		}
		if(!is_numeric($this->fields['attack']))
		{
			$errors[] = 'Attack must be numeric.';
		}
		if(!is_numeric($this->fields['defense']))
		{
			$errors[] = 'Defense must be numeric.';
		}
		if($this->fields['cost'] > 999)
		{
			$errors[] = 'Cost cannot be greater than 999.';
		}
		if($this->fields['attack'] > 9)
		{
			$errors[] = 'Attack cannot be greater than 9.';
		}
		if($this->fields['defense'] > 9)
		{
			$errors[] = 'Defense cannot be greater than 9.';
		}

		if(!in_array($this->fields['element_id'],array_flip($this->fields['elements'])))
		{
			$errors[] = 'Element is not a valid selection';
		}
		if(!in_array($this->fields['direction_id'],array_flip($this->fields['directions'])))
		{
			$errors[] = 'Direction is not a valid selection';
		}
		if(!in_array($this->fields['class_id'],array_flip($this->fields['classes'])))
		{
			$errors[] = 'Class is not a valid selection';
		}
		if(!in_array($this->fields['rarity_id'],array_flip($this->fields['rarities'])))
		{
			$errors[] = 'Rarity is not a valid selection';
		}

		return $errors;
	}

	private function loadToken()
	{
		global $db;

		$sql = "select
					token_id, 
					name,  
					image,
					attack,
					defense,
					cost,
					element_id,
					direction_id,
					class_id,
					rarity_id
				from 
					token 
				where token_id = ?";
		$params = array($this->token_id);

		$this->fields =  $db->getRow($sql,null,$params);

		$sql = "select
					element_id,
					name
				from 
					element ";
		$params = array();
		$this->fields['elements'] =  $db->getAssoc($sql,null,$params);

		$sql = "select
					direction_id,
					concat(top_right,d_right,bottom_right,bottom_left,d_left,top_left) as 'directions'
				from 
					direction ";
		$params = array();
		$this->fields['directions'] =  $db->getAssoc($sql,null,$params);

		$sql = "select 
					class_id,
					name
				from token_class ";
		$params = array();
		$this->fields['classes'] =  $db->getAssoc($sql,null,$params);

		$sql = "select 
					rarity_id,
					name
				from rarity ";
		$params = array();
		$this->fields['rarities'] =  $db->getAssoc($sql,null,$params);
	}

	public function  getTokens($class_id = '')
	{
		global $db;

		$params = array();
		$sql = "select
					t.token_id, 
					t.name,  
					t.image,
					t.attack,
					t.defense,
					t.cost,
					e.name as 'element_name',
					concat(d.top_right,',',d.d_right,',',d.bottom_right,',',d.bottom_left,',',d.d_left,',',d.top_left) as 'directions',
					r.name as 'rarity_name',
					c.name as 'class_name',
					t.class_id,
					t.element_id
				from 
					token t, element e, direction d, rarity r, token_class c 
				where
					t.element_id = e.element_id
					and t.direction_id = d.direction_id
					and t.rarity_id = r.rarity_id
					and t.class_id = c.class_id
					and t.deleted = 0 ";
		if($class_id)
		{
			$sql .= " and t.class_id = ? ";
			$params[] = $class_id;
		}
		$sql .=		" order by t.name";

		return  $db->getAll($sql,null,$params);
	}
	
	private function getElementImage()
	{
		global $db;
		
		$sql = "select image from element where element_id = ?";
		$params = array($this->fields['element_id']);
		
		return $db->getOne($sql,null,$params);
	}
	
	public function save()
	{
		if($this->token_id)
		{
			$this->update();
		}
		else 
		{
			$this->insert();
		}
		$this->createTokenImage();
	}
	
	protected function createTokenImage()
	{
		$parts_dir = $_SERVER["DOCUMENT_ROOT"].'/demonshex/server/images/token_parts/';
		$characters_dir = $_SERVER["DOCUMENT_ROOT"].'/demonshex/images/characters/';

		$token_img = imagecreatefrompng($parts_dir.'token_brown.png');

		imagealphablending($token_img, true);
		imagesavealpha($token_img, true);

		$character_img = imagecreatefrompng($characters_dir.$this->fields['image']);
		imagecopy($token_img, $character_img, 32, 32, 0, 0, 64, 64);
		
		$shield_img = imagecreatefrompng($parts_dir.'shield_small.png');
		imagecopy($token_img, $shield_img, 89, 44, 0, 0, 16, 16);

		$defense_img = imagecreatefrompng($parts_dir.'number_'.$this->fields['defense'].'.png');
		imagecopy($token_img, $defense_img, 81, 59, 0, 0, 32, 32);
		
		$sword_img = imagecreatefrompng($parts_dir.'sword_small.png');
		imagecopy($token_img, $sword_img, 24, 44, 0, 0, 16, 16);
		
		$attack_img = imagecreatefrompng($parts_dir.'number_'.$this->fields['attack'].'.png');
		imagecopy($token_img, $attack_img, 16, 59, 0, 0, 32, 32);
		
		$directions = $this->getDirections();
		$arrow_left_img = imagecreatefrompng($parts_dir.'arrow_left.png');
		$arrow_right_img = imagecreatefrompng($parts_dir.'arrow_right.png');
		foreach($directions as $key=>$direction)
		{
			if($direction == 1)
			{
				switch ($key)
				{
					case 'top_right':
						imagecopy($token_img, $arrow_left_img, 82, 18, 0, 0, 10, 10);
						break;
					case 'd_right':
						imagecopy($token_img, $arrow_right_img, 107, 59, 0, 0, 10, 10);
						break;
					case 'bottom_right':
						imagecopy($token_img, $arrow_left_img, 82, 100, 0, 0, 10, 10);
						break;
					case 'bottom_left':
						imagecopy($token_img, $arrow_right_img, 36, 100, 0, 0, 10, 10);
						break;
					case 'd_left':
						imagecopy($token_img, $arrow_left_img, 10, 59, 0, 0, 10, 10);
						break;
					case 'top_left':
						imagecopy($token_img, $arrow_right_img, 36, 18, 0, 0, 10, 10);
						break;
				}
			}
		}
		
		if($this->fields['element_id'] !== 0)
		{
			$element_img = imagecreatefrompng($parts_dir.$this->getElementImage());
			imagecopy($token_img, $element_img, 56, 94, 0, 0, 16, 16);
		}

		$tokens_dir = $_SERVER["DOCUMENT_ROOT"].'/demonshex/images/tokens/';
		if(!is_dir($tokens_dir))
		{
			mkdir($tokens_dir,0755,true);
		}
		imagepng($token_img, $tokens_dir.$this->fields['image']);
	}
	
	private function getDirections()
	{
		global $db;
		
		$sql = "select
					top_right,d_right,bottom_right,bottom_left,d_left,top_left
				from
					direction 
				where
					direction_id = ?";
		$params = array($this->fields['direction_id']);
		return $db->getRow($sql,null,$params);
	}
	
	protected function insert()
	{
		global $db;
		
		$sql = "insert into token (name, image, attack, defense, element_id, direction_id, class_id, rarity_id, cost, deleted) 
					values (?,?,?,?,?,?,?,?,?,0)";
		$params = array($this->fields['name'],$this->fields['image'],$this->fields['attack'],$this->fields['defense'],$this->fields['element_id'],$this->fields['direction_id'],$this->fields['class_id'],$this->fields['rarity_id'],$this->fields['cost']);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		$query->free();
		$db->commit();
	}
	
	protected function update()
	{
		global $db;
		
		$sql = "update token set
					name = ?,
					image = ?,
					attack = ?,
					defense = ?,
					element_id = ?,
					direction_id = ?,
					class_id = ?,
					rarity_id = ?,
					cost = ?
				where token_id = ?";
		$params = array($this->fields['name'],$this->fields['image'],$this->fields['attack'],$this->fields['defense'],$this->fields['element_id'],$this->fields['direction_id'],$this->fields['class_id'],$this->fields['rarity_id'],$this->fields['cost'],$this->token_id);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		$query->free();
		$db->commit();
	}
	
	public function __get($var)
	{
		switch ($var)
		{
			case 'token_id':
			case 'fields':
				return $this->$var;
		}
	}
	
	public function getClasses()
	{
		global $db;
		$sql = "select
					class_id,
					name
				from token_class ";
		$params = array();
		return $db->getAssoc($sql,null,$params);
	}
}
?>