"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "employeeDeleteSubmitButton",
        url: "../calculations/delete.php",
        loadingText: "Usuwam pracownika...",
        successMessage: "Pracownik został usunięty.",
        fields: [
            { id: "Id", label: "ID pracownika" }
        ]
    });
})();
