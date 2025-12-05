<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - MyApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .email-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }

        .email-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .email-card:hover {
            transform: translateY(-5px);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .logo-icon {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            line-height: 50px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .message {
            color: #718096;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .otp-container {
            background: linear-gradient(135deg, #f6f9ff 0%, #edf2ff 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 1px solid #e2e8f0;
        }

        .otp-label {
            color: #667eea;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            display: block;
        }

        .otp-code {
            font-size: 42px;
            font-weight: 700;
            color: #2d3748;
            letter-spacing: 8px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: inline-block;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            border: 2px dashed #c3dafe;
        }

        .warning {
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            padding: 15px;
            border-radius: 8px;
            margin: 25px 0;
            color: #c53030;
            font-size: 14px;
        }

        .warning-icon {
            color: #fc8181;
            margin-right: 8px;
        }

        .info-box {
            background: #f0fff4;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            border: 1px solid #c6f6d5;
        }

        .info-title {
            color: #276749;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .info-title::before {
            content: "ℹ️";
            margin-right: 10px;
        }

        .info-text {
            color: #276749;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding: 30px;
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            color: #718096;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            display: inline-block;
            width: 36px;
            height: 36px;
            background: #edf2f7;
            border-radius: 50%;
            line-height: 36px;
            text-align: center;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .expiry {
            display: inline-block;
            background: #feebc8;
            color: #c05621;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-top: 15px;
        }

        .highlight {
            background: linear-gradient(120deg, #f0f4ff 0%, #e6f7ff 100%);
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            color: #2d3748;
        }

        @media (max-width: 480px) {

            .content,
            .header {
                padding: 30px 20px;
            }

            .otp-code {
                font-size: 32px;
                letter-spacing: 6px;
                padding: 15px;
            }

            .greeting {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-card">
            <div class="header">
                <div class="logo-icon">🔐</div>
                <h1 class="logo">Permintaan Kode OTP</h1>
                <p style="opacity: 0.9;">Synapse App</p>
            </div>

            <div class="content">
                <h2 class="greeting">Halo, {{ $name }}!</h2>
                <p class="message">
                    Kamu baru saja meminta kode OTP untuk verifikasi akun.
                    Gunakan kode berikut untuk melanjutkan proses reset password:
                </p>

                <div class="otp-container">
                    <span class="otp-label">Kode Verifikasi</span>
                    <div class="otp-code">{{ $otp }}</div>
                    <div class="expiry">
                        ⏰ Berlaku selama 5 menit
                    </div>
                </div>

                <div class="warning">
                    <strong>⚠️ PERHATIAN:</strong> Jangan pernah membagikan kode ini kepada siapapun,
                    termasuk tim support kami. Kode ini bersifat rahasia dan hanya untuk Anda.
                </div>

                <div class="info-box">
                    <div class="info-title">Tips Keamanan</div>
                    <p class="info-text">
                        • Pastikan kamu mengakses email ini dari perangkat yang aman<br>
                        • Hapus email ini setelah menggunakan kode OTP<br>
                        • Laporkan jika ada aktivitas mencurigakan di akun Anda
                    </p>
                </div>

                <p style="text-align: center; color: #718096; font-size: 14px; margin-top: 30px;">
                    Jika kamu tidak meminta kode ini, segera
                    <span class="highlight">ubah password akun</span>
                    dan hubungi tim support kami.
                </p>
            </div>

            <div class="footer">
                <p class="footer-text">
                    Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
                </p>
                <p class="footer-text">
                    © 2025 Synapse App. All rights reserved.<br>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
