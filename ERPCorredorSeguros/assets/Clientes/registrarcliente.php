<?php
// registrar_cliente.php

// Incluir encabezado y otros archivos necesarios
include('header.php');  // Si tienes un archivo de encabezado (header.php)
?>

<h2>Registrar Cliente</h2>

<form action="guardar.php" method="post" enctype="multipart/form-data">
    <div>
        <label for="tipo_documento">Tipo de Documento:</label>
        <select name="tipo_documento" required>
            <option value="">Seleccione...</option>
            <option value="DNI">DNI</option>
            <option value="CUIT">CUIT</option>
            <option value="CUIL">CUIL</option>
            <option value="LE">LE</option>
            <option value="LC">LC</option>
            <option value="Pasaporte">Pasaporte</option>
        </select>
    </div>
    <div>
        <label for="numero_documento">Número de Documento:</label>
        <input type="text" name="numero_documento" required>
    </div>
    <div>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento">
    </div>
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
    </div>
    <div>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>
    </div>
    <div>
        <label for="genero">Género:</label>
        <select name="genero" required>
            <option value="">Seleccione...</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
    </div>
    <div>
        <label for="estado_civil">Estado Civil:</label>
        <select name="estado_civil" required>
            <option value="">Seleccione...</option>
            <option value="Soltero/a">Soltero/a</option>
            <option value="Casado/a">Casado/a</option>
            <option value="Divorciado/a">Divorciado/a</option>
            <option value="Viudo/a">Viudo/a</option>
        </select>
    </div>
    <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required>
    </div>
    <div>
        <label for="celular">Celular:</label>
        <input type="text" name="celular">
    </div>
    <div>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion">
    </div>
    <div>
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad">
    </div>
    <div>
        <label for="provincia">Provincia:</label>
        <input type="text" name="provincia">
    </div>
    <div>
        <label for="codigo_postal">Código Postal:</label>
        <input type="text" name="codigo_postal">
    </div>

    <h3>Archivos Adjuntos</h3>
    <div>
        <label>Documento de Identidad:</label>
        <input type="file" name="doc_identidad" required>
    </div>
    <div>
        <label>Constancia de CUIT:</label>
        <input type="file" name="constancia_cuit" required>
    </div>
    <div>
        <label>Otros Documentos:</label>
        <input type="file" name="otros_documentos[]" multiple>
    </div>

    <button type="submit">Guardar Cliente</button>
</form>

<?php
// Incluir pie de página si es necesario
include('footer.php');  // Si tienes un archivo de pie de página (footer.php)
?>
