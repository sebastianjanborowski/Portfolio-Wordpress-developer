document.addEventListener('DOMContentLoaded', () => {
    cateringDeleteOrder();
});

function cateringDeleteOrder() {
    const cateringDeleteOrderForm = document.getElementById("catering_delete_order_form");

    if (!cateringDeleteOrderForm) return;

    cateringDeleteOrderForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const orderInput = document.getElementById("order_code_find");
        const orderCodeValue = orderInput.value.trim();
        const cateringOdp = document.getElementById("catering_odp");

        if (orderCodeValue.length <= 1) {
            cateringOdp.textContent = "Kod zamówienia jest za krótki";
            return;
        }

        try {
            const formData = new FormData();
            formData.append('orderCode', orderCodeValue);

            const response = await fetch("../core/kasowanieZamowien/kasowanieZamowien.php", {
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
            } catch (e) {
                throw new Error("PHP nie zwrócił poprawnego JSON. Odpowiedź: " + text);
            }

            if (data.success) {
                cateringOdp.textContent = data.message;
                cateringShowDeleteOrderTable(data);
            } else {
                cateringOdp.textContent = data.message;
            }

        } catch (error) {
            cateringOdp.textContent = `Błąd: ${error.message}`;
        }
    });
}

function cateringShowDeleteOrderTable(data) {
    const container = document.getElementById("catering_container_formularz_delete_order");
    container.innerHTML = '';

    const card = document.createElement('div');
    card.id = 'catering_form_deleteOrder';
    card.className = 'diet-edit-card dashboard-card';

    const fields = {
        Order_name: 'text',
        Cod: 'text',
        Department: 'text',
        Special: 'text',
        Restrictions: 'text',
        Describe: 'textarea',
        Quantity: 'number',
        Addtional_describe: 'textarea',
        Created_at: 'date',
        is_active: 'text'
    };

    const labelsMap = {
        Order_name: 'Nazwa zamówienia',
        Cod: 'Kod zamówienia',
        Department: 'Oddział',
        Special: 'Zamówienie specjalne',
        Restrictions: 'Ograniczenia / alergeny',
        Describe: 'Opis zamówienia',
        Quantity: 'Liczba porcji',
        Addtional_describe: 'Dodatkowe uwagi',
        Created_at: 'Utworzono',
        is_active: 'Status aktywności 0 = niezatwierdzone | 1 = zatwierdzone'
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
            return String(data[name]) === '1' ? 'Zatwierdzone' : 'Niezatwierdzone';
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
        th.textContent = labelsMap[name] ?? name;

        const td = document.createElement('td');
        td.className = 'table-value-cell';

        const valueBox = document.createElement('div');
        valueBox.className = `form-control input-${name}`;

        const value = getDisplayValue(name, type);

        if (name === 'Describe' || name === 'Addtional_describe' || name === 'Restrictions') {
            valueBox.classList.add('diet-textarea');
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
    buttonDelete.id = 'cateringDeleteOrderButton';
    buttonDelete.className = 'btn btn-danger';
    buttonDelete.innerHTML = '<i class="bi bi-trash me-2"></i>Skasuj zamówienie';

    const odpBox = document.createElement('div');
    odpBox.id = 'catering_findOrderDeleteResponse';
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

    cateringCheckDeleteOrderResponse(data.Cod);
}

function cateringCheckDeleteOrderResponse(orderCode) {
    const deleteButton = document.getElementById("cateringDeleteOrderButton");

    if (!deleteButton) return;

    deleteButton.addEventListener('click', () => {
        cateringDeleteOrderSend(orderCode);
    });
}

async function cateringDeleteOrderSend(orderCode) {
    const cateringFindOrderDeleteResponse = document.getElementById("catering_findOrderDeleteResponse");
    const cateringOdpResponse = document.getElementById("catering_odp");

    try {
        const formData = new FormData();
        formData.append('deleteOrderCode', orderCode);

        const response = await fetch("../core/kasowanieZamowien/kasowanieZamowien.php", {
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

            const container = document.getElementById("catering_container_formularz_delete_order");
            container.style.display = 'none';
            container.innerHTML = '';
        } else {
            cateringOdpResponse.textContent = `Błąd: ${data.message}`;
        }

    } catch (error) {
        cateringFindOrderDeleteResponse.textContent = `Błąd serwera: ${error.message}`;
    }
}