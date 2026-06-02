(() => {
  "use strict";

  const STORAGE_KEYS = {
    theme: "kg_theme",
    history: "kg_history"
  };

  /*
    ZASADA OBLICZEŃ:
    1. Najpierw sumujemy wartości liter w każdym systemie osobno.
    2. Następnie redukujemy sumę przez sumowanie cyfr.
    3. Jeżeli na którymkolwiek etapie pojawi się liczba specjalna, np. 11, 22, 33,
       redukcja zatrzymuje się. Nie redukujemy już dalej do 2, 4, 6 itd.
    4. Dla tekstu "Sebastian Jan Borowski" wynik końcowy ma być:
       Gematric 11, Nous 11, Psyche 11, Soma 11.
  */

  const SPECIAL_NUMBERS = new Set([
    6, 11, 22, 28, 33, 44, 55, 66, 77, 88, 99,
    111, 222, 333, 444, 496, 555, 666, 777, 888, 999,
    1111, 2222, 8128
  ]);

  const PERFECT_NUMBERS = new Set([6, 28, 496, 8128]);

  const SYSTEMS = [
    { key: "gematric", label: "Gematric" },
    { key: "nous", label: "Nous" },
    { key: "psyche", label: "Psyche" },
    { key: "soma", label: "Soma" }
  ];

  const EXAMPLES = [
    "Sebastian Jan Borowski",
    "Kalkulator Gematryczny",
    "Projekt do portfolio",
    "Czysty JavaScript",
    "Analiza tekstu"
  ];

  const ALPHABET = "abcdefghijklmnopqrstuvwxyz".split("");
  const LETTER_VALUES = buildLetterValues();

  const elements = {
    html: document.documentElement,
    navToggle: document.querySelector(".nav-toggle"),
    navMenu: document.querySelector("#mainMenu"),
    themeToggle: document.querySelector("#themeToggle"),
    form: document.querySelector("#gematriaForm"),
    textInput: document.querySelector("#textInput"),
    charCounter: document.querySelector("#charCounter"),
    formMessage: document.querySelector("#formMessage"),
    sampleButton: document.querySelector("#sampleButton"),
    clearButton: document.querySelector("#clearButton"),
    results: document.querySelector("#results"),
    resultTitle: document.querySelector("#resultTitle"),
    summaryCards: document.querySelector("#summaryCards"),
    cyclePanel: document.querySelector("#cyclePanel"),
    reductionsPanel: document.querySelector("#reductionsPanel"),
    reductionsTableBody: document.querySelector("#reductionsTableBody"),
    lettersPanel: document.querySelector("#lettersPanel"),
    lettersTableBody: document.querySelector("#lettersTableBody"),
    lettersTableFoot: document.querySelector("#lettersTableFoot"),
    copyResultButton: document.querySelector("#copyResultButton"),
    downloadResultButton: document.querySelector("#downloadResultButton"),
    printButton: document.querySelector("#printButton"),
    historyList: document.querySelector("#historyList"),
    clearHistoryButton: document.querySelector("#clearHistoryButton"),
    toast: document.querySelector("#toast"),
    currentYear: document.querySelector("#currentYear")
  };

  let currentResult = null;
  let toastTimeout = null;

  document.addEventListener("DOMContentLoaded", init);

  function init() {
    elements.currentYear.textContent = String(new Date().getFullYear());
    applySavedTheme();
    bindEvents();
    updateCounter();
    renderHistory();
  }

  function bindEvents() {
    elements.navToggle.addEventListener("click", toggleMenu);

    elements.navMenu.addEventListener("click", (event) => {
      if (event.target.matches("a")) {
        closeMenu();
      }
    });

    elements.themeToggle.addEventListener("click", toggleTheme);
    elements.textInput.addEventListener("input", updateCounter);
    elements.form.addEventListener("submit", handleSubmit);
    elements.sampleButton.addEventListener("click", insertSample);
    elements.clearButton.addEventListener("click", clearForm);
    elements.copyResultButton.addEventListener("click", copyCurrentResult);
    elements.downloadResultButton.addEventListener("click", downloadCurrentResult);
    elements.printButton.addEventListener("click", () => window.print());
    elements.clearHistoryButton.addEventListener("click", clearHistory);
  }

  function buildLetterValues() {
    return ALPHABET.map((letter, index) => {
      const alphabetPosition = index + 1;

      return {
        letter,
        gematric: alphabetPosition,
        nous: 100 + index,
        psyche: alphabetPosition,
        soma: (index % 9) + 1
      };
    });
  }

  function normalizeText(text) {
    return text
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .replace(/ł/g, "l")
      .replace(/[^a-z]/g, "");
  }

  function calculateGematria(rawText) {
    const normalized = normalizeText(rawText);
    const letters = normalized.split("");

    const rawSums = createEmptySystemObject(0);

    const letterRows = letters.map((letter, index) => {
      const values = LETTER_VALUES.find((entry) => entry.letter === letter);

      if (!values) {
        return null;
      }

      SYSTEMS.forEach((system) => {
        rawSums[system.key] += values[system.key];
      });

      return {
        index: index + 1,
        letter,
        gematric: values.gematric,
        nous: values.nous,
        psyche: values.psyche,
        soma: values.soma
      };
    }).filter(Boolean);

    const finalValues = {};
    const reductions = SYSTEMS.map((system) => {
      const reduction = reduceWithSpecialStop(rawSums[system.key]);

      finalValues[system.key] = reduction.finalValue;

      return {
        system: system.key,
        rawValue: rawSums[system.key],
        finalValue: reduction.finalValue,
        trace: reduction.trace,
        classification: classifyNumber(reduction.finalValue),
        isSpecial: SPECIAL_NUMBERS.has(reduction.finalValue)
      };
    });

    const cycle = getSomaCycle(letterRows);

    return {
      rawText: rawText.trim(),
      normalizedText: normalized,
      rawSums,
      finalValues,
      reductions,
      letters: letterRows,
      cycle,
      createdAt: new Date().toISOString()
    };
  }

  function createEmptySystemObject(defaultValue) {
    return SYSTEMS.reduce((object, system) => {
      object[system.key] = defaultValue;
      return object;
    }, {});
  }

  function reduceWithSpecialStop(number) {
    let current = Math.abs(Number(number));
    const trace = [current];

    if (!Number.isFinite(current)) {
      return {
        finalValue: 0,
        trace: [0]
      };
    }

    if (SPECIAL_NUMBERS.has(current)) {
      return {
        finalValue: current,
        trace
      };
    }

    while (current > 9) {
      current = sumDigits(current);
      trace.push(current);

      if (SPECIAL_NUMBERS.has(current)) {
        break;
      }
    }

    return {
      finalValue: current,
      trace
    };
  }

  function sumDigits(number) {
    return String(Math.abs(Number(number)))
      .split("")
      .reduce((sum, digit) => sum + Number(digit), 0);
  }

  function classifyNumber(number) {
    if (SPECIAL_NUMBERS.has(number)) {
      if (PERFECT_NUMBERS.has(number)) {
        return "liczba specjalna / doskonała";
      }

      return "liczba specjalna / mistrzowska";
    }

    if (number % 2 === 0) {
      return "liczba zwykła parzysta";
    }

    return "liczba zwykła nieparzysta";
  }

  function getSomaCycle(letterRows) {
    if (letterRows.length === 0) {
      return {
        type: "brak",
        label: "Brak cyklu",
        description: "Brak liter do analizy.",
        first: null,
        last: null
      };
    }

    const first = letterRows[0].soma;
    const last = letterRows[letterRows.length - 1].soma;

    if (first < last) {
      return {
        type: "growth",
        label: "Cykl wzrostowy",
        description: `Pierwsza litera ma wartość Soma ${first}, a ostatnia ${last}. Kierunek przechodzi od mniejszej wartości do większej.`,
        first,
        last
      };
    }

    if (first > last) {
      return {
        type: "decline",
        label: "Cykl spadkowy",
        description: `Pierwsza litera ma wartość Soma ${first}, a ostatnia ${last}. Kierunek przechodzi od większej wartości do mniejszej.`,
        first,
        last
      };
    }

    return {
      type: "stagnation",
      label: "Cykl stagnacyjny",
      description: `Pierwsza i ostatnia litera mają tę samą wartość Soma: ${first}.`,
      first,
      last
    };
  }

  function handleSubmit(event) {
    event.preventDefault();

    const rawText = elements.textInput.value.trim();
    const normalizedText = normalizeText(rawText);

    if (!rawText) {
      showFormMessage("Wpisz tekst do obliczenia. Pole nie może być puste.", "error");
      elements.textInput.focus();
      return;
    }

    if (normalizedText.length === 0) {
      showFormMessage("Tekst musi zawierać przynajmniej jedną literę. Same cyfry i znaki specjalne nie są obliczane.", "error");
      elements.textInput.focus();
      return;
    }

    currentResult = calculateGematria(rawText);
    renderResult(currentResult);
    saveToHistory(currentResult);
    renderHistory();
    showFormMessage("Wynik został obliczony poprawnie. Redukcja zatrzymała się na liczbach specjalnych, jeżeli wystąpiły.", "success");
    showToast("Analiza zakończona poprawnie.");
    elements.results.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  function renderResult(result) {
    const selectedModes = getSelectedModes();

    elements.results.hidden = false;
    elements.resultTitle.textContent = `Wyniki dla: ${result.rawText}`;

    elements.summaryCards.innerHTML = SYSTEMS
      .map((system) => {
        const finalValue = result.finalValues[system.key];
        const isSpecial = SPECIAL_NUMBERS.has(finalValue);

        return `
          <article class="result-card ${isSpecial ? "result-card--special" : ""}">
            <span>${system.label}</span>
            <strong>${finalValue}</strong>
            <small>${isSpecial ? "liczba specjalna — redukcja zatrzymana" : "wynik końcowy po redukcji"}</small>
          </article>
        `;
      })
      .join("");

    renderCycle(result.cycle);

    elements.reductionsPanel.hidden = !selectedModes.includes("reductions");
    elements.lettersPanel.hidden = !selectedModes.includes("letters");

    elements.reductionsTableBody.innerHTML = result.reductions
      .map((row) => `
        <tr>
          <td>${formatSystemName(row.system)}</td>
          <td>${row.rawValue}</td>
          <td>${row.trace.join(" → ")}</td>
          <td><strong>${row.finalValue}</strong></td>
          <td>
            <span class="badge ${row.isSpecial ? "badge--special" : ""}">
              ${row.classification}
            </span>
          </td>
        </tr>
      `)
      .join("");

    elements.lettersTableBody.innerHTML = result.letters
      .map((row) => `
        <tr>
          <td>${row.index}</td>
          <td>${row.letter.toUpperCase()}</td>
          <td>${row.gematric}</td>
          <td>${row.nous}</td>
          <td>${row.psyche}</td>
          <td>${row.soma}</td>
        </tr>
      `)
      .join("");

    elements.lettersTableFoot.innerHTML = `
      <tr class="sum-row">
        <td colspan="2">SUMA SUROWA</td>
        <td>${result.rawSums.gematric}</td>
        <td>${result.rawSums.nous}</td>
        <td>${result.rawSums.psyche}</td>
        <td>${result.rawSums.soma}</td>
      </tr>
      <tr class="final-row">
        <td colspan="2">WYNIK KOŃCOWY</td>
        <td>${result.finalValues.gematric}</td>
        <td>${result.finalValues.nous}</td>
        <td>${result.finalValues.psyche}</td>
        <td>${result.finalValues.soma}</td>
      </tr>
    `;
  }

  function renderCycle(cycle) {
    if (!elements.cyclePanel) {
      return;
    }

    const badgeClass = {
      growth: "badge--special",
      decline: "badge--warning",
      stagnation: "badge--neutral",
      brak: "badge--neutral"
    }[cycle.type] || "badge--neutral";

    elements.cyclePanel.innerHTML = `
      <div class="cycle-card">
        <div>
          <span class="eyebrow">Cykl Soma</span>
          <h3>${cycle.label}</h3>
          <p>${cycle.description}</p>
        </div>
        <div class="cycle-card__values" aria-label="Zakres cyklu Soma">
          <span class="badge ${badgeClass}">Start: ${cycle.first ?? "-"}</span>
          <span class="badge ${badgeClass}">Koniec: ${cycle.last ?? "-"}</span>
        </div>
      </div>
    `;
  }

  function getSelectedModes() {
    return Array.from(document.querySelectorAll('input[name="resultMode"]:checked'))
      .map((input) => input.value);
  }

  function formatSystemName(system) {
    const found = SYSTEMS.find((item) => item.key === system);
    return found ? found.label : system;
  }

  function showFormMessage(message, type) {
    elements.formMessage.textContent = message;
    elements.formMessage.className = `message message--${type}`;
  }

  function clearForm() {
    elements.form.reset();
    elements.textInput.value = "";
    elements.results.hidden = true;
    elements.summaryCards.innerHTML = "";
    elements.reductionsTableBody.innerHTML = "";
    elements.lettersTableBody.innerHTML = "";
    elements.lettersTableFoot.innerHTML = "";
    elements.formMessage.textContent = "";
    elements.formMessage.className = "message";
    currentResult = null;
    updateCounter();
    elements.textInput.focus();
  }

  function insertSample() {
    const sample = EXAMPLES[Math.floor(Math.random() * EXAMPLES.length)];
    elements.textInput.value = sample;
    updateCounter();
    elements.textInput.focus();
    showToast("Wstawiono przykładowy tekst.");
  }

  function updateCounter() {
    elements.charCounter.textContent = String(elements.textInput.value.length);
  }

  async function copyCurrentResult() {
    if (!currentResult) {
      showToast("Najpierw oblicz wynik.");
      return;
    }

    const text = buildPlainTextResult(currentResult);

    try {
      await navigator.clipboard.writeText(text);
      showToast("Wynik został skopiowany do schowka.");
    } catch {
      showToast("Nie udało się skopiować wyniku. Przeglądarka zablokowała schowek.");
    }
  }

  function downloadCurrentResult() {
    if (!currentResult) {
      showToast("Najpierw oblicz wynik.");
      return;
    }

    const blob = new Blob([JSON.stringify(currentResult, null, 2)], {
      type: "application/json"
    });

    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = `wynik-gematryczny-${Date.now()}.json`;
    document.body.appendChild(link);
    link.click();
    link.remove();
    URL.revokeObjectURL(url);
  }

  function buildPlainTextResult(result) {
    const finalLines = SYSTEMS.map((system) => {
      return `${system.label}: ${result.finalValues[system.key]} | suma surowa: ${result.rawSums[system.key]}`;
    });

    return [
      `Tekst: ${result.rawText}`,
      `Tekst znormalizowany: ${result.normalizedText}`,
      "",
      "Wyniki końcowe:",
      ...finalLines,
      "",
      `${result.cycle.label}: ${result.cycle.description}`
    ].join("\n");
  }

  function saveToHistory(result) {
    const history = getHistory();
    const compactResult = {
      rawText: result.rawText,
      rawSums: result.rawSums,
      finalValues: result.finalValues,
      cycle: result.cycle,
      createdAt: result.createdAt
    };

    const nextHistory = [compactResult, ...history]
      .filter((item, index, array) => array.findIndex((entry) => entry.rawText === item.rawText) === index)
      .slice(0, 8);

    localStorage.setItem(STORAGE_KEYS.history, JSON.stringify(nextHistory));
  }

  function getHistory() {
    try {
      const raw = localStorage.getItem(STORAGE_KEYS.history);
      const parsed = raw ? JSON.parse(raw) : [];
      return parsed.filter((item) => item && item.rawText);
    } catch {
      return [];
    }
  }

  function renderHistory() {
    const history = getHistory();

    if (history.length === 0) {
      elements.historyList.innerHTML = `
        <div class="panel">
          <p>Brak zapisanych analiz. Wykonaj pierwsze obliczenie, aby zobaczyć historię.</p>
        </div>
      `;
      return;
    }

    elements.historyList.innerHTML = history
      .map((item, index) => {
        const values = item.finalValues || item.summary || createEmptySystemObject("-");
        const cycleLabel = item.cycle?.label || item.cycle || "Brak cyklu";

        return `
          <article class="history-item">
            <div>
              <strong>${escapeHtml(item.rawText)}</strong>
              <span>
                Gematric: ${values.gematric} · Nous: ${values.nous} · Psyche: ${values.psyche} · Soma: ${values.soma}
              </span>
              <small>${escapeHtml(cycleLabel)}</small>
            </div>
            <div class="history-actions">
              <button class="btn btn--ghost btn--small" type="button" data-history-index="${index}">Wczytaj</button>
            </div>
          </article>
        `;
      })
      .join("");

    elements.historyList.querySelectorAll("[data-history-index]").forEach((button) => {
      button.addEventListener("click", () => {
        const index = Number(button.dataset.historyIndex);
        const item = history[index];

        if (!item) {
          return;
        }

        elements.textInput.value = item.rawText;
        updateCounter();
        elements.form.requestSubmit();
      });
    });
  }

  function clearHistory() {
    localStorage.removeItem(STORAGE_KEYS.history);
    renderHistory();
    showToast("Historia została wyczyszczona.");
  }

  function toggleTheme() {
    const current = elements.html.dataset.theme === "dark" ? "dark" : "light";
    const next = current === "dark" ? "light" : "dark";
    elements.html.dataset.theme = next;
    localStorage.setItem(STORAGE_KEYS.theme, next);
    showToast(`Włączono motyw ${next === "dark" ? "ciemny" : "jasny"}.`);
  }

  function applySavedTheme() {
    const saved = localStorage.getItem(STORAGE_KEYS.theme);

    if (saved === "dark" || saved === "light") {
      elements.html.dataset.theme = saved;
      return;
    }

    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    elements.html.dataset.theme = prefersDark ? "dark" : "light";
  }

  function toggleMenu() {
    const isOpen = elements.navMenu.classList.toggle("is-open");
    document.body.classList.toggle("menu-open", isOpen);
    elements.navToggle.setAttribute("aria-expanded", String(isOpen));
    elements.navToggle.setAttribute("aria-label", isOpen ? "Zamknij menu" : "Otwórz menu");
  }

  function closeMenu() {
    elements.navMenu.classList.remove("is-open");
    document.body.classList.remove("menu-open");
    elements.navToggle.setAttribute("aria-expanded", "false");
    elements.navToggle.setAttribute("aria-label", "Otwórz menu");
  }

  function showToast(message) {
    window.clearTimeout(toastTimeout);
    elements.toast.textContent = message;
    elements.toast.classList.add("is-visible");

    toastTimeout = window.setTimeout(() => {
      elements.toast.classList.remove("is-visible");
    }, 3200);
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
})();
