document.addEventListener('DOMContentLoaded',() => {
    cateringEditDiet();
});

function cateringEditDiet(){
    var catering_edit_diet_formID = document.getElementById("catering_edit_diet_form");
    
    if(!catering_edit_diet_formID) return;

    catering_edit_diet_formID.addEventListener("submit",async (e) => {
        e.preventDefault();

        var diet_id = document.getElementById("diet_name_find");
        var diet_id_value = diet_id.value.trim();
        var catering_odp = document.getElementById("catering_odp");

        if(diet_id_value.length > 1){
            try{
                const formData = new FormData();
                formData.append('nazwaDiety', diet_id_value)

                const response = await fetch("../core/edycjaDiety/edycjaDiety.php",{
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


                // prawidłowa validacja przechodzimy dalej
                if(data.success){
                    catering_odp.textContent = `Znaleziono szukaną diete w bazie danych`;
                    var odebraneDaneDiety = data;
                    cateringEditDataDiet(odebraneDaneDiety);
                    
                }else{
                    catering_odp.textContent = ` ${data.message}`;
                }


            }catch(error){
                
                catering_odp.textContent = `Błąd: ${error}`;
            }
        }else{
            catering_odp.textContent = "Nazwa diety jest za któtka";
        }
    });
}

function cateringEditDataDiet(data) {
    const container = document.getElementById("catering_container_formularz_edit");
    container.innerHTML = '';

    const form = document.createElement('form');
    const department_number = parseInt(data.department_id);
    const name_diet_for_find = data.diet_name;

    form.method = 'POST';
    form.id = 'catering_form_reditDiet';
    form.className = 'diet-edit-card dashboard-card';

    const fields = {
        department: 'select',
        diet_name: 'text',
        diet_code: 'text',
        is_special_diet: 'number',
        diet_restrictions: 'text',
        diet_description: 'textarea',
        diet_notes: 'textarea',
    };

    const labelsMap = {
        department: 'Dział / oddział',
        diet_name: 'Nazwa diety',
        diet_code: 'Kod diety',
        is_special_diet: 'Czy dieta specjalna',
        diet_restrictions: 'Ograniczenia / alergeny',
        diet_description: 'Opis diety',
        diet_notes: 'Uwagi dodatkowe',
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

    const row = document.createElement('div');
    row.className = 'row g-3';

    Object.entries(fields).forEach(([name, type]) => {
        const col = document.createElement('div');

        if (name === 'diet_restrictions' || name === 'diet_description' || name === 'diet_notes') {
            col.className = 'col-12';
        } else {
            col.className = 'col-12 col-md-6 col-lg-6';
        }

        const wrapper = document.createElement('div');
        wrapper.className = `form-group mb-0 form-group-${name}`;

        const label = document.createElement('label');
        label.htmlFor = name;
        label.className = 'form-label-custom';
        label.textContent = labelsMap[name] ?? name.replaceAll('_', ' ');

        let element;

        if (name === 'department') {
            element = document.createElement('select');
            element.className = `form-control input-${name}`;

            departmentOptions.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;

                if (parseInt(optionData.value) === department_number) {
                    option.selected = true;
                }

                element.appendChild(option);
            });
        } else if (type === 'textarea') {
            element = document.createElement('textarea');
            element.value = data[name] ?? '';
            element.rows = name === 'diet_description' ? 5 : 3;
            element.className = `form-control input-${name}`;
        } else {
            element = document.createElement('input');
            element.type = type;

            if (type === 'date') {
                element.value = formatDateForInput(data[name]);
            } else {
                element.value = data[name] ?? '';
            }

            element.className = `form-control input-${name}`;
        }

        element.name = name;
        element.id = name;

        if (name === 'diet_description' || name === 'diet_notes') {
            element.classList.add('diet-textarea');
        }

        if (name === 'is_special_diet' || name === 'is_active') {
            element.min = '0';
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
    
    catering_reorder_data(name_diet_for_find);
}

function catering_reorder_data(name_diet_for_find) {
    const form = document.getElementById("catering_form_reditDiet");
    console.log("Szukany klucz diety:", name_diet_for_find);

    if (!form) {
        console.log("Brak formularza");
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const department = document.getElementById("department");
        const diet_name = document.getElementById("diet_name");
        const diet_code = document.getElementById("diet_code");
        const is_special_diet = document.getElementById("is_special_diet");
        const diet_restrictions = document.getElementById("diet_restrictions");
        const diet_description = document.getElementById("diet_description");
        const diet_notes = document.getElementById("diet_notes");
        const odp = document.getElementById("catering_response");

        const pola = [
            department,
            diet_name,
            diet_code,
            is_special_diet,
            diet_restrictions,
            diet_description,
            diet_notes
        ];

        // czyszczenie starych błędów
        pola.forEach(el => {
            if (el) el.classList.remove('czerwone_obramowanie');
        });

        // walidacja
        pola.forEach(el => {
            if (el && el.value.trim() === '') {
                el.classList.add('czerwone_obramowanie');
                flaga = false;
            }
        });

        if (!flaga) {
            if (odp) {
                odp.textContent = "Uzupełnij wszystkie pola formularza.";
                odp.className = "fail";
            }
            return;
        }

        try {
            const formData = new FormData();
            formData.append("department", department.value.trim());
            formData.append("diet_name", diet_name.value.trim());
            formData.append("diet_code", diet_code.value.trim());
            formData.append("is_special_diet", is_special_diet.value.trim());
            formData.append("diet_restrictions", diet_restrictions.value.trim());
            formData.append("diet_description", diet_description.value.trim());
            formData.append("diet_notes", diet_notes.value.trim());
            formData.append("klucz", name_diet_for_find);

            const response = await fetch("../core/edycjaDiety/reEdycjaDietyAktualizacja.php", {
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
                const catering_form_reditDiet = document.getElementById("catering_form_reditDiet");

                if(catering_form_reditDiet){
                    catering_form_reditDiet.remove();
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