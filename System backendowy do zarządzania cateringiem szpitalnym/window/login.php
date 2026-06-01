<!-- plik który służy do logowania, pojedynczy frmularz z dołączonymi na wzór wordpress header i footer
Połączenie jest take: Najpier skrypt js zbiera dane z formularza, waliduje je i dopiero skrypt js wysyła dane 
do pliku serwerowego
dane w tym kroku ida do pliku assets/js/logowanie/logowanie.js
-->
<?php session_start(); ?>
<?php require_once '../template/header.php'; ?>

<?php
    if(isset($_SESSION['logged_in_user_id'])){
        header('Location:dashboard.php');
    }
?>

<div class="container-fluid login-page">
    <div class="login-wrapper">
        <div class="login-top-icon">
            <i class="bi bi-hospital"></i>
        </div>

        <div class="login-heading">
            <h2>Logowanie</h2>
            <p>Zaloguj się do systemu</p>
        </div>

        <div class="login-card">
            <form id="loginForm" novalidate>
                <div class="form-group">
                    <label for="login" class="form-label-custom">Login</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            class="form-control" 
                            autocomplete="username" 
                            placeholder="Wpisz login"
                        >
                    </div>
                    <div class="error" id="loginError"></div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label-custom">Hasło</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            autocomplete="current-password" 
                            placeholder="Wpisz hasło"
                        >
                    </div>
                    <div class="error" id="passwordError"></div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Zaloguj
                </button>
            </form>

            <div id="resultBox"></div>

            <div class="login-footer-info">
                <span><i class="bi bi-shield-lock me-1"></i>Bezpieczne logowanie</span>
                <span><i class="bi bi-key me-1"></i>Połączenie szyfrowane</span>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>