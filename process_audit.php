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
        
        // Data audit K3 Lab Komputer
        $apd_teknis = $_POST['apd_teknis'];
        $kondisi_komputer = $_POST['kondisi_komputer'];
        $kebersihan_meja = $_POST['kebersihan_meja'];
        $rambu_k3 = $_POST['rambu_k3'];
        $apar_elektronik = $_POST['apar_elektronik'];
        $pencahayaan = $_POST['pencahayaan'];
        $ventilasi = $_POST['ventilasi'];
        $kabel = $_POST['kabel'];
        $evakuasi = $_POST['evakuasi'];
        $pelatihan_k3 = $_POST['pelatihan_k3'];
        
        // Hitung overall result berdasarkan jawaban
        $results = [
            $apd_teknis, $kondisi_komputer, $kebersihan_meja, 
            $rambu_k3, $apar_elektronik, $pencahayaan, 
            $ventilasi, $kabel, $evakuasi, $pelatihan_k3
        ];
        
        $unsatisfactory_count = count(array_filter($results, function($r) {
            return $r === 'Unsatisfactory';
        }));
        
        $needs_improvement_count = count(array_filter($results, function($r) {
            return $r === 'Needs Improvement';
        }));
        
        // Tentukan overall result
        if ($unsatisfactory_count > 0) {
            $overall_result = 'Unsatisfactory';
        } elseif ($needs_improvement_count > 2) {
            $overall_result = 'Needs Improvement';
        } else {
            $overall_result = 'Satisfactory';
        }
        
        $recommendations = $_POST['recommendations'];
        $auditor_signature = $_POST['auditor_signature'];
        $supervisor_signature = $_POST['supervisor_signature'];
        
        // Query untuk insert data
        $sql = "INSERT INTO product_audits (
                    audit_date, auditor, product_name, version,
                    apd_teknis, kondisi_komputer, kebersihan_meja,
                    rambu_k3, apar_elektronik, pencahayaan,
                    ventilasi, kabel, evakuasi, pelatihan_k3,
                    overall_result, recommendations, 
                    auditor_signature, supervisor_signature
                ) VALUES (
                    :audit_date, :auditor, :product_name, :version,
                    :apd_teknis, :kondisi_komputer, :kebersihan_meja,
                    :rambu_k3, :apar_elektronik, :pencahayaan,
                    :ventilasi, :kabel, :evakuasi, :pelatihan_k3,
                    :overall_result, :recommendations,
                    :auditor_signature, :supervisor_signature
                )";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind parameter
        $stmt->bindParam(':audit_date', $audit_date);
        $stmt->bindParam(':auditor', $auditor);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':apd_teknis', $apd_teknis);
        $stmt->bindParam(':kondisi_komputer', $kondisi_komputer);
        $stmt->bindParam(':kebersihan_meja', $kebersihan_meja);
        $stmt->bindParam(':rambu_k3', $rambu_k3);
        $stmt->bindParam(':apar_elektronik', $apar_elektronik);
        $stmt->bindParam(':pencahayaan', $pencahayaan);
        $stmt->bindParam(':ventilasi', $ventilasi);
        $stmt->bindParam(':kabel', $kabel);
        $stmt->bindParam(':evakuasi', $evakuasi);
        $stmt->bindParam(':pelatihan_k3', $pelatihan_k3);
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