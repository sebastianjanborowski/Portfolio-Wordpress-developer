"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "employeeUpdateSubmitButton",
        url: "../calculations/update.php",
        loadingText: "Aktualizuję pracownika...",
        successMessage: "Pracownik został zaktualizowany.",
        fields: [
            { id: "Id", label: "ID pracownika" },
            { id: "Full_Name", label: "Imię i nazwisko pracownika" },
            { id: "Subdivision", label: "Dział / jednostka organizacyjna" },
            { id: "Position", label: "Stanowisko" },
            { id: "Status", label: "Status pracownika" },
            { id: "People_Partner", label: "ID opiekuna HR / People Partner" },
            { id: "Out_of_Balance", label: "Wartość Out of Balance" }
        ]
    });
})();
