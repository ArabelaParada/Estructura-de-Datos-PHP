<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getClientes($pdo) {
    $stmt = $pdo->query("SELECT * FROM clientes ORDER BY apellido, nombre");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClienteById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getArchivosCliente($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT * FROM archivos_clientes WHERE cliente_id = ?");
    $stmt->execute([$cliente_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>