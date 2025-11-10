<?php
// get_detail.php
// API untuk mengambil detail audit

require_once 'config/database.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM product_audits WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $audit = $stmt->fetch();
    
    if ($audit) {
        echo json_encode([
            'success' => true,
            'audit' => $audit
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID tidak valid'
    ]);
}
?>