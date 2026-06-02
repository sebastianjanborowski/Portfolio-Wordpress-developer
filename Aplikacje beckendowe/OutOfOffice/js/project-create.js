"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "projectCreateSubmitButton",
        url: "../calculations/addProject.php",
        loadingText: "Dodaję projekt...",
        successMessage: "Projekt został dodany.",
        fields: [
            { id: "Project_Type", label: "Typ / nazwa projektu" },
            { id: "Start_Date", label: "Data rozpoczęcia projektu" },
            { id: "End_Date", label: "Data zakończenia projektu" },
            { id: "Project_Manager", label: "ID kierownika projektu" },
            { id: "Comment", label: "Komentarz do projektu" },
            { id: "Status", label: "Status projektu" }
        ]
    });
})();
