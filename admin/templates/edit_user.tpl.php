<h2><?php if($_SESSION['edit_user_id']){?>Edit<?php }else{?>Add<?php }?> User</h2>

<form action="edit_user.php" method="post">
	
	<label for="login_id">User Login ID:</label><input type="text" name="login_id" id="login_id" maxlength="25" size="25" value="<?php echo($fields['login_id']);?>"><br>
	
	<label for="email">User Email:</label><input type="text" name="email" id="email" maxlength="100" size="25" value="<?php echo($fields['email']);?>"><br>
	
	<label for="password">User Password:</label><input type="password" name="password" id="password" maxlength="25" size="25"><br>
		
	<label for="conf_password">Confirm Password:</label><input type="password" name="conf_password" id="conf_password" maxlength="25" size="25" ><br>
	
	<label for="status_id">User Status:</label>
		<select name="status_id" id="status_id">
			<?php foreach($fields['statuses'] as $status_id => $name){?>
			<option value="<?php echo($status_id);?>" <?php if($fields['status_id'] == $status_id){echo('selected');}?>>
				<?php echo($name);?>
			</option>
			<?php }?>
		</select><br>
		
	<input type="submit" name ="button" value="Save User">
	<input type="submit" name ="button" value="Back">
	<input type="submit" name ="button" value="Main Menu">
	
</form>