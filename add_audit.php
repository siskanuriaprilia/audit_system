<?php
// add_audit.php
// Form untuk audit K3 (Keselamatan dan Kesehatan Kerja)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit K3 - Sistem Manajemen Keselamatan & Kesehatan Kerja</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* K3 Safety Theme Animations */
        @keyframes safety-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes warning-blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        
        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .k3-header {
            background: linear-gradient(135deg, #f59e0b 0%, #dc2626 50%, #b91c1c 100%);
            padding: 30px;
            border-radius: 20px;
            color: white;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(220, 38, 38, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .k3-header::before {
            content: '⚠️';
            position: absolute;
            font-size: 150px;
            opacity: 0.1;
            top: -20px;
            right: -20px;
            animation: safety-pulse 3s ease-in-out infinite;
        }
        
        .k3-header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .k3-header .subtitle {
            font-size: 1.1em;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        
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
        
        .audit-form {
            animation: slide-in-left 0.6s ease-out;
        }
        
        .question-group {
            border-left: 4px solid #dc2626;
            transition: all 0.3s ease;
        }
        
        .question-group:hover {
            border-left-color: #f59e0b;
            transform: translateX(10px);
        }
        
        .question-group.critical {
            border-left: 4px solid #dc2626;
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
        }
        
        .radio-group label {
            position: relative;
        }
        
        .radio-group label:has(input[value="Satisfactory"]):hover {
            border-color: #10b981;
            background: #f0fdf4;
        }
        
        .radio-group label:has(input[value="Needs Improvement"]):hover {
            border-color: #f59e0b;
            background: #fffbeb;
        }
        
        .radio-group label:has(input[value="Unsatisfactory"]):hover {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        .radio-group input[type="radio"]:checked + span.status-safe {
            color: #10b981;
            font-weight: 600;
        }
        
        .radio-group input[type="radio"]:checked + span.status-warning {
            color: #f59e0b;
            font-weight: 600;
        }
        
        .radio-group input[type="radio"]:checked + span.status-danger {
            color: #ef4444;
            font-weight: 600;
        }
        
        .k3-section {
            background: white;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 20px;
            border-left: 5px solid #f59e0b;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .k3-section h3 {
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 1.3em;
        }
        
        .safety-icon {
            font-size: 1.5em;
            animation: safety-pulse 2s ease-in-out infinite;
        }
        
        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .info-box .icon {
            font-size: 1.8em;
        }
        
        .form-actions {
            animation: slide-in-left 0.8s ease-out;
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

        
        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::after {
            content: '✓';
            position: absolute;
            right: 15px;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover::after {
            opacity: 1;
            right: 20px;
        }
        
        .progress-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b 0%, #dc2626 100%);
            z-index: 9999;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="progress-indicator" id="progressBar"></div>
    
    <div class="container">
        <a href="index.php" class="btn-back">Kembali ke Dashboard K3</a>
        
        <div class="k3-header">
            <h1>⚠️ AUDIT KESELAMATAN & KESEHATAN KERJA (K3)</h1>
            <p class="subtitle">Sistem Manajemen K3 - Checklist Inspeksi Keselamatan</p>
            <div class="safety-badge">
                <span>🛡️</span>
                <span>Safety First - Zero Accident</span>
            </div>
        </div>
        
        <div class="info-box">
            <div class="icon">ℹ️</div>
            <div>
                <strong>Petunjuk Pengisian:</strong> Lengkapi seluruh checklist audit K3 dengan teliti. Pastikan semua aspek keselamatan kerja dinilai sesuai standar SMK3.
            </div>
        </div>
        
        <form action="process_audit.php" method="POST" class="audit-form" id="auditForm">
            <!-- Informasi Audit -->
            <div class="k3-section">
                <h3><span class="safety-icon">📋</span> Informasi Audit</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="audit_date">📅 Tanggal Audit</label>
                        <input type="date" id="audit_date" name="audit_date" required>
                    </div>
                    <div class="form-group">
                        <label for="auditor">👤 Nama Auditor</label>
                        <input type="text" id="auditor" name="auditor" placeholder="Nama lengkap auditor" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="product_name">🏢 Lokasi/Area Kerja</label>
                        <input type="text" id="product_name" name="product_name" placeholder="Contoh: Workshop Produksi Lt.2" required>
                    </div>
                    <div class="form-group">
                        <label for="version">🔖 Kode Audit</label>
                        <input type="text" id="version" name="version" placeholder="Contoh: K3-2024-001" required>
                    </div>
                </div>
            </div>
            
            <!-- Checklist K3 -->
<!-- Checklist K3 -->
<div class="k3-section">
    <h3><span class="safety-icon">🦺</span> Checklist Keselamatan Kerja</h3>

    <!-- 1. APD -->
    <div class="question-group critical">
        <label class="question">1. Alat Pelindung Diri (APD) - Apakah semua pekerja menggunakan APD lengkap?</label>
        <div class="radio-group">
            <label><input type="radio" name="apd" value="Satisfactory" required> <span class="status-safe">✓ Aman</span></label>
            <label><input type="radio" name="apd" value="Needs Improvement"> <span class="status-warning">⚠️ Perlu Perbaikan</span></label>
            <label><input type="radio" name="apd" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Aman</span></label>
        </div>
    </div>

    <!-- 2. Kondisi Mesin -->
    <div class="question-group critical">
        <label class="question">2. Kondisi Mesin & Peralatan - Apakah mesin dalam kondisi aman dan terawat?</label>
        <div class="radio-group">
            <label><input type="radio" name="mesin" value="Satisfactory" required> <span class="status-safe">✓ Aman</span></label>
            <label><input type="radio" name="mesin" value="Needs Improvement"> <span class="status-warning">⚠️ Perlu Perbaikan</span></label>
            <label><input type="radio" name="mesin" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Aman</span></label>
        </div>
    </div>

    <!-- 3. Kebersihan Area -->
    <div class="question-group">
        <label class="question">3. Kebersihan Area - Apakah area kerja bersih dan tertata?</label>
        <div class="radio-group">
            <label><input type="radio" name="kebersihan" value="Satisfactory" required> <span class="status-safe">✓ Baik</span></label>
            <label><input type="radio" name="kebersihan" value="Needs Improvement"> <span class="status-warning">⚠️ Kurang Rapi</span></label>
            <label><input type="radio" name="kebersihan" value="Unsatisfactory"> <span class="status-danger">✗ Buruk</span></label>
        </div>
    </div>

    <!-- 4. Rambu K3 -->
    <div class="question-group">
        <label class="question">4. Rambu & Signage - Apakah rambu K3 jelas dan lengkap?</label>
        <div class="radio-group">
            <label><input type="radio" name="rambu" value="Satisfactory" required> <span class="status-safe">✓ Lengkap</span></label>
            <label><input type="radio" name="rambu" value="Needs Improvement"> <span class="status-warning">⚠️ Perlu Diperbaiki</span></label>
            <label><input type="radio" name="rambu" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Lengkap</span></label>
        </div>
    </div>

    <!-- 5. Proteksi Kebakaran -->
    <div class="question-group critical">
        <label class="question">5. Proteksi Kebakaran - Apakah APAR, hydrant, dan alarm berfungsi baik?</label>
        <div class="radio-group">
            <label><input type="radio" name="proteksi" value="Satisfactory" required> <span class="status-safe">✓ Siap</span></label>
            <label><input type="radio" name="proteksi" value="Needs Improvement"> <span class="status-warning">⚠️ Maintenance</span></label>
            <label><input type="radio" name="proteksi" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Berfungsi</span></label>
        </div>
    </div>

    <!-- 6. Pencahayaan -->
    <div class="question-group">
        <label class="question">6. Pencahayaan - Apakah pencahayaan cukup dan tidak berbahaya bagi penglihatan?</label>
        <div class="radio-group">
            <label><input type="radio" name="pencahayaan" value="Satisfactory" required> <span class="status-safe">✓ Baik</span></label>
            <label><input type="radio" name="pencahayaan" value="Needs Improvement"> <span class="status-warning">⚠️ Kurang Terang</span></label>
            <label><input type="radio" name="pencahayaan" value="Unsatisfactory"> <span class="status-danger">✗ Buruk</span></label>
        </div>
    </div>

    <!-- 7. Ventilasi -->
    <div class="question-group">
        <label class="question">7. Ventilasi - Apakah sirkulasi udara di area kerja baik?</label>
        <div class="radio-group">
            <label><input type="radio" name="ventilasi" value="Satisfactory" required> <span class="status-safe">✓ Lancar</span></label>
            <label><input type="radio" name="ventilasi" value="Needs Improvement"> <span class="status-warning">⚠️ Kurang Lancar</span></label>
            <label><input type="radio" name="ventilasi" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Ada</span></label>
        </div>
    </div>

    <!-- 8. Posisi Kabel -->
    <div class="question-group">
        <label class="question">8. Penataan Kabel & Listrik - Apakah kabel listrik aman dan tertata rapi?</label>
        <div class="radio-group">
            <label><input type="radio" name="kabel" value="Satisfactory" required> <span class="status-safe">✓ Aman</span></label>
            <label><input type="radio" name="kabel" value="Needs Improvement"> <span class="status-warning">⚠️ Perlu Diperbaiki</span></label>
            <label><input type="radio" name="kabel" value="Unsatisfactory"> <span class="status-danger">✗ Berbahaya</span></label>
        </div>
    </div>

    <!-- 9. Jalur Evakuasi -->
    <div class="question-group">
        <label class="question">9. Jalur Evakuasi - Apakah jalur evakuasi bebas hambatan dan terlihat jelas?</label>
        <div class="radio-group">
            <label><input type="radio" name="evakuasi" value="Satisfactory" required> <span class="status-safe">✓ Siap Digunakan</span></label>
            <label><input type="radio" name="evakuasi" value="Needs Improvement"> <span class="status-warning">⚠️ Sebagian Terhalang</span></label>
            <label><input type="radio" name="evakuasi" value="Unsatisfactory"> <span class="status-danger">✗ Tidak Terlihat</span></label>
        </div>
    </div>

    <!-- 10. Pelatihan K3 -->
    <div class="question-group">
        <label class="question">10. Pelatihan K3 - Apakah pekerja mendapatkan pelatihan keselamatan kerja secara rutin?</label>
        <div class="radio-group">
            <label><input type="radio" name="pelatihan" value="Satisfactory" required> <span class="status-safe">✓ Rutin</span></label>
            <label><input type="radio" name="pelatihan" value="Needs Improvement"> <span class="status-warning">⚠️ Tidak Semua</span></label>
            <label><input type="radio" name="pelatihan" value="Unsatisfactory"> <span class="status-danger">✗ Belum Pernah</span></label>
        </div>
    </div>
</div>            
            <!-- Rekomendasi -->
            <div class="k3-section">
                <h3><span class="safety-icon">📝</span> Rekomendasi Perbaikan & Tindak Lanjut</h3>
                <div class="form-group full-width">
                    <label for="recommendations">💡 Catatan, Temuan, dan Rekomendasi Perbaikan</label>
                    <textarea id="recommendations" name="recommendations" rows="5" placeholder="Tuliskan temuan pelanggaran K3, potensi bahaya, dan rekomendasi perbaikan yang perlu dilakukan...

Contoh:
- Ditemukan 2 pekerja tidak menggunakan safety helmet
- APAR di area welding sudah expired (bulan lalu)
- Rekomendasi: Penggantian APAR segera dan briefing penggunaan APD" required></textarea>
                </div>
            </div>
            
            <!-- Tanda Tangan -->
            <div class="k3-section">
                <h3><span class="safety-icon">✍️</span> Pengesahan Audit</h3>
                <div class="signature-section">
                    <div class="form-group">
                        <label for="auditor_signature">👤 Auditor K3</label>
                        <input type="text" id="auditor_signature" name="auditor_signature" placeholder="Nama auditor" required>
                    </div>
                    <div class="form-group">
                        <label for="supervisor_signature">👨‍💼 Supervisor/Manager K3</label>
                        <input type="text" id="supervisor_signature" name="supervisor_signature" placeholder="Nama supervisor" required>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Hasil Audit K3</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
    
    <script>
        // Progress bar animation
        const form = document.getElementById('auditForm');
        const progressBar = document.getElementById('progressBar');
        
        // Update progress on scroll
        window.addEventListener('scroll', () => {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight - windowHeight;
            const scrolled = window.scrollY;
            const progress = (scrolled / documentHeight) * 100;
            progressBar.style.width = progress + '%';
        });
        
        // Add smooth animations to radio buttons
        const radioLabels = document.querySelectorAll('.radio-group label');
        radioLabels.forEach(label => {
            label.addEventListener('click', function() {
                // Remove animation from siblings
                const siblings = this.parentElement.querySelectorAll('label');
                siblings.forEach(sib => sib.style.animation = 'none');
                
                // Add animation to clicked
                this.style.animation = 'safety-pulse 0.5s ease-in-out';
                setTimeout(() => {
                    this.style.animation = '';
                }, 500);
            });
        });
        
        // Form validation with animation
        form.addEventListener('submit', function(e) {
            const allFilled = form.checkValidity();
            if (!allFilled) {
                e.preventDefault();
                // Scroll to first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
            }
        });
        
        // Auto-save draft (localStorage)
        const formInputs = form.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            // Load saved data
            const savedValue = localStorage.getItem('k3_' + input.name);
            if (savedValue && input.type !== 'radio') {
                input.value = savedValue;
            }
            if (savedValue && input.type === 'radio' && input.value === savedValue) {
                input.checked = true;
            }
            
            // Save on change
            input.addEventListener('change', () => {
                localStorage.setItem('k3_' + input.name, input.value);
            });
        });
        
        // Clear localStorage on successful submit
        form.addEventListener('submit', function() {
            if (form.checkValidity()) {
                formInputs.forEach(input => {
                    localStorage.removeItem('k3_' + input.name);
                });
            }
        });
    </script>
</body>
</html>