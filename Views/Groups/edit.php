<h1>Modificar Grupo</h1>
<form action="groups/edit" method="post">
	<input type="hidden" name="id" value="<?php echo $group['id']?>">
	<p>Grupo: <input type="text" name="name" value="<?php echo $group['name']?>"></p>
   	<p><input type="submit" value="update"></p>
</form>