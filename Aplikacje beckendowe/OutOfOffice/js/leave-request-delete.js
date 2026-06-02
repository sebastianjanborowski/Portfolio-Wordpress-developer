"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "leaveDeleteSubmitButton",
        url: "../calculations/deleteLeaveRequest.php",
        loadingText: "Usuwam wniosek urlopowy...",
        successMessage: "Wniosek urlopowy został usunięty.",
        fields: [
            { id: "Id", label: "ID wniosku" }
        ]
    });
})();
