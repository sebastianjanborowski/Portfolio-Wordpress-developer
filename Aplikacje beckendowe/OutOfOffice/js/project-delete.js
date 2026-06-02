"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "projectDeleteSubmitButton",
        url: "../calculations/deleteProject.php",
        loadingText: "Usuwam projekt...",
        successMessage: "Projekt został usunięty.",
        fields: [
            { id: "Id", label: "ID projektu" }
        ]
    });
})();
