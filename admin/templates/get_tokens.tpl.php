<form action="get_inventory.php" method="post">
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
<input type="submit" name ="button" value="Select Tokens">
<input type="submit" name ="button" value="Back"><br><br><br>

<textarea rows="40" cols="100"><?php echo($token_xml)?></textarea>

</form>