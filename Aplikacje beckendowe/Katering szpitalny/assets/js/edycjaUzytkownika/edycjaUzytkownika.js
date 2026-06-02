document.addEventListener('DOMContentLoaded',() => {
    cateringEditUser();
});

function cateringEditUser(){
    var catering_edit_user_formID = document.getElementById("catering_edit_user_form");
    
    if(!catering_edit_user_formID) return;

    catering_edit_user_formID.addEventListener("submit",async (e) => {
        e.preventDefault();

        var user_login = document.getElementById("user_login_find");
        var user_login_value = user_login.value.trim();
        var catering_odp = document.getElementById("catering_odp");

        if(user_login_value.length > 2){
            try{
                const formData = new FormData();
                formData.append('userLogin', user_login_value);

                const response = await fetch("../core/edycjaUzytkownika/edycjaUzytkownika.php",{
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();

                let data;

                try{
                    data = JSON.parse(text);
                }catch(e){
                    throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
                }

                if(data.success){
                    catering_odp.textContent = `Znaleziono szukanego użytkownika w bazie danych`;
                    var odebraneDaneUsera = data;
                    cateringEditDataUser(odebraneDaneUsera);
                    
                }else{
                    catering_odp.textContent = ` ${data.message}`;
                }

            }catch(error){
                catering_odp.textContent = `Błąd: ${error}`;
            }
        }else{
            catering_odp.textContent = "Login użytkownika jest za krótki";
        }
    });
}

function cateringEditDataUser(data) {
    const container = document.getElementById("catering_container_formularz_edit");
    container.innerHTML = '';

    const form = document.createElement('form');
    const user_login_for_find = data.login;

    form.method = 'POST';
    form.id = 'catering_form_reditUser';
    form.className = 'diet-edit-card dashboard-card';

    const fields = {
        login: 'text',
        name: 'text',
        surname: 'text',
        role: 'select',
        email: 'email',
        password: 'password'
    };

    const labelsMap = {
        login: 'Login',
        name: 'Imię',
        surname: 'Nazwisko',
        role: 'Rola',
        email: 'E-mail',
        password: 'Nowe hasło'
    };

    const roleOptions = [
        { value: '1', text: 'Administrator' },
        { value: '2', text: 'Dietetyk' },
        { value: '3', text: 'Pracownik kuchni' },
        { value: '4', text: 'Obsługa oddziału' }
    ];

    const row = document.createElement('div');
    row.className = 'row g-3';

    Object.entries(fields).forEach(([name, type]) => {
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6 col-lg-6';

        const wrapper = document.createElement('div');
        wrapper.className = `form-group mb-0 form-group-${name}`;

        const label = document.createElement('label');
        label.htmlFor = name;
        label.className = 'form-label-custom';
        label.textContent = labelsMap[name] ?? name.replaceAll('_', ' ');

        let element;

        if (name === 'role') {
            element = document.createElement('select');
            element.className = `form-control input-${name}`;

            const firstOption = document.createElement('option');
            firstOption.value = '';
            firstOption.textContent = 'Wybierz rolę';
            element.appendChild(firstOption);

            roleOptions.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;

                if (String(optionData.value) === String(data[name])) {
                    option.selected = true;
                }

                element.appendChild(option);
            });
        } else {
            element = document.createElement('input');
            element.type = type;

            if (name === 'password') {
                element.value = '';
                element.placeholder = 'Wpisz nowe hasło, jeśli chcesz zmienić';
            } else {
                element.value = data[name] ?? '';
            }

            element.className = `form-control input-${name}`;
        }

        element.name = name;
        element.id = name;

        wrapper.appendChild(label);
        wrapper.appendChild(element);
        col.appendChild(wrapper);
        row.appendChild(col);
    });

    form.appendChild(row);
    container.appendChild(form);

    const buttonCol = document.createElement('div');
    buttonCol.className = 'col-12 col-md-6 col-lg-6';

    const buttonWrapper = document.createElement('div');
    buttonWrapper.className = 'form-group mb-0 h-100 d-flex flex-column justify-content-end';

    const button = document.createElement('button');
    button.type = 'submit';
    button.className = 'btn btn-primary diet-btn-save w-100';
    button.innerHTML = '<i class="bi bi-save me-2"></i>Zapisz zmiany';

    buttonWrapper.appendChild(button);
    buttonCol.appendChild(buttonWrapper);
    row.appendChild(buttonCol);

    form.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
    
    catering_reorder_user_data(user_login_for_find);
}

function catering_reorder_user_data(user_login_for_find) {
    const form = document.getElementById("catering_form_reditUser");
    console.log("Szukany klucz użytkownika:", user_login_for_find);

    if (!form) {
        console.log("Brak formularza");
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const login = document.getElementById("login");
        const name = document.getElementById("name");
        const surname = document.getElementById("surname");
        const role = document.getElementById("role");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const odp = document.getElementById("catering_response");

        const pola = [
            login,
            name,
            surname,
            role,
            email
        ];

        // czyszczenie starych błędów
        pola.forEach(el => {
            if (el) el.classList.remove('czerwone_obramowanie');
        });

        if (password) {
            password.classList.remove('czerwone_obramowanie');
        }

        // walidacja
        pola.forEach(el => {
            if (el && el.value.trim() === '') {
                el.classList.add('czerwone_obramowanie');
                flaga = false;
            }
        });

        if (email && email.value.trim() !== '' && !email.value.includes('@')) {
            email.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (password && password.value.trim() !== '' && password.value.trim().length < 6) {
            password.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!flaga) {
            if (odp) {
                odp.textContent = "Uzupełnij poprawnie wszystkie wymagane pola formularza.";
                odp.className = "fail";
            }
            return;
        }

        try {
            const formData = new FormData();
            formData.append("login", login.value.trim());
            formData.append("name", name.value.trim());
            formData.append("surname", surname.value.trim());
            formData.append("role", role.value.trim());
            formData.append("email", email.value.trim());
            formData.append("password", password.value.trim());
            formData.append("klucz", user_login_for_find);

            const response = await fetch("../core/edycjaUzytkownika/edycjaUzytkownika.php", {
                method: "POST",
                body: formData
            });

            const text = await response.text();

            console.log("=== RAW RESPONSE START ===");
            console.log(text);
            console.log("=== RAW RESPONSE END ===");
            console.log("HTTP status:", response.status);
            console.log("HTTP ok:", response.ok);
            console.log("Content-Type:", response.headers.get("content-type"));

            let data;

            try {
                data = JSON.parse(text);
                console.log("Parsowanie JSON OK:", data);
            } catch (error) {
                console.error("Błąd parsowania JSON:", error);
                console.error("Surowa odpowiedź PHP:", text);

                throw new Error(
                    `PHP nie zwróciło poprawnego JSON. Status: ${response.status}. Szczegóły w konsoli.`
                );
            }

            if (odp) {
                odp.textContent = data.message || "Brak komunikatu z serwera.";
                odp.className = data.success ? "success" : "fail";

                if(data.success){
                    const catering_form_reditUser = document.getElementById("catering_form_reditUser");

                    if(catering_form_reditUser){
                        catering_form_reditUser.remove();
                        catering_response.remove();
                        catering_odp.textContent = data.message;
                    }
                }
            }

        } catch (error) {
            console.error("PEŁNY BŁĄD:", error);
            console.error("STACK:", error.stack);

            if (odp) {
                odp.textContent = error.message;
                odp.className = "fail";
            }
        }
    });
}