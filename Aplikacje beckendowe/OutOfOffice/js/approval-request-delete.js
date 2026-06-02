"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "approvalDeleteSubmitButton",
        url: "../calculations/deleteApprover_Request.php",
        loadingText: "Usuwam zatwierdzenie...",
        successMessage: "Wniosek o zatwierdzenie został usunięty.",
        fields: [
            { id: "Id", label: "ID zatwierdzenia" }
        ]
    });
})();
