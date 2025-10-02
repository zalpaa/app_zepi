<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --danger-color: #f56565;
            --warning-color: #ed8936;
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f7fafc;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --shadow-medium: rgba(0, 0, 0, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(240, 147, 251, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(118, 75, 162, 0.2) 0%, transparent 50%);
            animation: float 25s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(-30px, -20px) rotate(0deg); }
            50% { transform: translate(30px, 20px) rotate(180deg); }
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            box-shadow: 
                0 20px 40px var(--shadow-medium),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
            border-radius: 24px 24px 0 0;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 30px 60px var(--shadow-medium),
                0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        }

        .register-icon i {
            color: white;
            font-size: 24px;
        }

        .register-title {
            color: var(--text-dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-subtitle {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
        }

        .form-section {
            padding: 0 15px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px var(--shadow-light);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-control.valid {
            border-color: var(--primary-color);
            background: rgba(102, 126, 234, 0.05);
        }

        .form-control.invalid {
            border-color: var(--danger-color);
            background: rgba(245, 101, 101, 0.05);
        }

        .form-control::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            transition: color 0.3s ease;
            z-index: 2;
        }

        .form-control:focus ~ .input-icon {
            color: var(--primary-color);
        }

        .validation-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .validation-icon.show {
            opacity: 1;
        }

        .validation-icon.valid {
            color: var(--primary-color);
        }

        .validation-icon.invalid {
            color: var(--danger-color);
        }

        .password-strength {
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .password-strength.show {
            opacity: 1;
            transform: translateY(0);
        }

        .password-strength.weak {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(245, 101, 101, 0.2);
        }

        .password-strength.medium {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(237, 137, 54, 0.2);
        }

        .password-strength.strong {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
            margin-top: 24px;
        }

        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .login-link p {
            color: var(--text-light);
            font-size: 14px;
            margin: 0;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Progress indicator */
        .form-progress {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .form-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            width: 0%;
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .register-card {
                padding: 32px 24px;
                margin: 16px;
                border-radius: 20px;
                max-width: 420px;
            }

            .register-title {
                font-size: 24px;
            }

            .form-control {
                padding: 14px 16px 14px 44px;
                font-size: 16px;
            }

            .btn-register {
                padding: 14px;
            }

            .input-icon {
                left: 16px;
            }

            .form-section {
                padding: 0;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Success animation */
        @keyframes success {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .success {
            animation: success 0.3s ease-in-out;
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="register-card">
        <div class="register-header">
            <div class="register-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="register-title">Create Account</h1>
            <p class="register-subtitle">Join us and get started</p>
        </div>

        <div class="form-progress">
            <div class="form-progress-bar" id="formProgress"></div>
        </div>

        <form action="proses_register.php" method="post" id="registerForm">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6 form-section">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div style="position: relative;">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Choose a username" required>
                            <i class="fas fa-user input-icon"></i>
                            <i class="fas fa-check validation-icon" id="usernameValid"></i>
                            <i class="fas fa-times validation-icon" id="usernameInvalid"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div style="position: relative;">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Create a strong password" required>
                            <i class="fas fa-lock input-icon"></i>
                            <i class="fas fa-eye toggle-password" id="togglePassword" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-light);"></i>
                        </div>
                        <div class="password-strength" id="passwordStrength"></div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6 form-section">
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div style="position: relative;">
                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Confirm your password" required>
                            <i class="fas fa-lock input-icon"></i>
                            <i class="fas fa-check validation-icon" id="confirmValid"></i>
                            <i class="fas fa-times validation-icon" id="confirmInvalid"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-register" id="registerBtn">
                        <span id="btnText">Buat Akun</span>
                        <span id="btnLoading" class="loading" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </form>

        <div class="login-link">
            <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const form = document.getElementById('registerForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const registerBtn = document.getElementById('registerBtn');
    const formProgress = document.getElementById('formProgress');
    const togglePassword = document.getElementById('togglePassword');

    // Password visibility toggle
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Password strength checker
    function checkPasswordStrength(password) {
        const strengthIndicator = document.getElementById('passwordStrength');
        let strength = 0;
        let message = '';

        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        strengthIndicator.classList.remove('weak', 'medium', 'strong');
        
        if (password.length > 0) {
            strengthIndicator.classList.add('show');
            if (strength <= 2) {
                strengthIndicator.classList.add('weak');
                message = 'Password terlalu lemah';
            } else if (strength <= 4) {
                strengthIndicator.classList.add('medium');
                message = 'Password lumayan kuat';
            } else {
                strengthIndicator.classList.add('strong');
                message = 'Password sangat kuat!';
            }
            strengthIndicator.textContent = message;
        } else {
            strengthIndicator.classList.remove('show');
        }

        return strength >= 3;
    }

    // Username validation
    function validateUsername(username) {
        const isValid = username.length >= 3 && /^[a-zA-Z0-9_]+$/.test(username);
        const usernameField = document.getElementById('username');
        const validIcon = document.getElementById('usernameValid');
        const invalidIcon = document.getElementById('usernameInvalid');

        if (username.length > 0) {
            if (isValid) {
                usernameField.classList.add('valid');
                usernameField.classList.remove('invalid');
                validIcon.classList.add('show', 'valid');
                invalidIcon.classList.remove('show');
            } else {
                usernameField.classList.add('invalid');
                usernameField.classList.remove('valid');
                invalidIcon.classList.add('show', 'invalid');
                validIcon.classList.remove('show');
            }
        } else {
            usernameField.classList.remove('valid', 'invalid');
            validIcon.classList.remove('show');
            invalidIcon.classList.remove('show');
        }

        return isValid;
    }

    // Password confirmation validation
    function validatePasswordConfirmation() {
        const isValid = confirmPassword.value === password.value && password.value.length > 0;
        const confirmField = document.getElementById('confirmPassword');
        const validIcon = document.getElementById('confirmValid');
        const invalidIcon = document.getElementById('confirmInvalid');

        if (confirmPassword.value.length > 0) {
            if (isValid) {
                confirmField.classList.add('valid');
                confirmField.classList.remove('invalid');
                validIcon.classList.add('show', 'valid');
                invalidIcon.classList.remove('show');
            } else {
                confirmField.classList.add('invalid');
                confirmField.classList.remove('valid');
                invalidIcon.classList.add('show', 'invalid');
                validIcon.classList.remove('show');
            }
        } else {
            confirmField.classList.remove('valid', 'invalid');
            validIcon.classList.remove('show');
            invalidIcon.classList.remove('show');
        }

        return isValid;
    }

    // Update form progress
    function updateFormProgress() {
        let progress = 0;
        const fields = [username, password, confirmPassword];
        
        fields.forEach(field => {
            if (field.value.length > 0) progress += 33.33;
        });

        // Validate all fields
        const usernameValid = validateUsername(username.value);
        const passwordValid = checkPasswordStrength(password.value);
        const confirmValid = validatePasswordConfirmation();

        formProgress.style.width = progress + '%';
    }

    // Event listeners
    username.addEventListener('input', updateFormProgress);
    password.addEventListener('input', updateFormProgress);
    confirmPassword.addEventListener('input', updateFormProgress);

    // Form submission
    form.addEventListener('submit', function(e) {
        const btn = document.getElementById('registerBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');
        
        // Show loading state
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-block';
        btn.disabled = true;
        
        // Simulate loading (remove this in production)
        setTimeout(() => {
            btnText.style.display = 'inline-block';
            btnLoading.style.display = 'none';
            btn.disabled = false;
        }, 2000);
    });

    // Add smooth interactions
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.parentElement.classList.remove('focused');
        });

        input.addEventListener('input', function() {
            this.style.transform = 'scale(1.01)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
</script>
</body>
</html>