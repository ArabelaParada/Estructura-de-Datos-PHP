<?php
// Este archivo es incluido desde guardar.php

// Directorio de uploads
$uploadDir = '../assets/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Función para subir archivos
function subirArchivo($fileInput, $cliente_id, $tipo_archivo, $pdo) {
    global $uploadDir;
    
    if (isset($fileInput) && $fileInput['error'] === UPLOAD_ERR_OK) {
        $fileName = uniqid() . '_' . basename($fileInput['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($fileInput['tmp_name'], $targetPath)) {
            // Guardar en base de datos
            $stmt = $pdo->prepare("INSERT INTO archivos_clientes (cliente_id, nombre_archivo, ruta_archivo, tipo_archivo, fecha_subida) 
                                  VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$cliente_id, $fileInput['name'], $fileName, $tipo_archivo]);
            return true;
        }
    }
    return false;
}

// Subir archivos individuales
if (isset($_FILES['doc_identidad'])) {
    subirArchivo($_FILES['doc_identidad'], $cliente_id, 'Documento de Identidad', $pdo);
}

if (isset($_FILES['constancia_cuit'])) {
    subirArchivo($_FILES['constancia_cuit'], $cliente_id, 'Constancia de CUIT', $pdo);
}

// Subir múltiples archivos
if (isset($_FILES['otros_documentos'])) {
    foreach ($_FILES['otros_documentos']['name'] as $key => $name) {
        if ($_FILES['otros_documentos']['error'][$key] === UPLOAD_ERR_OK) {
            $file = [
                'name' => $name,
                'type' => $_FILES['otros_documentos']['type'][$key],
                'tmp_name' => $_FILES['otros_documentos']['tmp_name'][$key],
                'error' => $_FILES['otros_documentos']['error'][$key],
                'size' => $_FILES['otros_documentos']['size'][$key]
            ];
            subirArchivo($file, $cliente_id, 'Otro Documento', $pdo);
        }
    }
}
?>