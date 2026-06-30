<?php
require_once "../clases/myConexionPDO.php";

$db = new mod_db();
$con = $db->getConexion();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_inscritos.xls");

$sql = "
SELECT
    i.identidad,
    i.nombre,
    i.apellido,
    i.edad,
    i.sexo,
    i.correo,
    i.celular,
    GROUP_CONCAT(ai.nombre SEPARATOR ', ') AS temas
FROM inscriptores i
LEFT JOIN inscriptor_temas it
    ON i.id = it.inscriptor_id
LEFT JOIN areas_interes ai
    ON ai.id = it.area_interes_id
GROUP BY i.id
";

$stmt = $con->prepare($sql);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
<tr>
    <th>Identidad</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Edad</th>
    <th>Sexo</th>
    <th>Correo</th>
    <th>Celular</th>
    <th>Temas</th>
</tr>

<?php foreach($datos as $fila): ?>
<tr>
    <td><?= $fila['identidad'] ?></td>
    <td><?= $fila['nombre'] ?></td>
    <td><?= $fila['apellido'] ?></td>
    <td><?= $fila['edad'] ?></td>
    <td><?= $fila['sexo'] ?></td>
    <td><?= $fila['correo'] ?></td>
    <td><?= $fila['celular'] ?></td>
    <td><?= $fila['temas'] ?></td>
</tr>
<?php endforeach; ?>

</table>