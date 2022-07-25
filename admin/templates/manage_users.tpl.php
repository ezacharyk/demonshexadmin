<h2>Manage Users</h2>

<form action="manage_users.php" method="post">
<input type="submit" name ="button" value="Add User">
<h3>Existing Users</h3>
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>User Name</th>
			<th>Email</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user){?>
		<tr>
			<td><input type="radio" name="admin_id" id="admin_<?php echo($user['admin_id'])?>" value="<?php echo($user['admin_id'])?>" ></td>
			<td><?php echo($user['login_id'])?></td>
			<td><?php echo($user['email'])?></td>
			<td><?php echo($user['status_name'])?></td>
		<tr>
		<?php }?>
	</tbody>
</table>
<input type="submit" name ="button" value="Edit User">
<input type="submit" name ="button" value="Delete User">
<input type="submit" name ="button" value="Main Menu">
</form>
<?php
?>