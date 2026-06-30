<?php
class Validacion {
    public static function validarIdentidad($id) {
        return preg_match('/^\d{1,2}-\d{3,4}-\d{1,6}$/', $id);
    }
    public static function validarTexto($texto) {
        return preg_match('/^[a-zA-ZÀ-ÿ\s]{2,100}$/', $texto);
    }
    public static function validarEdad($edad) {
        return is_numeric($edad) && $edad >= 0 && $edad <= 120;
    }
    public static function validarCorreo($correo) {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
    }
    public static function validarCelular($cel) {
        return preg_match('/^[0-9]{4}-?[0-9]{4}$/', $cel);
    }
    public static function validarFormulario($data) {
        $errores = [];
        if (!self::validarIdentidad($data['identidad'])) $errores[] = "Identidad inválida";
        if (!self::validarTexto($data['nombre'])) $errores[] = "Nombre inválido";
        if (!self::validarTexto($data['apellido'])) $errores[] = "Apellido inválido";
        if (!self::validarEdad($data['edad'])) $errores[] = "Edad inválida";
        if (!self::validarCorreo($data['correo'])) $errores[] = "Correo inválido";
        if (!self::validarCelular($data['celular'])) $errores[] = "Celular inválido";
        return $errores;
    }
}