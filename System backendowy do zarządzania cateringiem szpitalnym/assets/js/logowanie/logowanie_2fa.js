// medioum analogiczne jak w logowaniu tylko do innego miejsca docelowego
document.addEventListener('DOMContentLoaded', () => {
    katering_logowanie_2fa();
});

function katering_logowanie_2fa() {

    const codeForm = document.getElementById("codeForm");
    if (!codeForm) {
        return;
    }

    codeForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const code = document.getElementById("code").value.trim();
        const resultBox = document.getElementById("resultBox");

        resultBox.textContent = "";
        resultBox.className = "";

        if (code.length == 6) {
            try {
                const formData = new FormData();
                formData.append("code", code);

                const response = await fetch("/core/logowanie/verify-code.php", {
                    method: 'POST',
                    credentials:'same-origin',
                    body: formData
                });

                const text = await response.text();
                console.log("RAW RESPONSE:", text);

                let data;

                try {
                    data = JSON.parse(text);
                } catch (error) {
                    throw new Error("PHP nie zwróciło poprawnego JSON. Odpowiedź: " + text);
                }

                resultBox.textContent = data.message;
                resultBox.className = data.success ? "success" : "fail";

                if (data.success && data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }

            } catch (error) {
                resultBox.textContent = error.message;
                resultBox.className = "fail";
                console.error("Błąd:", error);
            }
        } else {
            resultBox.textContent = "Kod powinien posiadać 6 znaków";
            resultBox.className = "fail";
        }
    });
}