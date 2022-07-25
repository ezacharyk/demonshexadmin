<h2>Manage Tokens</h2>

<form action="manage_tokens.php" method="post">
<a href="get_inventory.php">Get Tokens</a><br><br>
<input type="submit" name ="button" value="Add Token">

<h3>Search Tokens</h3>
<label for="class_id">Token Class:</label>
	<select name="class_id" id="class_id">
		<option value="" >
			All
		</option>
		<?php foreach($classes as $class_id => $class){?>
		<option value="<?php echo($class_id);?>" <?php if($post_class == $class_id){echo('selected');}?>>
			<?php echo($class);?>
		</option>
		<?php }?>
	</select><br>
<input type="submit" name ="button" value="Search Tokens">
	
<h3>Existing Tokens</h3>
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>File Name</th>
			<th>Attack</th>
			<th>Defense</th>
			<th>Directions</th>
			<th>Class</th>
			<th>Element</th>
			<th>Rarity</th>
			<th>Cost</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($tokens as $token){?>
		<tr>
			<td><input type="radio" name="token_id" id="token_<?php echo($token['token_id'])?>" value="<?php echo($token['token_id'])?>" ></td>
			<td><?php echo($token['name'])?></td>
			<td><?php echo($token['image'])?></td>
			<td><?php echo($token['attack'])?></td>
			<td><?php echo($token['defense'])?></td>
			<td><?php echo($token['directions'])?></td>
			<td><?php echo($token['class_name'])?></td>
			<td><?php echo($token['element_name'])?></td>
			<td><?php echo($token['rarity_name'])?></td>
			<td><?php echo($token['cost'])?></td>
		<tr>
		<?php }?>
	</tbody>
</table>
<input type="submit" name ="button" value="Edit Token">
<input type="submit" name ="button" value="Delete Token">
<input type="submit" name ="button" value="Main Menu">
</form>
<?php
?>