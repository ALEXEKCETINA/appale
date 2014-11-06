<h2>GROUPS</h2>
<a href="groups/add">Agregar Grupo</a>
<table border="1">
<tr>
<th> ID </th>
<th> Grupo </th>
<th> Opciones </th>
</tr>
<?php
foreach ($groups as $group):
?>
<tr>
	<td><?php echo $group["id"];?></td>
	<td><?php echo $group["name"];?></td>
    <td><a href="groups/edit/<?php echo $group['id']?>">Modificar</a> | <a href="groups/delete/<?php echo $group['id']?>">Eliminar</a></td>
<?php
endforeach; ?>
</table>