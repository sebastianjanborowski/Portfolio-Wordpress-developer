"use strict";

window.OutOfOfficeForm = (() => {
    function getInput(id) {
        return document.getElementById(id);
    }

    function getValue(id) {
        const input = getInput(id);
        return input ? input.value.trim() : "";
    }

    function clearFieldErrors(fields) {
        fields.forEach((field) => {
            const input = getInput(field.id);
            if (!input) {
                return;
            }

            input.classList.remove("is-invalid");

            const parent = input.closest(".mb-3") || input.parentElement;
            const oldError = parent ? parent.querySelector(".field-error") : null;

            if (oldError) {
                oldError.remove();
            }
        });
    }

    function showFieldError(field, message) {
        const input = getInput(field.id);
        if (!input) {
            return;
        }

        input.classList.add("is-invalid");

        const parent = input.closest(".mb-3") || input.parentElement;

        if (!parent) {
            return;
        }

        const error = document.createElement("div");
        error.className = "field-error";
        error.textContent = message;

        parent.appendChild(error);
    }

    function showMessage(type, message) {
        const box = document.getElementById("formMessage");

        if (!box) {
            return;
        }

        box.className = "form-message is-visible " + type;
        box.innerHTML = message;
    }

    function hideMessage() {
        const box = document.getElementById("formMessage");

        if (!box) {
            return;
        }

        box.className = "form-message";
        box.textContent = "";
    }

    function validateRequired(fields) {
        clearFieldErrors(fields);

        const missing = [];

        fields.forEach((field) => {
            const value = getValue(field.id);

            if (!value) {
                missing.push(field);
                showFieldError(field, "To pole jest wymagane: " + field.label + ".");
            }
        });

        if (missing.length > 0) {
            const list = missing.map((field) => "<li>" + field.label + "</li>").join("");

            showMessage(
                "warning",
                "<strong>Brakuje wymaganych danych.</strong><br>Uzupełnij poniższe pola:<ul class=\"mb-0 mt-2\">" + list + "</ul>"
            );

            const firstInput = getInput(missing[0].id);

            if (firstInput) {
                firstInput.focus();
            }

            return false;
        }

        hideMessage();
        return true;
    }

    async function sendJson(url, payload) {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        let data = {};

        try {
            data = await response.json();
        } catch (error) {
            data = {};
        }

        if (!response.ok) {
            const serverMessage = data.message ? data.message : "Serwer odrzucił żądanie.";
            throw new Error(serverMessage);
        }

        if (data.status && data.status === "error") {
            throw new Error(data.message || "Operacja nie została wykonana.");
        }

        return data;
    }

    function setButtonLoading(button, isLoading, loadingText) {
        if (!button) {
            return;
        }

        if (isLoading) {
            button.dataset.defaultText = button.textContent;
            button.textContent = loadingText || "Przetwarzanie...";
            button.classList.add("is-loading");
            button.disabled = true;
        } else {
            button.textContent = button.dataset.defaultText || button.textContent;
            button.classList.remove("is-loading");
            button.disabled = false;
        }
    }

    function bindJsonForm(config) {
        const button = document.getElementById(config.buttonId);

        if (!button) {
            return;
        }

        button.addEventListener("click", async (event) => {
            event.preventDefault();

            const requiredFields = config.fields.filter((field) => field.required !== false);

            if (!validateRequired(requiredFields)) {
                return;
            }

            const payload = {};

            config.fields.forEach((field) => {
                payload[field.id] = getValue(field.id);
            });

            try {
                setButtonLoading(button, true, config.loadingText);
                const data = await sendJson(config.url, payload);

                if (typeof config.isSuccess === "function" && !config.isSuccess(data)) {
                    showMessage("error", "<strong>Nie wykonano operacji.</strong> " + (config.failureMessage || data.message || "Sprawdź wprowadzone dane."));
                    return;
                }

                if (data.redirect) {
                    showMessage("success", "<strong>Sukces.</strong> Przekierowuję do kolejnego widoku...");
                    window.location.href = data.redirect;
                    return;
                }

                const message = config.showServerMessage && data.message ? data.message : config.successMessage;
                showMessage("success", "<strong>Sukces.</strong> " + message);
            } catch (error) {
                showMessage("error", "<strong>Nie wykonano operacji.</strong> " + error.message);
            } finally {
                setButtonLoading(button, false);
            }
        });
    }

    return {
        bindJsonForm: bindJsonForm,
        showMessage: showMessage,
        hideMessage: hideMessage,
        validateRequired: validateRequired,
        getValue: getValue,
        sendJson: sendJson
    };
})();
