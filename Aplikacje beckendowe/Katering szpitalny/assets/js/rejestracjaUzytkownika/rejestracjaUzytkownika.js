// plik odpowiada za walidacje formularza i wysyłke danych na plik backendowy
document.addEventListener('DOMContentLoaded', () => {
    katering_dodaj_uzytkownika();
});

function katering_dodaj_uzytkownika() {
    const userAddForm = document.getElementById('userAddForm');
    if (!userAddForm) return;

    userAddForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const userLogin = document.getElementById('userLogin');
        const userEmail = document.getElementById('userEmail');
        const userName = document.getElementById('userName');
        const userSurname = document.getElementById('userSurname');
        const userRole = document.getElementById('userRole');
        const userPassword = document.getElementById('userPassword');
        const odp = document.getElementById("odp");

        const userLoginValue = userLogin.value.trim();
        const userEmailValue = userEmail.value.trim();
        const userNameValue = userName.value.trim();
        const userSurnameValue = userSurname.value.trim();
        const userRoleValue = userRole.value;
        const userPasswordValue = userPassword.value.trim();

        // czyszczenie starych błędów
        [
            userLogin,
            userEmail,
            userName,
            userSurname,
            userRole,
            userPassword
        ].forEach(el => el.classList.remove('czerwone_obramowanie'));

        if (!userLoginValue || userLoginValue.length < 3) {
            userLogin.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!userEmailValue || userEmailValue.length < 5 || !userEmailValue.includes('@')) {
            userEmail.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!userNameValue || userNameValue.length < 2) {
            userName.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!userSurnameValue || userSurnameValue.length < 2) {
            userSurname.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!userRoleValue) {
            userRole.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!userPasswordValue || userPasswordValue.length < 6) {
            userPassword.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!flaga) return;

        // wysyłka danych na serwer po walidacji
        try {
            const formData = new FormData();
            formData.append("userLogin", userLoginValue);
            formData.append("userEmail", userEmailValue);
            formData.append("userName", userNameValue);
            formData.append("userSurname", userSurnameValue);
            formData.append("userRole", userRoleValue);
            formData.append("userPassword", userPasswordValue);

            // lokalizacja wysyłania danych
            const response = await fetch("/core/rejestracjaUzytkownika/rejestracjaUzytkownika.php", {
                method: 'POST',
                body: formData
            });

            const text = await response.text();

            let data;

            if (!response.ok) {
                throw new Error("Błąd HTTP " + response.status + ". Odpowiedź: " + text);
            }

            try {
                // zmienia na obiekt js
                data = JSON.parse(text);
            } catch (error) {
                throw new Error("Php nie zwróciło porawnego rodzaju danych odpowiedz: " + text);
            }

            odp.textContent = data.message;
            odp.className = data.success ? "success" : "fail";

            if (data.success) {
                console.log("dane użytkownika zostały przerobione jak należy");
            }

        } catch (error_zewnatrz) {
            odp.textContent = error_zewnatrz.message;
            odp.className = "fail";
        }
    });
}