<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EzBac | Join the Community</title>
    <link rel="icon" type="image/png" href="ezbac-icon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ux-enhancer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --auth-primary: #AB1017;
            --auth-bg-overlay: rgba(0, 0, 0, 0.4);
        }

        body {
            background: url('assets/images/authBg.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--auth-bg-overlay);
            backdrop-filter: blur(8px);
            z-index: 1;
        }

        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1100px; /* Much wider */
            padding: 40px;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.98);
            padding: 60px; /* More padding */
            border-radius: 32px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.4);
            text-align: center;
            display: flex;
            align-items: center;
            gap: 60px;
            min-height: 600px;
        }

        .auth-form-side {
            flex: 1;
            max-width: 400px;
            margin: 0 auto;
        }

        .auth-visual-side {
            flex: 1.2;
            display: none; /* Hidden on small screens, shown below */
            text-align: left;
        }

        @media (min-width: 992px) {
            .auth-visual-side { display: block; }
            .auth-container { text-align: left; }
        }

        .auth-logo { 
            height: 40px; 
            margin-bottom: 24px; 
            transition: transform 0.3s;
        }
        
        .auth-logo:hover { transform: scale(1.05); }

        .auth-tabs {
            display: flex;
            background: #f7fafc;
            padding: 4px;
            border-radius: 14px;
            margin-bottom: 30px;
            border: 1px solid #edf2f7;
        }

        .auth-tab {
            flex: 1;
            padding: 10px;
            border: none;
            background: none;
            font-weight: 600;
            cursor: pointer;
            border-radius: 10px;
            transition: 0.3s;
            color: #718096;
            font-size: 14px;
        }

        .auth-tab.active {
            background: white;
            color: var(--auth-primary);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: #4a5568;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .form-group input:focus { 
            border-color: var(--auth-primary); 
            background: white;
            outline: none; 
            box-shadow: 0 0 0 4px rgba(171, 16, 23, 0.1);
        }

        .btn-auth {
            background: var(--auth-primary);
            color: white;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(171, 16, 23, 0.2);
        }

        .btn-auth:hover { 
            background: #8e0d13;
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(171, 16, 23, 0.3); 
        }

        .auth-switch { 
            margin-top: 24px; 
            color: #718096; 
            font-size: 14px; 
        }

        .auth-switch span { 
            color: var(--auth-primary); 
            font-weight: 700; 
            cursor: pointer;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .back-link:hover { color: white; transform: translateX(-5px); }

        .hidden { display: none; }
        
        /* Entrance Animation */
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .auth-container { animation: fadeInScale 0.6s ease-out; }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-container">
            <!-- Visual Side -->
            <div class="auth-visual-side">
                <h1 style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 20px;">Master your BAC with <span style="color: var(--auth-primary);">EzBac</span></h1>
                <p style="font-size: 1.2rem; color: #4a5568; margin-bottom: 40px;">Join thousands of students and get access to exclusive quizzes, flashcards, and study resources.</p>
                <img src="assets/images/hero-image.svg" alt="Study" style="width: 100%; max-width: 500px; border-radius: 20px;">
            </div>

            <!-- Form Side -->
            <div class="auth-form-side">
                <a href="index.html">
                    <img src="assets/images/logo.svg" class="auth-logo" alt="EzBac">
                </a>
                
                <div class="auth-tabs">
                    <button class="auth-tab active" id="tabLogin" onclick="switchTab('login')">Login</button>
                    <button class="auth-tab" id="tabSignup" onclick="switchTab('signup')">Create Account</button>
                </div>

                <!-- Login Form -->
                <form id="loginForm">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="l-email" placeholder="e.g. sief@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="l-password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-auth">Sign In</button>
                </form>

                <!-- Signup Form -->
                <form id="signupForm" class="hidden">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="s-username" placeholder="e.g. Sief Eddine" required>
                    </div>
                    <div class="form-group">
                        <label>Major (الشعبة)</label>
                        <select id="s-subject" style="width: 100%; padding: 12px; border-radius: 12px; border: 2px solid #e2e8f0; background: #f8fafc; font-family: inherit; font-size: 14px; cursor: pointer;">
                            <option value="علوم تجريبية">علوم تجريبية</option>
                            <option value="رياضيات">رياضيات</option>
                            <option value="تسيير و اقتصاد">تسيير و اقتصاد</option>
                            <option value="اداب و فلسفة">اداب و فلسفة</option>
                            <option value="لغات اجنبية">لغات اجنبية</option>
                            <option value="هندسة ميكانيكية">هندسة ميكانيكية</option>
                            <option value="هندسة كهربائية">هندسة كهربائية</option>
                            <option value="هندسة مدنية">هندسة مدنية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="s-email" placeholder="e.g. sief@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Create Password</label>
                        <input type="password" id="s-password" placeholder="Min. 8 characters" required>
                    </div>
                    <button type="submit" class="btn-auth">Get Started</button>
                </form>

                <p class="auth-switch" id="switchText">
                    Don't have an account? <span onclick="switchTab('signup')">Sign up for free</span>
                </p>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="index.html" class="back-link">← Back to landing page</a>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            const tabLogin = document.getElementById('tabLogin');
            const tabSignup = document.getElementById('tabSignup');
            const switchText = document.getElementById('switchText');

            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
                tabLogin.classList.add('active');
                tabSignup.classList.remove('active');
                switchText.innerHTML = `Don't have an account? <span onclick="switchTab('signup')">Sign up for free</span>`;
            } else {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                tabLogin.classList.remove('active');
                tabSignup.classList.add('active');
                switchText.innerHTML = `Already have an account? <span onclick="switchTab('login')">Sign in instead</span>`;
            }
        }

        // Login Handler
        document.getElementById('loginForm').onsubmit = async (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            btn.innerText = 'Signing in...';
            
            const res = await fetch('api/user_auth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'login',
                    email: document.getElementById('l-email').value,
                    password: document.getElementById('l-password').value
                })
            });
            const data = await res.json();
            if (data.success) window.location.href = 'home.html';
            else {
                alert(data.message);
                btn.innerText = 'Sign In';
            }
        };

        // Signup Handler
        document.getElementById('signupForm').onsubmit = async (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            btn.innerText = 'Creating account...';

            const res = await fetch('api/user_auth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'signup',
                    username: document.getElementById('s-username').value,
                    subject: document.getElementById('s-subject').value,
                    email: document.getElementById('s-email').value,
                    password: document.getElementById('s-password').value
                })
            });
            const data = await res.json();
            if (data.success) window.location.href = 'home.html';
            else {
                alert(data.message);
                btn.innerText = 'Get Started';
            }
        };
    </script>
</body>
</html>
