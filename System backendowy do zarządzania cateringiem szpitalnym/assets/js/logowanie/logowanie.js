// to jest medium kontaktu z serwerem, obróbka danych sprawdzenie ich poprawności i wysyłka na wzkazany adres metodą POST
document.addEventListener('DOMContentLoaded', () => {
    katering_logowanie();
});

function katering_logowanie() {
    const form = document.getElementById("loginForm");
    if (!form) return;

    // połączenie jest asynchroniczne by nie blokować swobodnego przesyłu dancyh pomiędzy wieloma wywołaniami logowania jednocześnie
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const login = document.getElementById("login").value.trim();
        const pass = document.getElementById("password").value.trim();

        const loginError = document.getElementById("loginError");
        const passwordError = document.getElementById("passwordError");
        const resultBox = document.getElementById("resultBox");

        loginError.textContent = "";
        passwordError.textContent = "";
        resultBox.textContent = "";

        let isValid = true;

        if (login === "") {
            loginError.textContent = "Podaj login.";
            isValid = false;
        } else if (login.length < 3) {
            loginError.textContent = "Login musi mieć minimum 3 znaki.";
            isValid = false;
        }

        if (pass === "") {
            passwordError.textContent = "Podaj hasło.";
            isValid = false;
        } else if (pass.length < 7) {
            passwordError.textContent = "Hasło musi mieć minimum 8 znaków.";
            isValid = false;
        }

        if (!isValid) return;

        // wysyłka danych na adres pliku beckendowego służącego do potwirdzenia logowania
        try {
            const formData = new FormData();
            formData.append("login", login);
            formData.append("password", pass);
            
            // miejsce docelowe wysyłanych danych
            const response = await fetch("../core/logowanie/login.php", {
                method: "POST",
                credencials:'same-origin',
                body: formData
            });

            // obsłużenie niestandardowej odpowiedzi serwera, dla błędu
            const text = await response.text();
            console.log("RAW RESPONSE:", text);

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
            }

            resultBox.textContent = data.message;
            resultBox.className = data.success ? "success" : "fail";

            // prawidłowe odebranie danych, js określa ruch na stronie
            if (data.success && data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            }

        } catch (error) {
            resultBox.textContent = error.message;
            resultBox.className = "fail";
            console.error("Błąd:", error);
        }
    });
}