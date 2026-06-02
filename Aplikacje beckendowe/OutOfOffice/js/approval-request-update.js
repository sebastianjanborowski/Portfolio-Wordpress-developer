"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "approvalUpdateSubmitButton",
        url: "../calculations/updateApprover_Request.php",
        loadingText: "Aktualizuję zatwierdzenie...",
        successMessage: "Wniosek o zatwierdzenie został zaktualizowany.",
        fields: [
            { id: "Id", label: "ID zatwierdzenia" },
            { id: "Approver", label: "ID osoby zatwierdzającej" },
            { id: "Leave_Request", label: "ID wniosku urlopowego" },
            { id: "Status", label: "Status zatwierdzenia" },
            { id: "Comment", label: "Komentarz do zatwierdzenia" }
        ]
    });
})();
