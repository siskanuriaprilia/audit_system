<?php
// view_data.php
// Halaman untuk melihat semua data audit K3

require_once 'config/database.php';

// Ambil semua data audit, urutkan dari yang terbaru
$sql = "SELECT * FROM product_audits ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$audits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Audit K3 - Sistem Manajemen Keselamatan & Kesehatan Kerja</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        @keyframes safety-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes warning-blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        
        .page-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            padding: 50px 40px;
            border-radius: 24px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 15px 50px rgba(16, 185, 129, 0.4);
            position: relative;
            overflow: hidden;
            animation: slideDown 0.6s ease-out;
        }
        
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .page-header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .page-header p {
            font-size: 1.2em;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        
        /* Safety Badge - BARU */
        .safety-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 30px;
            margin-top: 15px;
            backdrop-filter: blur(10px);
            animation: warning-blink 2s ease-in-out infinite;
        }
        
        .btn-back {
            position: sticky;
            top: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            z-index: 1000;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .alert {
            padding: 20px 25px;
            border-radius: 16px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideInRight 0.6s ease-out;
            font-weight: 500;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 5px solid #10b981;
            color: #065f46;
        }
        
        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }
        
        .data-count {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            color: #374151;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .table-responsive {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow-x: auto;
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }
        
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .data-table thead {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
        }
        
        .data-table th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: 0.5px;
        }
        
        .data-table thead tr th:first-child {
            border-top-left-radius: 12px;
        }
        
        .data-table thead tr th:last-child {
            border-top-right-radius: 12px;
        }
        
        .data-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            animation: fadeInUp 0.4s ease-out both;
        }
        
        .data-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .data-table tbody tr:nth-child(2) { animation-delay: 0.15s; }
        .data-table tbody tr:nth-child(3) { animation-delay: 0.2s; }
        .data-table tbody tr:nth-child(4) { animation-delay: 0.25s; }
        .data-table tbody tr:nth-child(5) { animation-delay: 0.3s; }
        
        .data-table tbody tr:hover {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .data-table td {
            padding: 16px 15px;
            color: #374151;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-satisfactory {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
        }
        
        .badge-needs-improvement {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        }
        
        .badge-unsatisfactory {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        
        .no-data {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }
        
        .no-data p {
            font-size: 1.2em;
            color: #6b7280;
            margin: 0;
        }
        
        .no-data a {
            color: #dc2626;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid #dc2626;
        }
        
        .no-data a:hover {
            color: #b91c1c;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 40px;
            border-radius: 24px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: slideInDown 0.4s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .close {
            color: #9ca3af;
            float: right;
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .close:hover {
            color: #dc2626;
            transform: rotate(90deg);
        }
        
        .modal-content h2 {
            color: #1f2937;
            margin-bottom: 30px;
            font-size: 2em;
        }
        
        .detail-grid {
            display: grid;
            gap: 20px;
        }
        
        .detail-item {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 15px;
            background: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid #10b981;
        }
        
        .detail-item strong {
            color: #374151;
        }
        
        .detail-item span {
            color: #1f2937;
            font-weight: 500;
        }
        
        .detail-section {
            padding: 20px;
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
            border-radius: 16px;
            border-left: 5px solid #dc2626;
            margin-top: 10px;
        }
        
        .detail-section h3 {
            color: #dc2626;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .detail-section ul {
            list-style: none;
            padding: 0;
        }
        
        .detail-section li {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
        }
        
        .detail-section li:last-child {
            border-bottom: none;
        }
        
        .detail-section li strong {
            color: #dc2626;
        }
        
        .detail-signatures {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .detail-signatures > div {
            padding: 15px;
            background: #f3f4f6;
            border-radius: 12px;
            text-align: center;
        }
        
        .detail-signatures strong {
            display: block;
            margin-bottom: 8px;
            color: #374151;
        }
        
        @media (max-width: 768px) {
            .table-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .detail-item {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .modal-content {
                margin: 10% auto;
                padding: 25px;
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn-back">Kembali ke Dashboard</a>
        
        <div class="page-header">
            <h1>📊 Data Audit K3</h1>
            <p>Riwayat Inspeksi Keselamatan & Kesehatan Kerja</p>
            <div class="safety-badge">
                <span>🛡️</span>
                <span>Safety Data Management</span>
            </div>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            ✓ Data audit berhasil disimpan!
        </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">
            ✓ Data audit berhasil dihapus!
        </div>
        <?php endif; ?>
        
        <div class="table-actions">
            <span class="data-count">📋 Total Data: <?= count($audits) ?></span>
        </div>
        
        <?php if (count($audits) > 0): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Audit</th>
                        <th>Auditor</th>
                        <th>Area/Lokasi</th>
                        <th>Versi</th>
                        <th>Status Keselamatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($audits as $audit): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($audit['audit_date'])) ?></td>
                        <td><?= htmlspecialchars($audit['auditor']) ?></td>
                        <td><?= htmlspecialchars($audit['product_name']) ?></td>
                        <td><?= htmlspecialchars($audit['version']) ?></td>
                        <td>
                            <span class="badge badge-<?= strtolower(str_replace(' ', '-', $audit['overall_result'])) ?>">
                                <?= $audit['overall_result'] ?>
                            </span>
                        </td>
                        <td class="action-buttons">
                            <button onclick="viewDetail(<?= $audit['id'] ?>)" class="btn-action btn-view">Detail</button>
                            <a href="delete_audit.php?id=<?= $audit['id'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus data audit ini?')"
                               class="btn-action btn-delete">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="no-data">
            <p>📋 Belum ada data audit K3. <a href="add_audit.php">Tambah audit pertama</a></p>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal untuk detail -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>📋 Detail Audit K3</h2>
            <div id="detailContent"></div>
        </div>
    </div>
    
    <script>
    function viewDetail(id) {
        fetch('get_detail.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const audit = data.audit;
                    const html = `
                        <div class="detail-grid">
                            <div class="detail-item">
                                <strong>Tanggal Audit:</strong>
                                <span>${new Date(audit.audit_date).toLocaleDateString('id-ID')}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Auditor:</strong>
                                <span>${audit.auditor}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Area/Lokasi:</strong>
                                <span>${audit.product_name}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Versi Audit:</strong>
                                <span>${audit.version}</span>
                            </div>
                            <div class="detail-section">
                                <h3>🎯 Hasil Inspeksi K3:</h3>
                                <ul>
                                    <li><span>Penampilan & Kemasan APD</span> <strong>${audit.appearance_packaging}</strong></li>
                                    <li><span>Fungsi Peralatan</span> <strong>${audit.product_function}</strong></li>
                                    <li><span>Kualitas Material</span> <strong>${audit.material_quality}</strong></li>
                                    <li><span>Dimensi & Spesifikasi</span> <strong>${audit.dimensions_specs}</strong></li>
                                    <li><span>Kepatuhan Dimensi</span> <strong>${audit.dimensions_compliance}</strong></li>
                                    <li><span>Status Keselamatan</span> <strong>${audit.overall_result}</strong></li>
                                </ul>
                            </div>
                            ${audit.recommendations ? `
                            <div class="detail-section">
                                <h3>💡 Rekomendasi Perbaikan:</h3>
                                <p>${audit.recommendations}</p>
                            </div>
                            ` : ''}
                            <div class="detail-signatures">
                                <div>
                                    <strong>✍️ Tanda Tangan Auditor:</strong>
                                    <span>${audit.auditor_signature || '-'}</span>
                                </div>
                                <div>
                                    <strong>✍️ Tanda Tangan Supervisor:</strong>
                                    <span>${audit.supervisor_signature || '-'}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('detailContent').innerHTML = html;
                    document.getElementById('detailModal').style.display = 'block';
                }
            });
    }
    
    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    
    // Add entrance animation to table rows
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach((row, index) => {
            if (index > 5) {
                row.style.animationDelay = '0.3s';
            }
        });
    });
    </script>
</body>
</html>