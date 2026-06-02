"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "leaveUpdateSubmitButton",
        url: "../calculations/updateLeaveRequest.php",
        loadingText: "Aktualizuję wniosek urlopowy...",
        successMessage: "Wniosek urlopowy został zaktualizowany.",
        fields: [
            { id: "Id", label: "ID wniosku" },
            { id: "Employee", label: "ID pracownika" },
            { id: "Absense_Reason", label: "Powód nieobecności" },
            { id: "Start_Date", label: "Data rozpoczęcia urlopu" },
            { id: "End_Date", label: "Data zakończenia urlopu" },
            { id: "Comment", label: "Komentarz do wniosku" },
            { id: "Status", label: "Status wniosku" }
        ]
    });
})();
