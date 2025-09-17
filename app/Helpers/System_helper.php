<?php

if (!function_exists('name_system')) {
    function name_system()
    {
        return "Intelectum";
    }
}

if (!function_exists('base_archives_constancias')) {
    function base_archives_constancias(string $path = ''): string
    {
        return base_url('../repositor/constancias' . ltrim($path, '/'));
    }
}

if (!function_exists('base_archives_material_tesis')) {
    function base_archives_material_tesis(string $path = ''): string
    {
        
        return 'http://localhost/IntelectumRepositorio/repositor/material/tesis/'. ltrim($path, '/');
    }
}

if (!function_exists('base_archives_tramites_dj')) {
    function base_archives_tramites_dj(string $path = ''): string
    {
        return 'http://localhost/IntelectumRepositorio/repositor/tramites/declaracionesJuradas/'. ltrim($path, '/');
    }   
}

if (!function_exists('base_archives_tramites_auth_pub')) {
    function base_archives_tramites_auth_pub(string $path = ''): string
    {
        return 'http://localhost/IntelectumRepositorio/repositor/tramites/autorizacionesPublicacion/'. ltrim($path, '/');
    }
        
    
}

?>