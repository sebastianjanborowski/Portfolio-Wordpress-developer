document.addEventListener('DOMContentLoaded', () => {
    userFindEdit();
});

function userFindEdit() {
    const userFindFormID = document.getElementById("user_find_form");

    if (!userFindFormID) return;

    userFindFormID.addEventListener("submit", async (e) => {
        e.preventDefault();

        const userInput = document.getElementById("user_login_find");
        const userLoginValue = userInput.value.trim();
        const userFindResponse = document.getElementById("user_find_response");

        if (userLoginValue.length <= 2) {
            userFindResponse.textContent = "Login użytkownika jest za krótki";
            return;
        }

        try {
            const formData = new FormData();
            formData.append('userLogin', userLoginValue);

            const response = await fetch("../core/akceptacjaKonta/akceptacjaKonta.php", {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`Błąd HTTP: ${response.status}`);
            }

            const text = await response.text();
            console.log('Odpowiedź serwera:', text);

            let data;

            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
            }

            if (data.success) {
                userFindResponse.textContent = data.message;
                userShowTableEdit(data);
            } else {
                userFindResponse.textContent = data.message;
            }

        } catch (error) {
            userFindResponse.textContent = `Błąd: ${error.message}`;
        }
    });
}

function userShowTableEdit(data) {
    const container = document.getElementById("user_container_formularz_edit");
    container.innerHTML = '';

    const card = document.createElement('div');
    card.id = 'user_form_edit';
    card.className = 'user-edit-card dashboard-card';

    const fields = {
        id: 'text',
        login: 'text',
        name: 'text',
        surname: 'text',
        role: 'text',
        email: 'text',
        created_at: 'date',
        updated_at: 'date',
        is_active: 'text'
    };

    const labelsMap = {
        id: 'ID użytkownika',
        login: 'Login',
        name: 'Imię',
        surname: 'Nazwisko',
        role: 'Rola',
        email: 'Adres e-mail',
        created_at: 'Utworzono',
        updated_at: 'Zaktualizowano',
        is_active: 'Status konta 0 = nieaktywne | 1 = aktywne'
    };

    function formatDateForInput(value) {
        if (!value) return '';
        if (typeof value === 'string' && value.length >= 10) {
            return value.slice(0, 10);
        }
        return '';
    }

    function getDisplayValue(name, type) {
        if (name === 'is_active') {
            return String(data[name]) === '1' ? 'Aktywne' : 'Nieaktywne';
        }

        if (type === 'date') {
            return formatDateForInput(data[name]);
        }

        if (data[name] === null || data[name] === undefined || data[name] === '') {
            return '-';
        }

        return data[name];
    }

    const row = document.createElement('div');
    row.className = 'row g-3';

    const col = document.createElement('div');
    col.className = 'col-12';

    const wrapper = document.createElement('div');
    wrapper.className = 'form-group mb-0 form-group-table';

    const tableResponsive = document.createElement('div');
    tableResponsive.className = 'table-responsive';

    const table = document.createElement('table');
    table.className = 'table table-bordered align-middle mb-0 user-table';

    const tbody = document.createElement('tbody');

    Object.entries(fields).forEach(([name, type]) => {
        const tr = document.createElement('tr');
        tr.className = `table-row-${name}`;

        const th = document.createElement('th');
        th.className = `form-label-custom table-label-cell label-${name}`;
        th.textContent = labelsMap[name] ?? name.replaceAll('_', ' ');

        const td = document.createElement('td');
        td.className = 'table-value-cell';

        const valueBox = document.createElement('div');
        valueBox.className = `form-control input-${name}`;

        const value = getDisplayValue(name, type);
        valueBox.textContent = value;

        td.appendChild(valueBox);
        tr.appendChild(th);
        tr.appendChild(td);
        tbody.appendChild(tr);
    });

    const buttonWrap = document.createElement('div');
    buttonWrap.className = 'd-flex flex-column flex-sm-row gap-2 mt-4';

    const buttonAkcept = document.createElement('button');
    buttonAkcept.type = 'button';
    buttonAkcept.id = 'userAkceptEdit';
    buttonAkcept.className = 'btn btn-success';
    buttonAkcept.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Aktywuj konto';

    const buttonNoAkcept = document.createElement('button');
    buttonNoAkcept.type = 'button';
    buttonNoAkcept.id = 'userNoAkceptEdit';
    buttonNoAkcept.className = 'btn btn-outline-danger';
    buttonNoAkcept.innerHTML = '<i class="bi bi-x-circle me-2"></i>Dezaktywuj konto';

    const odpBox = document.createElement('div');
    odpBox.id = 'user_find_edit_box';
    odpBox.className = 'mt-3';

    table.appendChild(tbody);
    tableResponsive.appendChild(table);
    wrapper.appendChild(tableResponsive);
    col.appendChild(wrapper);
    row.appendChild(col);
    card.appendChild(row);

    buttonWrap.appendChild(buttonAkcept);
    buttonWrap.appendChild(buttonNoAkcept);
    card.appendChild(buttonWrap);
    card.appendChild(odpBox);

    container.appendChild(card);

    container.style.display = 'block';

    card.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });

    userCheckResponse(data.login);
}

function userCheckResponse(userLogin) {
    const akceptacja = document.getElementById("userAkceptEdit");
    const brakAkceptacja = document.getElementById("userNoAkceptEdit");

    if (!akceptacja || !brakAkceptacja) return;

    akceptacja.addEventListener('click', () => {
        userSendEdit('1', userLogin);
    });

    brakAkceptacja.addEventListener('click', () => {
        userSendEdit('0', userLogin);
    });
}

async function userSendEdit(flaga, userLogin) {
    const userFindEditBox = document.getElementById("user_find_edit_box");
    const userFindResponse = document.getElementById("user_find_response");

    try {
        const formData = new FormData();
        formData.append('flaga', flaga);
        formData.append('login', userLogin);

        const response = await fetch("../core/akceptacjaKonta/akceptacjaKonta.php", {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Błąd HTTP: ${response.status}`);
        }

        const text = await response.text();

        let data;

        try {
            data = JSON.parse(text);
        } catch (error) {
            throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
        }

        if (data.success) {
            userFindResponse.textContent = data.message;

            const container = document.getElementById("user_container_formularz_edit");
            container.style.display = 'none';
        } else {
            userFindResponse.textContent = `Błąd: ${data.message}`;
        }

    } catch (error) {
        userFindEditBox.textContent = `Błąd serwera: ${error.message}`;
    }
}