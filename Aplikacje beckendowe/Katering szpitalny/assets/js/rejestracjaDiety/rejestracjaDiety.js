// plik odpowiada za walidacje formularza i wysyłke danych na plik beckendowy
document.addEventListener('DOMContentLoaded', () => {
    katering_dodaj_diete();
});

function katering_dodaj_diete() {
    const dietAddForm = document.getElementById('dietAddForm');
    if (!dietAddForm) return;

    dietAddForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        let flaga = true;

        const dietName = document.getElementById('dietName');
        const dietCode = document.getElementById('dietCode');
        const department = document.getElementById('department');
        const isSpecialDiet = document.getElementById('isSpecialDiet');
        const dietRestrictions = document.getElementById('dietRestrictions');
        const dietDescription = document.getElementById('dietDescription');
        const dietNotes = document.getElementById('dietNotes');
        const odp = document.getElementById("odp");

        const dietNameValue = dietName.value.trim();
        const dietCodeValue = dietCode.value.trim();
        const departmentValue = department.value;
        const isSpecialDietValue = isSpecialDiet.value;
        const dietRestrictionsValue = dietRestrictions.value.trim();
        const dietDescriptionValue = dietDescription.value.trim();
        const dietNotesValue = dietNotes.value.trim();

        // czyszczenie starych błędów
        [
            dietName,
            dietCode,
            department,
            isSpecialDiet,
            dietRestrictions,
            dietDescription,
            dietNotes
        ].forEach(el => el.classList.remove('czerwone_obramowanie'));

        if (!dietNameValue || dietNameValue.length < 3) {
            dietName.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!dietCodeValue || dietCodeValue.length < 2) {
            dietCode.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!departmentValue) {
            department.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (isSpecialDietValue === '') {
            isSpecialDiet.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!dietRestrictionsValue || dietRestrictionsValue.length < 3) {
            dietRestrictions.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!dietDescriptionValue || dietDescriptionValue.length < 3) {
            dietDescription.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!dietNotesValue) {
            dietNotes.classList.add('czerwone_obramowanie');
            flaga = false;
        }

        if (!flaga) return;

        // wysyłka danych na serwer po walidacji
            try{
                const formData = new FormData();
                formData.append("dietName",dietNameValue);
                formData.append("dietCode",dietCodeValue);
                formData.append("department",departmentValue);
                formData.append("isSpecialDiet",isSpecialDietValue);
                formData.append("dietRestrictions",dietRestrictionsValue);
                formData.append("dietDescription",dietDescriptionValue);
                formData.append("dietNotes",dietNotesValue);

                // lokalizacja wysyłania danych
                const response = await fetch("/core/dodawanieDiet/addDiet.php",{
                    method: 'POST',
                    body: formData
                })

                const text = await response.text();

                let data;

                if (!response.ok) {
                    throw new Error("Błąd HTTP " + response.status + ". Odpowiedź: " + text);
                }

                try{
                    // zmienia na obiekt js
                    data = JSON.parse(text);
                }catch(error){
                    throw new Error("Php nie zwróciło porawnego rodzaju danych odpowiedz: "+text);
                }
                
                odp.textContent = data.message;
                odp.className = data.success ? "success" : "fail";

                if(data.success){
                    console.log("dane zostały przerobione jak należy");
                }

            }catch(error_zewnatrz){
                odp.textContent = error_zewnatrz.message;
                odp.className = "fail";
            }


    });
}
