<?php
// backend/controllers/main.php

// Verificar si se ha solicitado una acción a través de GET
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home'; // Acción predeterminada
}

// Dependiendo de la acción, se cargará una vista u otra
switch ($action) {
    case 'home':
        // Cargar la vista para la página de inicio
        echo "<h1>Bienvenido a la página de inicio</h1>";
        break;

    case 'about':
        // Cargar la vista sobre nosotros
        echo "<h1>Acerca de Nosotros</h1>";
        break;

    default:
        // Acción no encontrada
        echo "<h1>Acción no encontrada. Página no disponible.</h1>";
        break;
}

// Ejemplo de cómo podrías agregar lógica para un formulario de login (opcional)
if ($action == 'login') {
    // Aquí podrías incluir un formulario de login o manejar la lógica de autenticación
    echo "<h1>Formulario de Login</h1>";
    // Lógica para validar datos de usuario o cargar un formulario
}
?>
