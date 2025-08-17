<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitizar y validar datos
        $datos = [
            'tipo_documento' => sanitizeInput($_POST['tipo_documento']),
            'numero_documento' => sanitizeInput($_POST['numero_documento']),
            'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
            'nombre' => sanitizeInput($_POST['nombre']),
            'apellido' => sanitizeInput($_POST['apellido']),
            'genero' => sanitizeInput($_POST['genero']),
            'estado_civil' => sanitizeInput($_POST['estado_civil']),
            'telefono' => sanitizeInput($_POST['telefono']),
            'celular' => sanitizeInput($_POST['celular']),
            'email' => sanitizeInput($_POST['email']),
            'direccion' => sanitizeInput($_POST['direccion']),
            'ciudad' => sanitizeInput($_POST['ciudad']),
            'provincia' => sanitizeInput($_POST['provincia']),
            'codigo_postal' => sanitizeInput($_POST['codigo_postal'])
        ];

        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO clientes (tipo_documento, numero_documento, fecha_nacimiento, nombre, apellido, genero, estado_civil, telefono, celular, email, direccion, ciudad, provincia, codigo_postal, fecha_creacion) 
                              VALUES (:tipo_documento, :numero_documento, :fecha_nacimiento, :nombre, :apellido, :genero, :estado_civil, :telefono, :celular, :email, :direccion, :ciudad, :provincia, :codigo_postal, NOW())");
        
        $stmt->execute($datos);
        $cliente_id = $pdo->lastInsertId();

        // Procesar archivos subidos
        require_once 'subir_archivo.php';
        
        // Redirigir con mensaje de éxito
        $_SESSION['mensaje'] = "Cliente registrado correctamente.";
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: index.php");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al guardar cliente: " . $e->getMessage();
        $_SESSION['mensaje_tipo'] = "error";
        header("Location: index.php");
        exit();
    }
}
?>