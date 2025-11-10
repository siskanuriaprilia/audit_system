<?php
// statistics.php
// Halaman untuk menampilkan statistik audit K3

require_once 'config/database.php';

// Hitung total audit
$total = $pdo->query("SELECT COUNT(*) FROM product_audits")->fetchColumn();

// Statistik berdasarkan overall result
$stats_sql = "SELECT overall_result, COUNT(*) as count 
              FROM product_audits 
              GROUP BY overall_result";
$stats = $pdo->query($stats_sql)->fetchAll();

// Statistik per kategori
$categories = [
    'appearance_packaging' => 'Penampilan & Kemasan APD',
    'product_function' => 'Fungsi Peralatan',
    'material_quality' => 'Kualitas Material',
    'dimensions_specs' => 'Dimensi & Spesifikasi',
    'dimensions_compliance' => 'Kepatuhan Dimensi'
];

$category_stats = [];
foreach ($categories as $key => $label) {
    $sql = "SELECT $key as result, COUNT(*) as count 
            FROM product_audits 
            GROUP BY $key";
    $category_stats[$key] = [
        'label' => $label,
        'data' => $pdo->query($sql)->fetchAll()
    ];
}

// Audit terbaru
$recent_sql = "SELECT * FROM product_audits ORDER BY created_at DESC LIMIT 5";
$recent_audits = $pdo->query($recent_sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik K3 - Sistem Manajemen Keselamatan & Kesehatan Kerja</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* K3 Safety Theme Animations - SAMA SEPERTI add_audit.php */
        @keyframes safety-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes warning-blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        
        .page-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            padding: 50px 40px;
            border-radius: 24px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 15px 50px rgba(59, 130, 246, 0.4);
            position: relative;
            overflow: hidden;
            animation: slideDown 0.6s ease-out;
        }
        
        /* Animasi icon background yang berputar - BARU */
        .page-header::before {
            content: '📈';
            position: absolute;
            font-size: 150px;
            opacity: 0.1;
            top: -20px;
            right: -20px;
            animation: safety-pulse 3s ease-in-out infinite;
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
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out both;
            border: 2px solid transparent;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }
        
        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .stat-card.stat-success {
            border-color: #10b981;
        }
        
        .stat-card.stat-success:hover {
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.3);
        }
        
        .stat-card.stat-warning {
            border-color: #f59e0b;
        }
        
        .stat-card.stat-warning:hover {
            box-shadow: 0 20px 50px rgba(245, 158, 11, 0.3);
        }
        
        .stat-card.stat-danger {
            border-color: #dc2626;
        }
        
        .stat-card.stat-danger:hover {
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.3);
        }
        
        .stat-icon {
            font-size: 3.5em;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .stat-info h3 {
            font-size: 1em;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            line-height: 1;
        }
        
        .stats-charts {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            animation: fadeInUp 0.6s ease-out 0.5s both;
        }
        
        .stats-charts h2 {
            color: #1f2937;
            margin-bottom: 30px;
            font-size: 2em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chart-section {
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
            border-radius: 16px;
            border-left: 5px solid #3b82f6;
            animation: slideInLeft 0.8s ease-out both;
        }
        
        .chart-section:nth-child(2) { animation-delay: 0.1s; }
        .chart-section:nth-child(3) { animation-delay: 0.2s; }
        .chart-section:nth-child(4) { animation-delay: 0.3s; }
        .chart-section:nth-child(5) { animation-delay: 0.4s; }
        .chart-section:nth-child(6) { animation-delay: 0.5s; }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .chart-section h3 {
            color: #3b82f6;
            margin-bottom: 20px;
            font-size: 1.3em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .bar-chart {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .bar-item {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 15px;
            align-items: center;
        }
        
        .bar-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.95em;
        }
        
        .bar-container {
            background: #e5e7eb;
            border-radius: 10px;
            height: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .bar {
            height: 100%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            transition: width 1s ease-out;
            position: relative;
            overflow: hidden;
        }
        
        .bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .bar-satisfactory {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .bar-needs-improvement {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .bar-unsatisfactory {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }
        
        .bar-value {
            color: white;
            font-weight: 700;
            font-size: 0.9em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }
        
        .recent-audits {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }
        
        .recent-audits h2 {
            color: #1f2937;
            margin-bottom: 30px;
            font-size: 2em;
            display: flex;
            align-items: center;
            gap: 10px;
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
        }
        
        .data-table tbody tr:hover {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            transform: scale(1.01);
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
        
        @media (max-width: 768px) {
            .bar-item {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .bar-label {
                font-size: 0.9em;
            }
            
            .stats-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn-back">Kembali ke Dashboard</a>
        
        <div class="page-header">
            <h1>📈 Statistik & Analitik K3</h1>
            <p>Dashboard Performa Keselamatan & Kesehatan Kerja</p>
            <div class="safety-badge">
                <span>🛡️</span>
                <span>Safety Monitoring - Zero Accident Goal</span>
            </div>
        </div>
        
        <div class="stats-summary">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-info">
                    <h3>Total Audit</h3>
                    <p class="stat-number"><?= $total ?></p>
                </div>
            </div>
            
            <?php
            $satisfactory = 0;
            $needs_improvement = 0;
            $unsatisfactory = 0;
            
            foreach ($stats as $stat) {
                switch ($stat['overall_result']) {
                    case 'Satisfactory':
                        $satisfactory = $stat['count'];
                        break;
                    case 'Needs Improvement':
                        $needs_improvement = $stat['count'];
                        break;
                    case 'Unsatisfactory':
                        $unsatisfactory = $stat['count'];
                        break;
                }
            }
            ?>
            
            <div class="stat-card stat-success">
                <div class="stat-icon">✅</div>
                <div class="stat-info">
                    <h3>Aman (Satisfactory)</h3>
                    <p class="stat-number"><?= $satisfactory ?></p>
                </div>
            </div>
            
            <div class="stat-card stat-warning">
                <div class="stat-icon">⚠️</div>
                <div class="stat-info">
                    <h3>Perlu Perbaikan</h3>
                    <p class="stat-number"><?= $needs_improvement ?></p>
                </div>
            </div>
            
            <div class="stat-card stat-danger">
                <div class="stat-icon">❌</div>
                <div class="stat-info">
                    <h3>Tidak Aman</h3>
                    <p class="stat-number"><?= $unsatisfactory ?></p>
                </div>
            </div>
        </div>
        
        <div class="stats-charts">
            <h2>📊 Statistik Per Kategori K3</h2>
            
            <?php foreach ($category_stats as $key => $category): ?>
            <div class="chart-section">
                <h3>🎯 <?= $category['label'] ?></h3>
                <div class="bar-chart">
                    <?php 
                    $total_cat = array_sum(array_column($category['data'], 'count'));
                    foreach ($category['data'] as $item): 
                        $percentage = $total_cat > 0 ? ($item['count'] / $total_cat) * 100 : 0;
                        $class = strtolower(str_replace(' ', '-', $item['result']));
                    ?>
                    <div class="bar-item">
                        <div class="bar-label"><?= $item['result'] ?></div>
                        <div class="bar-container">
                            <div class="bar bar-<?= $class ?>" style="width: <?= $percentage ?>%">
                                <span class="bar-value"><?= $item['count'] ?> audit (<?= number_format($percentage, 1) ?>%)</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="recent-audits">
            <h2>🕐 5 Audit Terbaru</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Area/Lokasi</th>
                        <th>Auditor</th>
                        <th>Status Keselamatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_audits as $audit): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($audit['audit_date'])) ?></td>
                        <td><?= htmlspecialchars($audit['product_name']) ?></td>
                        <td><?= htmlspecialchars($audit['auditor']) ?></td>
                        <td>
                            <span class="badge badge-<?= strtolower(str_replace(' ', '-', $audit['overall_result'])) ?>">
                                <?= $audit['overall_result'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        // Animate bars on page load
        document.addEventListener('DOMContentLoaded', function() {
            const bars = document.querySelectorAll('.bar');
            
            // Initially set bars to 0 width
            bars.forEach(bar => {
                const targetWidth = bar.style.width;
                bar.style.width = '0%';
                
                // Animate to target width after a short delay
                setTimeout(() => {
                    bar.style.width = targetWidth;
                }, 100);
            });
            
            // Animate stat numbers
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const target = parseInt(stat.textContent);
                if (!isNaN(target)) {
                    let current = 0;
                    const increment = target / 30;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = target;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current);
                        }
                    }, 30);
                }
            });
        });
    </script>
</body>
</html>