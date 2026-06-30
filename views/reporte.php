<?php
require_once "../clases/myConexionPDO.php";

$db = new mod_db();
$con = $db->getConexion();

$sql = "
SELECT
    i.id,
    i.identidad,
    i.nombre,
    i.apellido,
    i.edad,
    i.sexo,
    i.correo,
    i.celular,
    i.estado_integridad,
    GROUP_CONCAT(ai.nombre SEPARATOR ', ') AS temas
FROM inscriptores i
LEFT JOIN inscriptor_temas it
    ON i.id = it.inscriptor_id
LEFT JOIN areas_interes ai
    ON ai.id = it.area_interes_id
GROUP BY i.id
ORDER BY i.id DESC
";

$stmt = $con->prepare($sql);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Inscritos</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    padding:20px;
}

h1{
    text-align:center;
    color:#0d6efd;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#0d6efd;
    color:white;
    padding:10px;
}

td{
    border:1px solid #ddd;
    padding:8px;
}

tr:nth-child(even){
    background:#f8f8f8;
}

.valido{
    color:green;
    font-weight:bold;
}

.corrupto{
    color:red;
    font-weight:bold;
}

</style>
</head>

<body>

<h1>Reporte de Inscritos</h1>

<table>

<tr>
    <th>Identidad</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Edad</th>
    <th>Sexo</th>
    <th>Correo</th>
    <th>Celular</th>
    <th>Temas</th>
    <th>Integridad</th>
</tr>

<?php foreach($datos as $fila): ?>

<tr>

<td><?= htmlspecialchars($fila['identidad']) ?></td>
<td><?= htmlspecialchars($fila['nombre']) ?></td>
<td><?= htmlspecialchars($fila['apellido']) ?></td>
<td><?= htmlspecialchars($fila['edad']) ?></td>
<td><?= htmlspecialchars($fila['sexo']) ?></td>
<td><?= htmlspecialchars($fila['correo']) ?></td>
<td><?= htmlspecialchars($fila['celular']) ?></td>
<td><?= htmlspecialchars($fila['temas']) ?></td>

<td>
<?php if($fila['estado_integridad'] == 'valido'): ?>
<span class="valido">🟢 Válido</span>
<?php else: ?>
<span class="corrupto">🔴 Corrupto</span>
<?php endif; ?>
</td>

</tr>

<?php endforeach; ?>

</table>

<br>

<a href="formulario.php">
<button>Volver al Formulario</button>
</a>

</body>
</html>