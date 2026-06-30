<?php
require_once "../clases/myConexionPDO.php";
require_once "../utils/Validacion.php";
require_once "../utils/Sanitizacion.php";

$db = new mod_db();
$con = $db->getConexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errores = Validacion::validarFormulario($_POST);

    if (!empty($errores)) {
        echo "<script>alert('" . implode('\\n', $errores) . "'); window.history.back();</script>";
        exit;
    }

    $data = Sanitizacion::sanitizarFormulario($_POST);

    // Firma digital de integridad (OpenSSL)
    $contenido = $data['nombre'] . $data['identidad'] . $data['correo'] . $data['celular'] . $data['sexo'];
    $keysDir = __DIR__ . '/../keys';
    $privateKeyPath = $keysDir . '/private.pem';

    if (!file_exists($privateKeyPath)) {
        if (!is_dir($keysDir)) mkdir($keysDir, 0777, true);
        $res = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        openssl_pkey_export($res, $privKey);
        file_put_contents($privateKeyPath, $privKey);
        $pubKey = openssl_pkey_get_details($res)['key'];
        file_put_contents($keysDir . '/public.pem', $pubKey);
    }

    $privateKey = file_get_contents($privateKeyPath);
    openssl_sign($contenido, $firma, $privateKey, OPENSSL_ALGO_SHA256);
    $firmaBase64 = base64_encode($firma);

    // Insertar inscriptor
    $datosInsert = [
        'identidad'           => $data['identidad'],
        'nombre'              => $data['nombre'],
        'apellido'            => $data['apellido'],
        'edad'                => $data['edad'],
        'sexo'                => $data['sexo'],
        'pais_residencia_id'  => (int)$_POST['pais_residencia_id'],
        'nacionalidad_id'     => (int)$_POST['nacionalidad_id'],
        'correo'              => $data['correo'],
        'celular'             => $data['celular'],
        'observaciones'       => $data['observaciones'],
        'firma_digital'       => $firmaBase64,
        'estado_integridad'   => 'valido'
    ];

    $ok = $db->insertSeguro('inscriptores', $datosInsert);

    if ($ok) {
        $idInscrito = $db->insert_id();

        if (!empty($_POST['areas'])) {
            foreach ($_POST['areas'] as $area) {
                $db->insertSeguro('inscriptor_temas', [
                    'inscriptor_id'   => $idInscrito,
                    'area_interes_id' => $area
                ]);
            }
        }
        echo "<script>alert('Inscripción exitosa'); window.location='../views/formulario.php';</script>";
    } else {
        echo "<script>alert('Error al guardar los datos'); window.history.back();</script>";
    }
}