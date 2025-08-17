<?php
// public/index.php
include('C:\xampp\htdocs\ERPCorredorSeguros\backend\controllers\main.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema ERP para gestión de correduría de seguros">
  <title>ERP Corredor de Seguros | Gestión Integral</title>
  <link rel="icon" href="./favicon.ico">
  <link rel="preload" href="styles/styles.css" as="style">
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
  <!-- Contenedor para el mensaje dinámico -->
  <div id="app"></div>

  <!-- Menú hamburguesa -->
  <div class="menu-container">
    <button class="menu-btn" id="menu-toggle">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <nav id="menu" class="menu">
        <ul>
           <li><a href="index.php">Inicio</a></li>
            <li><a href="#registrar-cliente">Registrar Cliente</a></li>
            <li><a href="#registrar-poliza">Registrar Póliza</a></li>


            
        </ul>
    </nav>
  </div>


  <!-- Referencia al archivo JS -->
  <script src="main.js"></script>
</body>
</html>

