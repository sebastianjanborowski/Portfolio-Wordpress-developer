"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "approvalCreateSubmitButton",
        url: "../calculations/addApprover_Request.php",
        loadingText: "Dodaję zatwierdzenie...",
        successMessage: "Wniosek o zatwierdzenie został dodany.",
        fields: [
            { id: "Approver", label: "ID osoby zatwierdzającej" },
            { id: "Leave_Request", label: "ID wniosku urlopowego" },
            { id: "Status", label: "Status zatwierdzenia" },
            { id: "Comment", label: "Komentarz do zatwierdzenia" }
        ]
    });
})();
