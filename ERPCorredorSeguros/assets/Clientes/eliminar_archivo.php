<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if (!isset($_GET['id']) || !isset($_GET['cliente_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$cliente_id = $_GET['cliente_id'];

try {
    // Obtener información del archivo
    $stmt = $pdo->prepare("SELECT * FROM archivos_clientes WHERE id = ?");
    $stmt->execute([$id]);
    $archivo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($archivo) {
        // Eliminar archivo físico
        $ruta_archivo = '../assets/uploads/' . $archivo['ruta_archivo'];
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
        
        // Eliminar registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM archivos_clientes WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['mensaje'] = "Archivo eliminado correctamente.";
        $_SESSION['mensaje_tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "Archivo no encontrado.";
        $_SESSION['mensaje_tipo'] = "error";
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al eliminar archivo: " . $e->getMessage();
    $_SESSION['mensaje_tipo'] = "error";
}

header("Location: editar.php?id=" . $cliente_id);
exit();
?>