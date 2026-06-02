"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "leaveCreateSubmitButton",
        url: "../calculations/addLeaveRequest.php",
        loadingText: "Dodaję wniosek urlopowy...",
        successMessage: "Wniosek urlopowy został dodany.",
        fields: [
            { id: "Employee", label: "ID pracownika" },
            { id: "Absense_Reason", label: "Powód nieobecności" },
            { id: "Start_Date", label: "Data rozpoczęcia urlopu" },
            { id: "End_Date", label: "Data zakończenia urlopu" },
            { id: "Comment", label: "Komentarz do wniosku" },
            { id: "Status", label: "Status wniosku" }
        ]
    });
})();
