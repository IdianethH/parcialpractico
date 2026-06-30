<?php
class Sanitizacion {
    public static function limpiarTexto($texto) {
        return htmlspecialchars(strip_tags(trim($texto)), ENT_QUOTES, 'UTF-8');
    }
    public static function tituloCase($texto) {
        return mb_convert_case(strtolower(trim($texto)), MB_CASE_TITLE, "UTF-8");
    }
    public static function limpiarCorreo($correo) {
        return filter_var(trim($correo), FILTER_SANITIZE_EMAIL);
    }
    public static function limpiarNumero($num) {
        return preg_replace('/[^0-9-]/', '', $num);
    }
    public static function sanitizarFormulario($data) {
        return [
            'identidad' => self::limpiarTexto($data['identidad']),
            'nombre'    => self::tituloCase($data['nombre']),
            'apellido'  => self::tituloCase($data['apellido']),
            'edad'      => (int)$data['edad'],
            'sexo'      => self::limpiarTexto($data['sexo']),
            'correo'    => self::limpiarCorreo($data['correo']),
            'celular'   => self::limpiarNumero($data['celular']),
            'observaciones' => self::limpiarTexto($data['observaciones'] ?? '')
        ];
    }
}