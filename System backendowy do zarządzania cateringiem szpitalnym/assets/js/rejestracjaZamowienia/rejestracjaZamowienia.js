// plik odpowiada za walidację formularza i wysyłkę danych do pliku backendowego
document.addEventListener('DOMContentLoaded', () => {
    katering_dodaj_zamowienie();
});

function katering_dodaj_zamowienie() {
    const orderAddForm = document.getElementById('orderAddForm');
    if (!orderAddForm) return;

    orderAddForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const orderName = document.getElementById('orderName');
        const orderCode = document.getElementById('orderCode');
        const department = document.getElementById('department');
        const special = document.getElementById('special');
        const quantity = document.getElementById('quantity');
        const restrictions = document.getElementById('restrictions');
        const description = document.getElementById('description');
        const additionalDescription = document.getElementById('additionalDescription');
        const odp = document.getElementById('odp');

        const orderNameValue = orderName.value.trim();
        const orderCodeValue = orderCode.value.trim();
        const departmentValue = department.value;
        const specialValue = special.value;
        const quantityValue = quantity.value.trim();
        const restrictionsValue = restrictions.value.trim();
        const descriptionValue = description.value.trim();
        const additionalDescriptionValue = additionalDescription.value.trim();

        [
            orderName,
            orderCode,
            department,
            special,
            quantity,
            restrictions,
            description,
            additionalDescription
        ].forEach(el => el.classList.remove('czerwone_obramowanie'));

        if (!orderNameValue || orderNameValue.length < 3) {
            orderName.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!orderCodeValue || orderCodeValue.length < 2) {
            orderCode.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!departmentValue) {
            department.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (specialValue === '') {
            special.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!quantityValue || Number(quantityValue) <= 0) {
            quantity.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!restrictionsValue || restrictionsValue.length < 3) {
            restrictions.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!descriptionValue || descriptionValue.length < 3) {
            description.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!additionalDescriptionValue) {
            additionalDescription.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!flaga) return;

        try {
            const formData = new FormData();

            formData.append('orderName', orderNameValue);
            formData.append('orderCode', orderCodeValue);
            formData.append('department', departmentValue);
            formData.append('special', specialValue);
            formData.append('quantity', quantityValue);
            formData.append('restrictions', restrictionsValue);
            formData.append('description', descriptionValue);
            formData.append('additionalDescription', additionalDescriptionValue);

            const response = await fetch('/core/dodawanieZamowien/addOrder.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();

            if (!response.ok) {
                throw new Error('Błąd HTTP ' + response.status + '. Odpowiedź: ' + text);
            }

            let data;

            try {
                data = JSON.parse(text);
            } catch (error) {
                throw new Error('PHP nie zwróciło poprawnego JSON. Odpowiedź: ' + text);
            }

            odp.textContent = data.message;
            odp.className = data.success ? 'success' : 'fail';

            if (data.success) {
                orderAddForm.reset();
            }

        } catch (error_zewnatrz) {
            odp.textContent = error_zewnatrz.message;
            odp.className = 'fail';
        }
    });
}