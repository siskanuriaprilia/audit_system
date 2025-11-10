<?php
// index.php
// Dashboard Sistem Manajemen K3 Lab Komputer
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard K3 Lab Komputer - Sistem Manajemen Keselamatan & Kesehatan Kerja</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .k3-dashboard-header {
            background: linear-gradient(135deg, #f59e0b 0%, #dc2626 50%, #b91c1c 100%);
            padding: 50px 40px;
            border-radius: 24px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 15px 50px rgba(220, 38, 38, 0.4);
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
        
       
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .k3-dashboard-header h1 {
            font-size: 2.8em;
            margin-bottom: 15px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .k3-dashboard-header .tagline {
            font-size: 1.3em;
            opacity: 0.95;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .safety-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 25px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        
        .safety-stat-item {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .safety-stat-item .number {
            font-size: 2em;
            font-weight: 700;
            display: block;
        }
        
        .safety-stat-item .label {
            font-size: 0.9em;
            opacity: 0.9;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .menu-card {
            background: white;
            padding: 35px;
            border-radius: 20px;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
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
        
        .menu-card:nth-child(1) { animation-delay: 0.1s; }
        .menu-card:nth-child(2) { animation-delay: 0.2s; }
        .menu-card:nth-child(3) { animation-delay: 0.3s; }
        
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        
        .menu-card:hover::before {
            left: 100%;
        }
        
        .menu-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        
        .menu-card.danger:hover {
            border-color: #dc2626;
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.3);
        }
        
        .menu-card.success:hover {
            border-color: #10b981;
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.3);
        }
        
        .menu-card.info:hover {
            border-color: #3b82f6;
            box-shadow: 0 20px 50px rgba(59, 130, 246, 0.3);
        }
        
        .menu-icon {
            font-size: 4em;
            margin-bottom: 20px;
            display: block;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .menu-card h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #1f2937;
        }
        
        .menu-card p {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .menu-card .arrow {
            color: #dc2626;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.3s;
        }
        
        .menu-card:hover .arrow {
            gap: 10px;
        }
        
        .info-panels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .info-panel {
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
            padding: 25px;
            border-radius: 16px;
            border-left: 5px solid #f59e0b;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            animation: slideInLeft 0.8s ease-out;
        }
        
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
        
        .info-panel h4 {
            color: #dc2626;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2em;
        }
        
        .info-panel ul {
            list-style: none;
            padding-left: 0;
        }
        
        .info-panel li {
            padding: 10px 0;
            padding-left: 25px;
            position: relative;
            color: #4b5563;
        }
        
        .info-panel li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: 700;
        }
        
        .emergency-banner {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 20px 25px;
            border-radius: 16px;
            border-left: 5px solid #f59e0b;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: warning-pulse 2s ease-in-out infinite;
        }
        
        @keyframes warning-pulse {
            0%, 100% { box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2); }
            50% { box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4); }
        }
        
        .emergency-banner .icon {
            font-size: 2.5em;
        }
        
        .emergency-banner .content h4 {
            color: #92400e;
            margin-bottom: 5px;
            font-size: 1.2em;
        }
        
        .emergency-banner .content p {
            color: #78350f;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="k3-dashboard-header">
            <h1>💻 SISTEM MANAJEMEN K3 LAB KOMPUTER</h1>
            <p class="tagline">Keselamatan & Kesehatan Kerja - Laboratorium Komputer & Perangkat Elektronik</p>
            <div class="safety-stats">
                <div class="safety-stat-item">
                    <span class="number">0</span>
                    <span class="label">Hari Tanpa Insiden</span>
                </div>
                <div class="safety-stat-item">
                    <span class="number">100%</span>
                    <span class="label">Target Keselamatan Lab</span>
                </div>
                <div class="safety-stat-item">
                    <span class="number">24/7</span>
                    <span class="label">Monitoring Lab</span>
                </div>
            </div>
        </div>
        
        <div class="emergency-banner">
            <div class="icon">⚠️</div>
            <div class="content">
                <h4>Nomor Darurat Lab Komputer</h4>
                <p><strong>IT Support & Emergency:</strong> 0800-LAB-EMERGENCY | Internal: 119 | Helpdesk: ext.333</p>
            </div>
        </div>
        
        <div class="menu-grid">
            <a href="add_audit.php" class="menu-card danger">
                <span class="menu-icon">📋</span>
                <h3>Audit K3 Lab Baru</h3>
                <p>Lakukan inspeksi keselamatan lab komputer: APD teknis, kondisi perangkat, penataan kabel, dan sistem proteksi kebakaran elektronik.</p>
                <span class="arrow">Mulai Audit →</span>
            </a>
            
            <a href="view_data.php" class="menu-card success">
                <span class="menu-icon">📊</span>
                <h3>Data Audit K3 Lab</h3>
                <p>Lihat riwayat audit keselamatan lab komputer, temuan pelanggaran K3, dan status tindak lanjut perbaikan.</p>
                <span class="arrow">Lihat Data →</span>
            </a>
            
            <a href="statistics.php" class="menu-card info">
                <span class="menu-icon">📈</span>
                <h3>Statistik & Laporan Lab</h3>
                <p>Dashboard analitik keselamatan lab komputer, trend pelanggaran K3, dan performa keselamatan laboratorium.</p>
                <span class="arrow">Lihat Statistik →</span>
            </a>
        </div>
        
        <div class="info-panels">
            <div class="info-panel">
                <h4>🎯 Tujuan K3 Lab Komputer</h4>
                <ul>
                    <li>Mencegah insiden kelistrikan dan overheating perangkat</li>
                    <li>Menciptakan lingkungan lab yang aman dan ergonomis</li>
                    <li>Meningkatkan produktivitas melalui keselamatan kerja</li>
                    <li>Memastikan kepatuhan SOP penggunaan lab komputer</li>
                </ul>
            </div>
            
            <div class="info-panel">
                <h4>✅ Area Audit K3 Lab Komputer</h4>
                <ul>
                    <li>Penggunaan APD teknis (sarung tangan anti-statis, ESD)</li>
                    <li>Kondisi komputer, server, UPS, dan perangkat jaringan</li>
                    <li>Kebersihan meja kerja dan area lab</li>
                    <li>Penataan kabel listrik dan data (cable management)</li>
                    <li>Sistem proteksi kebakaran (APAR CO₂/dry chemical)</li>
                    <li>Pencahayaan, ventilasi, dan jalur evakuasi</li>
                </ul>
            </div>
            
            <div class="info-panel">
                <h4>📚 Standar & Regulasi Lab</h4>
                <ul>
                    <li>UU No. 1 Tahun 1970 tentang Keselamatan Kerja</li>
                    <li>PP No. 50 Tahun 2012 tentang SMK3</li>
                    <li>Permenaker tentang Keselamatan Instalasi Listrik</li>
                    <li>ISO/IEC 17025 - Kompetensi Lab Pengujian</li>
                    <li>NFPA 75 - Protection of IT Equipment</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        // Animate counter on page load
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 30);
        }
        
        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.menu-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Animate safety stats if needed
            const statNumbers = document.querySelectorAll('.safety-stat-item .number');
            statNumbers.forEach(stat => {
                const text = stat.textContent;
                if (text.includes('%')) {
                    const num = parseInt(text);
                    if (!isNaN(num)) {
                        stat.textContent = '0%';
                        animateCounter(stat, num);
                        setTimeout(() => {
                            stat.textContent = text;
                        }, 1500);
                    }
                }
            });
        });
        
        // Add ripple effect to cards
        const menuCards = document.querySelectorAll('.menu-card');
        menuCards.forEach(card => {
            card.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = card.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                ripple.style.pointerEvents = 'none';
                
                card.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });
        
        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>