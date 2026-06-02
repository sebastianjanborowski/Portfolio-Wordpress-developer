"use strict";

(() => {
    window.OutOfOfficeForm.bindJsonForm({
        buttonId: "loginSubmitButton",
        url: "../calculations/form.php",
        loadingText: "Sprawdzam dane logowania...",
        successMessage: "Zalogowano poprawnie.",
        failureMessage: "Nieprawidłowy login lub hasło. Sprawdź dane i spróbuj ponownie.",
        isSuccess: (data) => Boolean(data.redirect),
        fields: [
            { id: "login", label: "Login użytkownika" },
            { id: "password", label: "Hasło użytkownika" }
        ]
    });
})();
