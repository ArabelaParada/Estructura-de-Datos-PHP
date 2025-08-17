<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

// Obtener ID del cliente a editar
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$cliente = getClienteById($pdo, $id);
$archivos = getArchivosCliente($pdo, $id);

if (!$cliente) {
    $_SESSION['mensaje'] = "Cliente no encontrado.";
    $_SESSION['mensaje_tipo'] = "error";
    header("Location: index.php");
    exit();
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitizar y validar datos
        $datos = [
            'id' => $id,
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

        // Actualizar en la base de datos
        $stmt = $pdo->prepare("UPDATE clientes SET 
                              tipo_documento = :tipo_documento, 
                              numero_documento = :numero_documento, 
                              fecha_nacimiento = :fecha_nacimiento, 
                              nombre = :nombre, 
                              apellido = :apellido, 
                              genero = :genero, 
                              estado_civil = :estado_civil, 
                              telefono = :telefono, 
                              celular = :celular, 
                              email = :email, 
                              direccion = :direccion, 
                              ciudad = :ciudad, 
                              provincia = :provincia, 
                              codigo_postal = :codigo_postal,
                              fecha_actualizacion = NOW()
                              WHERE id = :id");
        
        $stmt->execute($datos);

        // Procesar archivos subidos si hay alguno
        if (!empty($_FILES)) {
            require_once 'subir_archivo.php';
        }
        
        // Redirigir con mensaje de éxito
        $_SESSION['mensaje'] = "Cliente actualizado correctamente.";
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: index.php");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al actualizar cliente: " . $e->getMessage();
        $_SESSION['mensaje_tipo'] = "error";
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Seguros - Editar Cliente</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Cliente: <?= $cliente['nombre'] ?> <?= $cliente['apellido'] ?></h1>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?>">
                <?= $_SESSION['mensaje'] ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
        <?php endif; ?>
        
        <form id="cliente-form" action="editar.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <div class="tab-container">
                <div class="tab-header">
                    <button type="button" class="tab-button active" data-tab="identificacion">Identificación</button>
                    <button type="button" class="tab-button" data-tab="datos-generales">Datos Generales</button>
                    <button type="button" class="tab-button" data-tab="contacto">Contacto</button>
                    <button type="button" class="tab-button" data-tab="archivos">Archivos</button>
                </div>
                
                <!-- Pestaña de Identificación -->
                <div id="identificacion" class="tab-content active">
                    <div class="form-group">
                        <label for="tipo_documento">Tipo de Documento*</label>
                        <select class="form-control" id="tipo_documento" name="tipo_documento" required>
                            <option value="">Seleccione...</option>
                            <option value="DNI" <?= $cliente['tipo_documento'] === 'DNI' ? 'selected' : '' ?>>DNI</option>
                            <option value="CUIT" <?= $cliente['tipo_documento'] === 'CUIT' ? 'selected' : '' ?>>CUIT</option>
                            <option value="CUIL" <?= $cliente['tipo_documento'] === 'CUIL' ? 'selected' : '' ?>>CUIL</option>
                            <option value="LE" <?= $cliente['tipo_documento'] === 'LE' ? 'selected' : '' ?>>LE</option>
                            <option value="LC" <?= $cliente['tipo_documento'] === 'LC' ? 'selected' : '' ?>>LC</option>
                            <option value="Pasaporte" <?= $cliente['tipo_documento'] === 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="numero_documento">Número de Documento*</label>
                        <input type="text" class="form-control" id="numero_documento" name="numero_documento" value="<?= $cliente['numero_documento'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $cliente['fecha_nacimiento'] ?>">
                    </div>
                </div>
                
                <!-- Pestaña de Datos Generales -->
                <div id="datos-generales" class="tab-content">
                    <div class="form-group">
                        <label for="nombre">Nombre*</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $cliente['nombre'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="apellido">Apellido*</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $cliente['apellido'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select class="form-control" id="genero" name="genero">
                            <option value="">Seleccione...</option>
                            <option value="Masculino" <?= $cliente['genero'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                            <option value="Femenino" <?= $cliente['genero'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                            <option value="Otro" <?= $cliente['genero'] === 'Otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="form-control" id="estado_civil" name="estado_civil">
                            <option value="">Seleccione...</option>
                            <option value="Soltero/a" <?= $cliente['estado_civil'] === 'Soltero/a' ? 'selected' : '' ?>>Soltero/a</option>
                            <option value="Casado/a" <?= $cliente['estado_civil'] === 'Casado/a' ? 'selected' : '' ?>>Casado/a</option>
                            <option value="Divorciado/a" <?= $cliente['estado_civil'] === 'Divorciado/a' ? 'selected' : '' ?>>Divorciado/a</option>
                            <option value="Viudo/a" <?= $cliente['estado_civil'] === 'Viudo/a' ? 'selected' : '' ?>>Viudo/a</option>
                        </select>
                    </div>
                </div>
                
                <!-- Pestaña de Contacto -->
                <div id="contacto" class="tab-content">
                    <div class="form-group">
                        <label for="telefono">Teléfono*</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= $cliente['telefono'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="tel" class="form-control" id="celular" name="celular" value="<?= $cliente['celular'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $cliente['email'] ?>" required>
                    </div>
        
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $cliente['direccion'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= $cliente['ciudad'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <input type="text" class="form-control" id="provincia" name="provincia" value="<?= $cliente['provincia'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?= $cliente['codigo_postal'] ?>">
                    </div>
                </div>
                
                <!-- Pestaña de Archivos -->
                <div id="archivos" class="tab-content">
                    <div class="archivos-container">
                        <h3>Archivos existentes</h3>
                        <?php if (count($archivos) > 0): ?>
                            <?php foreach ($archivos as $archivo): ?>
                                <div class="archivo-item">
                                    <div>
                                        <strong><?= $archivo['tipo_archivo'] ?>:</strong>
                                        <a href="../assets/uploads/<?= $archivo['ruta_archivo'] ?>" target="_blank"><?= $archivo['nombre_archivo'] ?></a>
                                        <small>(Subido el <?= date('d/m/Y', strtotime($archivo['fecha_subida'])) ?>)</small>
                                    </div>
                                    <a href="eliminar_archivo.php?id=<?= $archivo['id'] ?>&cliente_id=<?= $id ?>" class="btn" onclick="return confirm('¿Está seguro de eliminar este archivo?')">Eliminar</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay archivos subidos para este cliente.</p>
                        <?php endif; ?>
                    </div>
                    
                    <h3>Agregar nuevos archivos</h3>
                    <div class="form-group">
                        <label>Documento de Identidad</label>
                        <input type="file" class="file-input" id="doc_identidad" name="doc_identidad">
                        <label for="doc_identidad" class="form-control">Seleccionar archivo</label>
                    </div>
                    
                    <div class="form-group">
                        <label>Constancia de CUIT</label>
                        <input type="file" class="file-input" id="constancia_cuit" name="constancia_cuit">
                        <label for="constancia_cuit" class="form-control">Seleccionar archivo</label>
                    </div>
                    
                    <div class="form-group">
                        <label>Otros Documentos</label>
                        <input type="file" class="file-input" id="otros_documentos" name="otros_documentos[]" multiple>
                        <label for="otros_documentos" class="form-control">Seleccionar archivos</label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn">Actualizar Cliente</button>
            <a href="index.php" class="btn">Cancelar</a>
        </form>
    </div>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>