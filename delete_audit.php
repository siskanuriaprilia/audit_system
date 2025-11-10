<?php
// delete_audit.php
// File untuk menghapus data audit

require_once 'config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $sql = "DELETE FROM product_audits WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            header("Location: view_data.php?deleted=1");
        } else {
            header("Location: view_data.php?error=delete");
        }
    } catch(Exception $e) {
        header("Location: view_data.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: view_data.php");
}
exit();
?>