<h1>Modificar Usuario</h1>
<form action="users/edit" method="post">
	<input type="hidden" name="id" value="<?php echo $user['id']?>">
	<p>First Name: <input type="text" name="first_name" value="<?php echo $user['first_name']?>"></p>
   	<p>Last Name: <input type="text" name="last_name" value="<?php echo $user['last_name']?>"></p>
	<p>Email: <input type="text" name="email" value="<?php echo $user['email']?>"></p>
    <p>Username: <input type="text" name="email" value="<?php echo $user['username']?>"></p>
    <p>Password: <input type="text" name="email" value="<?php echo $user['password']?>"></p>
    <p><input type="submit" value="update"></p>
</form>