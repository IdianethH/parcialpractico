<?php
require_once "../clases/myConexionPDO.php";
$db = new mod_db();
$paises = $db->Arreglos("SELECT * FROM paises ORDER BY nombre");
$areas = $db->Arreglos("SELECT * FROM areas_interes ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inscripción - Evento iTECH</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #d9e43c, #198754);
    margin: 0;
    padding: 30px;
    color: #fff;
}

.form-container {
    max-width: 600px;
    margin: auto;
    background: #fff;
    color: #222;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(25, 135, 84, 0.4);
}

h1 {
    text-align: center;
    color: #525523;
}

label {
    display: block;
    margin-top: 14px;
    font-weight: 600;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

.checkboxes label {
    display: inline-block;
    width: 48%;
    font-weight: 400;
}

button {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background: #373a11;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #d9e43c;
}

footer {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #6c757d;
}
</style>
</head>
<body>
<div class="form-container">
    <h1>Formulario de Inscripción</h1>
    <form action="../controllers/inscritosController.php" method="POST">
        <label>Identidad (Documento de Identificación)</label>
        <input type="text" name="identidad" placeholder="8-123-4567" required>

        <label>Nombre</label>
        <input type="text" name="nombre" required>

        <label>Apellido</label>
        <input type="text" name="apellido" required>

        <label>Edad</label>
        <input type="number" name="edad" required min="1" max="120">

        <label>Sexo</label>
        <select name="sexo" required>
            <option value="">-- Seleccione --</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select>

        <label>País de Residencia</label>
        <select name="pais_residencia_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($paises as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Nacionalidad</label>
        <select name="nacionalidad_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($paises as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Correo</label>
        <input type="email" name="correo" required>

        <label>Celular</label>
        <input type="text" name="celular" placeholder="6123-4567" required>

        <label>Tema Tecnológico que le gustaría aprender</label>
        <div class="checkboxes">
            <?php foreach ($areas as $a): ?>
                <label><input type="checkbox" name="areas[]" value="<?= $a['id'] ?>"> <?= htmlspecialchars($a['nombre']) ?></label>
            <?php endforeach; ?>
        </div>

        <label>Observaciones o Consulta sobre el evento</label>
        <textarea name="observaciones" rows="3"></textarea>

        <button type="submit">Inscribirme</button>
        <a href="reporte.php">
    <button type="button">Ver Reporte</button>
</a>
    </form>
    <footer>&copy; <?= date("Y") ?> iTECH. All rights reserved.</footer>
</div>
</body>
</html>