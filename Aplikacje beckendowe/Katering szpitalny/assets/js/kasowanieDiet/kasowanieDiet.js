document.addEventListener('DOMContentLoaded', () => {
    cateringDeleteDiet();
});

function cateringDeleteDiet() {
    const cateringDeleteDietFormID = document.getElementById("catering_delete_diet_form");

    if (!cateringDeleteDietFormID) return;

    cateringDeleteDietFormID.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dietInput = document.getElementById("diet_name_find");
        const dietNameValue = dietInput.value.trim();
        const cateringOdp = document.getElementById("catering_odp");

        if (dietNameValue.length <= 1) {
            cateringOdp.textContent = "Kod diety jest za krótka";
            return;
        }

        try {
            const formData = new FormData();
            formData.append('dietName', dietNameValue);

            const response = await fetch("../core/kasowanieDiet/kasowanieDiet.php", {
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
                cateringOdp.textContent = data.message;
                cateringShowDeleteDietTable(data);
            } else {
                cateringOdp.textContent = data.message;
            }

        } catch (error) {
            cateringOdp.textContent = `Błąd: ${error.message}`;
        }
    });
}

function cateringShowDeleteDietTable(data) {
    const container = document.getElementById("catering_container_formularz_edit");
    container.innerHTML = '';

    const departmentNumber = parseInt(data.department_id);

    const card = document.createElement('div');
    card.id = 'catering_form_deleteDiet';
    card.className = 'diet-edit-card dashboard-card';

    const fields = {
        department: 'select',
        diet_name: 'text',
        diet_code: 'text',
        is_special_diet: 'number',
        diet_restrictions: 'text',
        diet_description: 'textarea',
        diet_notes: 'textarea',
        created_at: 'date',
        updated_at: 'date',
        is_active: 'text'
    };

    const labelsMap = {
        department: 'Dział / oddział',
        diet_name: 'Nazwa diety',
        diet_code: 'Kod diety',
        is_special_diet: 'Czy dieta specjalna',
        diet_restrictions: 'Ograniczenia / alergeny',
        diet_description: 'Opis diety',
        diet_notes: 'Uwagi dodatkowe',
        created_at: 'Utworzono',
        updated_at: 'Zaktualizowano',
        is_active: 'Status aktywności 0 = niezatwierdzona | 1 = zatwierdzona'
    };

    const departmentOptions = [
        { value: '1', text: 'Chirurgia' },
        { value: '2', text: 'Interna' },
        { value: '3', text: 'Pediatria' },
        { value: '4', text: 'Geriatria' },
        { value: '5', text: 'Neurologia' },
        { value: '6', text: 'Onkologia' }
    ];

    function formatDateForInput(value) {
        if (!value) return '';
        if (typeof value === 'string' && value.length >= 10) {
            return value.slice(0, 10);
        }
        return '';
    }

    function getDepartmentName(id) {
        const found = departmentOptions.find(option => parseInt(option.value) === parseInt(id));
        return found ? found.text : '';
    }

    function getDisplayValue(name, type) {
        if (name === 'department') {
            return getDepartmentName(departmentNumber);
        }

        if (name === 'is_active') {
            return String(data[name]) === '1' ? 'Zatwierdzona' : 'Niezatwierdzona';
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
    table.className = 'table table-bordered align-middle mb-0 catering-diet-table';

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

        if (name === 'diet_description' || name === 'diet_notes') {
            valueBox.classList.add('diet-textarea');
        }

        const value = getDisplayValue(name, type);

        if (name === 'diet_description' || name === 'diet_notes' || name === 'diet_restrictions') {
            valueBox.innerHTML = String(value).replace(/\n/g, '<br>');
        } else {
            valueBox.textContent = value;
        }

        td.appendChild(valueBox);
        tr.appendChild(th);
        tr.appendChild(td);
        tbody.appendChild(tr);
    });

    const buttonWrap = document.createElement('div');
    buttonWrap.className = 'd-flex flex-column flex-sm-row gap-2 mt-4';

    const buttonDelete = document.createElement('button');
    buttonDelete.type = 'button';
    buttonDelete.id = 'cateringDeleteDietButton';
    buttonDelete.className = 'btn btn-danger';
    buttonDelete.innerHTML = '<i class="bi bi-trash me-2"></i>Skasuj dietę';

    const odpBox = document.createElement('div');
    odpBox.id = 'catering_findDietDeleteResponse';
    odpBox.className = 'mt-3';

    table.appendChild(tbody);
    tableResponsive.appendChild(table);
    wrapper.appendChild(tableResponsive);
    col.appendChild(wrapper);
    row.appendChild(col);
    card.appendChild(row);

    buttonWrap.appendChild(buttonDelete);
    card.appendChild(buttonWrap);
    card.appendChild(odpBox);

    container.appendChild(card);
    container.style.display = 'block';

    card.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });

    cateringCheckDeleteDietResponse(data.diet_code);
}

function cateringCheckDeleteDietResponse(dietName) {
    const deleteButton = document.getElementById("cateringDeleteDietButton");

    if (!deleteButton) return;

    deleteButton.addEventListener('click', () => {
        cateringDeleteDietSend(dietName);
    });
}

async function cateringDeleteDietSend(dietName) {
    const cateringFindDietDeleteResponse = document.getElementById("catering_findDietDeleteResponse");
    const cateringOdpResponse = document.getElementById("catering_odp");

    try {
        const formData = new FormData();
        formData.append('deleteDietName', dietName);

        const response = await fetch("../core/kasowanieDiet/kasowanieDiet.php", {
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
            cateringOdpResponse.textContent = data.message;

            const container = document.getElementById("catering_container_formularz_edit");
            container.style.display = 'none';
            container.innerHTML = '';
        } else {
            cateringOdpResponse.textContent = `Błąd: ${data.message}`;
        }

    } catch (error) {
        cateringFindDietDeleteResponse.textContent = `Błąd serwera: ${error.message}`;
    }
}