<?php
class DemonsHex
{
	public function __construct($id = '')
	{
	}
	
	public function __destruct()
	{
		
	}
	
	public function getTokens($rarity)
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
					concat(d.top_right,d.d_right,d.bottom_right,d.bottom_left,d.d_left,d.top_left) as 'directions',
					r.name as 'rarity_name',
					c.name as 'class_name'
				from 
					token t, element e, direction d, rarity r, token_class c 
				where
					t.element_id = e.element_id
					and t.direction_id = d.direction_id
					and t.rarity_id = r.rarity_id
					and t.class_id = c.class_id
					and t.deleted = 0";
		
		if(is_numeric($rarity))
		{
			$sql .=	" and t.tokin_id = ?";
			$params[] = $rarity;
		}
		else 
		{
			$sql .=	" and t.tokin_id <> 99";
		}
					
		$sql .=	" order by t.name";

		return  $db->getAll($sql,null,$params);
	}
}