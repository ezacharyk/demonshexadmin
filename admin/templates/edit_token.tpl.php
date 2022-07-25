<h2><?php if($_SESSION['token_id']){?>Edit<?php }else{?>Add<?php }?> Token</h2>

<form action="edit_token.php" method="post" enctype="multipart/form-data">
	
	<label for="name">Token Name:</label><input type="text" name="name" id="name" maxlength="50" size="25" value="<?php echo($fields['name']);?>"><br>
	
	<label for="name">Token Image (png only):</label><input type="file" name="image" id="image" maxlength="100"> <?php echo($fields['image']);?> <img src="http://<?php echo($_SERVER["HTTP_HOST"]);?>/demonshex/images/characters/<?php echo($fields['image']);?>"><br>
	
	<label for="name">Token Attack:</label><input type="text" name="attack" id="attack" maxlength="2" size="25" value="<?php echo($fields['attack']);?>"><br>
	
	<label for="name">Token Defense:</label><input type="text" name="defense" id="defense" maxlength="2" size="25" value="<?php echo($fields['defense']);?>"><br>
	
	<label for="element_id">Token Element:</label>
		<select name="element_id" id="element_id">
			<?php foreach($fields['elements'] as $element_id => $name){?>
			<option value="<?php echo($element_id);?>" <?php if($fields['element_id'] == $element_id){echo('selected');}?>>
				<?php echo($name);?>
			</option>
			<?php }?>
		</select><br>
	
	<label for="direction_id">Token Directions:</label>
		<select name="direction_id" id="direction_id">
			<?php foreach($fields['directions'] as $direction_id => $directions){?>
			<option value="<?php echo($direction_id);?>" <?php if($fields['direction_id'] == $direction_id){echo('selected');}?>>
				<?php echo($directions);?>
			</option>
			<?php }?>
		</select><br>
	
	<label for="class_id">Token Class:</label>
		<select name="class_id" id="class_id">
			<?php foreach($fields['classes'] as $class_id => $class){?>
			<option value="<?php echo($class_id);?>" <?php if($fields['class_id'] == $class_id){echo('selected');}?>>
				<?php echo($class);?>
			</option>
			<?php }?>
		</select><br>
	
	<label for="rarity_id">Token Rarity:</label>
		<select name="rarity_id" id="rarity_id">
			<?php foreach($fields['rarities'] as $rarity_id => $name){?>
			<option value="<?php echo($rarity_id);?>" <?php if($fields['rarity_id'] == $rarity_id){echo('selected');}?>>
				<?php echo($name);?>
			</option>
			<?php }?>
		</select><br>
	
	<label for="name">Token Cost:</label><input type="text" name="cost" id="cost" maxlength="5" size="25" value="<?php echo($fields['cost']);?>"><br>
	
	<img src="http://<?php echo($_SERVER["HTTP_HOST"]);?>/demonshex/images/tokens/<?php echo($fields['image']);?>">
	
	<input type="submit" name ="button" value="Save Token">
	<input type="submit" name ="button" value="Back">
	<input type="submit" name ="button" value="Main Menu">
	
</form>