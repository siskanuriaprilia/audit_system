<?php
// process_audit.php
// File untuk memproses dan menyimpan data audit ke database

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Ambil data dari form
        $audit_date = $_POST['audit_date'];
        $auditor = $_POST['auditor'];
        $product_name = $_POST['product_name'];
        $version = $_POST['version'];
        $appearance_packaging = $_POST['appearance_packaging'];
        $product_function = $_POST['product_function'];
        $material_quality = $_POST['material_quality'];
        $dimensions_specs = $_POST['dimensions_specs'];
        $dimensions_compliance = $_POST['dimensions_compliance'];
        $overall_result = $_POST['overall_result'];
        $recommendations = $_POST['recommendations'];
        $auditor_signature = $_POST['auditor_signature'];
        $supervisor_signature = $_POST['supervisor_signature'];
        
        // Query untuk insert data
        $sql = "INSERT INTO product_audits (
                    audit_date, auditor, product_name, version,
                    appearance_packaging, product_function, material_quality,
                    dimensions_specs, dimensions_compliance, overall_result,
                    recommendations, auditor_signature, supervisor_signature
                ) VALUES (
                    :audit_date, :auditor, :product_name, :version,
                    :appearance_packaging, :product_function, :material_quality,
                    :dimensions_specs, :dimensions_compliance, :overall_result,
                    :recommendations, :auditor_signature, :supervisor_signature
                )";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind parameter
        $stmt->bindParam(':audit_date', $audit_date);
        $stmt->bindParam(':auditor', $auditor);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':appearance_packaging', $appearance_packaging);
        $stmt->bindParam(':product_function', $product_function);
        $stmt->bindParam(':material_quality', $material_quality);
        $stmt->bindParam(':dimensions_specs', $dimensions_specs);
        $stmt->bindParam(':dimensions_compliance', $dimensions_compliance);
        $stmt->bindParam(':overall_result', $overall_result);
        $stmt->bindParam(':recommendations', $recommendations);
        $stmt->bindParam(':auditor_signature', $auditor_signature);
        $stmt->bindParam(':supervisor_signature', $supervisor_signature);
        
        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect ke halaman view data dengan pesan sukses
            header("Location: view_data.php?success=1");
            exit();
        } else {
            throw new Exception("Gagal menyimpan data");
        }
        
    } catch(Exception $e) {
        // Redirect dengan pesan error
        header("Location: add_audit.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Jika bukan POST request, redirect ke form
    header("Location: add_audit.php");
    exit();
}
?>