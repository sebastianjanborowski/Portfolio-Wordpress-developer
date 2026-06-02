document.addEventListener('DOMContentLoaded', () => {
    cateringEditOrder();
});

function cateringEditOrder() {
    const cateringEditOrderForm = document.getElementById("catering_edit_order_form");

    if (!cateringEditOrderForm) return;

    cateringEditOrderForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const orderNameInput = document.getElementById("order_name_find");
        const orderNameValue = orderNameInput.value.trim();
        const cateringOdp = document.getElementById("catering_odp");

        if (orderNameValue.length > 2) {
            try {
                const formData = new FormData();
                formData.append('nazwaZamowienia', orderNameValue);

                const response = await fetch("../core/edycjaZamowien/edycjaZamowienia.php", {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();

                let data;

                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
                }

                if (data.success) {
                    cateringOdp.textContent = "Znaleziono zamówienie w bazie danych";
                    cateringEditDataOrder(data);
                } else {
                    cateringOdp.textContent = data.message;
                }

            } catch (error) {
                cateringOdp.textContent = "Błąd: " + error.message;
            }
        } else {
            cateringOdp.textContent = "Nazwa zamówienia jest za krótka";
        }
    });
}

function cateringEditDataOrder(data) {
    const container = document.getElementById("catering_container_formularz_edit_order");
    container.innerHTML = '';

    const form = document.createElement('form');
    const orderNameForFind = data.Order_name;

    form.method = 'POST';
    form.id = 'catering_form_reditOrder';
    form.className = 'diet-edit-card dashboard-card';

    const fields = {
        Order_name: 'text',
        Cod: 'text',
        Department: 'select',
        Special: 'select',
        Restrictions: 'text',
        Describe: 'textarea',
        Quantity: 'number',
        Addtional_describe: 'textarea'
    };

    const labelsMap = {
        Order_name: 'Nazwa zamówienia',
        Cod: 'Kod zamówienia',
        Department: 'Oddział',
        Special: 'Zamówienie specjalne',
        Restrictions: 'Ograniczenia / alergeny',
        Describe: 'Opis zamówienia',
        Quantity: 'Liczba porcji',
        Addtional_describe: 'Dodatkowe uwagi'
    };

    const departmentOptions = [
        { value: 'Oddział Internistyczny', text: 'Oddział Internistyczny' },
        { value: 'Oddział Chirurgiczny', text: 'Oddział Chirurgiczny' },
        { value: 'Oddział Pediatryczny', text: 'Oddział Pediatryczny' },
        { value: 'Oddział Geriatryczny', text: 'Oddział Geriatryczny' },
        { value: 'Oddział Neurologiczny', text: 'Oddział Neurologiczny' },
        { value: 'Oddział Onkologiczny', text: 'Oddział Onkologiczny' }
    ];

    const specialOptions = [
        { value: 'Nie', text: 'Nie' },
        { value: 'Tak', text: 'Tak' }
    ];

    const row = document.createElement('div');
    row.className = 'row g-3';

    Object.entries(fields).forEach(([name, type]) => {
        const col = document.createElement('div');

        if (name === 'Restrictions' || name === 'Describe' || name === 'Addtional_describe') {
            col.className = 'col-12';
        } else {
            col.className = 'col-12 col-md-6 col-lg-6';
        }

        const wrapper = document.createElement('div');
        wrapper.className = `form-group mb-0 form-group-${name}`;

        const label = document.createElement('label');
        label.htmlFor = name;
        label.className = 'form-label-custom';
        label.textContent = labelsMap[name] ?? name;

        let element;

        if (name === 'Department') {
            element = document.createElement('select');
            element.className = `form-control input-${name}`;

            departmentOptions.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;

                if (optionData.value === data[name]) {
                    option.selected = true;
                }

                element.appendChild(option);
            });

        } else if (name === 'Special') {
            element = document.createElement('select');
            element.className = `form-control input-${name}`;

            specialOptions.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;

                if (optionData.value === data[name]) {
                    option.selected = true;
                }

                element.appendChild(option);
            });

        } else if (type === 'textarea') {
            element = document.createElement('textarea');
            element.value = data[name] ?? '';
            element.rows = name === 'Describe' ? 5 : 3;
            element.className = `form-control input-${name}`;
        } else {
            element = document.createElement('input');
            element.type = type;
            element.value = data[name] ?? '';
            element.className = `form-control input-${name}`;
        }

        element.name = name;
        element.id = name;

        if (name === 'Quantity') {
            element.min = '1';
        }

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

    cateringReorderOrderData(orderNameForFind);
}

function cateringReorderOrderData(orderNameForFind) {
    const form = document.getElementById("catering_form_reditOrder");

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const Order_name = document.getElementById("Order_name");
        const Cod = document.getElementById("Cod");
        const Department = document.getElementById("Department");
        const Special = document.getElementById("Special");
        const Restrictions = document.getElementById("Restrictions");
        const Describe = document.getElementById("Describe");
        const Quantity = document.getElementById("Quantity");
        const Addtional_describe = document.getElementById("Addtional_describe");
        const odp = document.getElementById("catering_response");

        const fields = [
            Order_name,
            Cod,
            Department,
            Special,
            Restrictions,
            Describe,
            Quantity,
            Addtional_describe
        ];

        fields.forEach(el => {
            if (el) el.classList.remove('czerwone_obramowanie');
        });

        fields.forEach(el => {
            if (el && el.value.trim() === '') {
                el.classList.add('czerwone_obramowanie');
                flaga = false;
            }
        });

        if (Quantity && Number(Quantity.value) <= 0) {
            Quantity.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!flaga) {
            if (odp) {
                odp.textContent = "Uzupełnij wszystkie pola formularza.";
                odp.className = "fail";
            }
            return;
        }

        try {
            const formData = new FormData();

            formData.append("Order_name", Order_name.value.trim());
            formData.append("Cod", Cod.value.trim());
            formData.append("Department", Department.value.trim());
            formData.append("Special", Special.value.trim());
            formData.append("Restrictions", Restrictions.value.trim());
            formData.append("Describe", Describe.value.trim());
            formData.append("Quantity", Quantity.value.trim());
            formData.append("Addtional_describe", Addtional_describe.value.trim());
            formData.append("klucz", orderNameForFind);

            const response = await fetch("../core/edycjaZamowien/reEdycjaZamowieniaAktualizacja.php", {
                method: "POST",
                body: formData
            });

            const text = await response.text();

            let data;

            try {
                data = JSON.parse(text);
            } catch (error) {
                throw new Error("PHP nie zwróciło poprawnego JSON. Odpowiedź: " + text);
            }

            if (odp) {
                odp.textContent = data.message || "Brak komunikatu z serwera.";
                odp.className = data.success ? "success" : "fail";
            }

            if (data.success) {
                const editForm = document.getElementById("catering_form_reditOrder");

                if (editForm) {
                    editForm.remove();
                }
            }

        } catch (error) {
            if (odp) {
                odp.textContent = error.message;
                odp.className = "fail";
            }
        }
    });
}