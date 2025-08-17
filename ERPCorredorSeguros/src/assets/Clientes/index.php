<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Procesar eliminación de cliente
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    try {
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['mensaje'] = "Cliente eliminado correctamente.";
        $_SESSION['mensaje_tipo'] = "success";
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al eliminar cliente: " . $e->getMessage();
        $_SESSION['mensaje_tipo'] = "error";
    }
    header("Location: index.php");
    exit();
}

$clientes = getClientes($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Seguros - Gestión de Clientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Clientes</h1>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?>">
                <?= $_SESSION['mensaje'] ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
        <?php endif; ?>
        
        <div class="tab-container">
            <div class="tab-header">
                <button class="tab-button active" data-tab="lista-clientes">Lista de Clientes</button>
                <button class="tab-button" data-tab="nuevo-cliente">Nuevo Cliente</button>
            </div>
            
            <div id="lista-clientes" class="tab-content active">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['id'] ?></td>
                            <td><?= $cliente['nombre'] ?></td>
                            <td><?= $cliente['apellido'] ?></td>
                            <td><?= $cliente['tipo_documento'] ?>: <?= $cliente['numero_documento'] ?></td>
                            <td><?= $cliente['telefono'] ?></td>
                            <td><?= $cliente['email'] ?></td>
                            <td>
                                <a href="editar.php?id=<?= $cliente['id'] ?>" class="btn">Editar</a>
                                <a href="index.php?eliminar=<?= $cliente['id'] ?>" class="btn" onclick="return confirm('¿Está seguro de eliminar este cliente?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div id="nuevo-cliente" class="tab-content">
                <form id="cliente-form" action="guardar.php" method="post" enctype="multipart/form-data">
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
                                    <option value="DNI">DNI</option>
                                    <option value="CUIT">CUIT</option>
                                    <option value="CUIL">CUIL</option>
                                    <option value="LE">LE</option>
                                    <option value="LC">LC</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="numero_documento">Número de Documento*</label>
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                        </div>
                        
                        <!-- Pestaña de Datos Generales -->
                        <div id="datos-generales" class="tab-content">
                            <div class="form-group">
                                <label for="nombre">Nombre*</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="apellido">Apellido*</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="genero">Género</label>
                                <select class="form-control" id="genero" name="genero">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="estado_civil">Estado Civil</label>
                                <select class="form-control" id="estado_civil" name="estado_civil">
                                    <option value="">Seleccione...</option>
                                    <option value="Soltero/a">Soltero/a</option>
                                    <option value="Casado/a">Casado/a</option>
                                    <option value="Divorciado/a">Divorciado/a</option>
                                    <option value="Viudo/a">Viudo/a</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Pestaña de Contacto -->
                        <div id="contacto" class="tab-content">
                            <div class="form-group">
                                <label for="telefono">Teléfono*</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="tel" class="form-control" id="celular" name="celular">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad">
                            </div>
                            
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input type="text" class="form-control" id="provincia" name="provincia">
                            </div>
                            
                            <div class="form-group">
                                <label for="codigo_postal">Código Postal</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                            </div>
                        </div>
                        
                        <!-- Pestaña de Archivos -->
                        <div id="archivos" class="tab-content">
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
                    
                    <button type="submit" class="btn">Guardar Cliente</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>