'use strict';

(function () {
    const STORAGE_KEY = 'wisielecArenaStatsV3';
    const THEME_KEY = 'wisielecArenaThemeV3';
    const POLISH_ALPHABET = 'AĄBCĆDEĘFGHIJKLŁMNŃOÓPRSŚTUWYZŹŻ'.split('');

    const WORDS = {
        heroes: [
            'CRYSTAL MAIDEN',
            'DRAGON KNIGHT',
            'PHANTOM ASSASSIN',
            'SHADOW FIEND',
            'WINDRANGER',
            'JUGGERNAUT',
            'EARTHSHAKER',
            'STORM SPIRIT',
            'LINA',
            'PUDGE',
            'MIRANA',
            'AXE',
            'DROW RANGER',
            'SNIPER',
            'TIDEHUNTER'
        ],
        items: [
            'BLACK KING BAR',
            'BLINK DAGGER',
            'BUTTERFLY',
            'DIVINE RAPIER',
            'MANTA STYLE',
            'DESOLATOR',
            'FORCE STAFF',
            'DAEDALUS',
            'SANGE AND YASHA',
            'HEART OF TARRASQUE',
            'SCYTHE OF VYSE',
            'EYE OF SKADI',
            'PHASE BOOTS',
            'MAGIC WAND',
            'MOON SHARD'
        ],
        skills: [
            'FROSTBITE',
            'LAGUNA BLADE',
            'MEAT HOOK',
            'CHRONOSPHERE',
            'ECHO SLAM',
            'BLACK HOLE',
            'BLADE FURY',
            'WAVEFORM',
            'FINGER OF DEATH',
            'SUN STRIKE',
            'BALL LIGHTNING',
            'RAVAGE',
            'SHADOWRAZE',
            'BERSERKERS CALL',
            'MULTISHOT'
        ]
    };

    const DIFFICULTY = {
        easy: {
            label: 'Łatwy',
            maxWrong: 9,
            hintLimit: 3,
            scoreMultiplier: 1
        },
        normal: {
            label: 'Normalny',
            maxWrong: 7,
            hintLimit: 2,
            scoreMultiplier: 1.35
        },
        hard: {
            label: 'Trudny',
            maxWrong: 5,
            hintLimit: 1,
            scoreMultiplier: 1.8
        },
        expert: {
            label: 'Ekspert',
            maxWrong: 4,
            hintLimit: 0,
            scoreMultiplier: 2.4
        }
    };

    const CATEGORY_LABELS = {
        all: 'Wszystkie',
        heroes: 'Bohaterowie',
        items: 'Przedmioty',
        skills: 'Umiejętności'
    };

    const state = {
        phrase: '',
        category: 'all',
        difficulty: 'normal',
        guessedLetters: new Set(),
        wrongLetters: new Set(),
        maxWrong: DIFFICULTY.normal.maxWrong,
        hintLimit: DIFFICULTY.normal.hintLimit,
        usedHints: 0,
        status: 'idle',
        startedAt: null,
        timerId: null,
        score: 0,
        soundEnabled: true,
        lastPhrase: '',
        resetArmed: false,
        resetTimerId: null
    };

    const elements = {
        mobileMenuButton: document.getElementById('mobileMenuButton'),
        mainNavigation: document.getElementById('mainNavigation'),
        themeToggle: document.getElementById('themeToggle'),
        themeIcon: document.getElementById('themeIcon'),
        openInfoModal: document.getElementById('openInfoModal'),
        closeInfoModal: document.getElementById('closeInfoModal'),
        infoModal: document.getElementById('infoModal'),
        categorySelect: document.getElementById('categorySelect'),
        difficultySelect: document.getElementById('difficultySelect'),
        soundToggle: document.getElementById('soundToggle'),
        newGameBtn: document.getElementById('newGameBtn'),
        hintBtn: document.getElementById('hintBtn'),
        revealBtn: document.getElementById('revealBtn'),
        resetStatsBtn: document.getElementById('resetStatsBtn'),
        roundStatus: document.getElementById('roundStatus'),
        attemptsStat: document.getElementById('attemptsStat'),
        timeStat: document.getElementById('timeStat'),
        scoreStat: document.getElementById('scoreStat'),
        bestScoreStat: document.getElementById('bestScoreStat'),
        gamesStat: document.getElementById('gamesStat'),
        winsStat: document.getElementById('winsStat'),
        lossesStat: document.getElementById('lossesStat'),
        winRateStat: document.getElementById('winRateStat'),
        gameMessage: document.getElementById('gameMessage'),
        wordBoard: document.getElementById('wordBoard'),
        hintBox: document.getElementById('hintBox'),
        hangmanImage: document.getElementById('hangmanImage'),
        keyboard: document.getElementById('keyboard'),
        categoryStat: document.getElementById('categoryStat'),
        difficultyStat: document.getElementById('difficultyStat'),
        hintsStat: document.getElementById('hintsStat'),
        wrongLettersStat: document.getElementById('wrongLettersStat'),
        toastContainer: document.getElementById('toastContainer'),
        sounds: {
            correct: document.getElementById('soundCorrect'),
            wrong: document.getElementById('soundWrong'),
            win: document.getElementById('soundWin'),
            lose: document.getElementById('soundLose')
        }
    };

    const stats = loadStats();

    document.addEventListener('DOMContentLoaded', init);

    function init() {
        applySavedTheme();
        bindEvents();
        renderKeyboard();
        renderWord();
        updateAllStats();
        updateControls();
        setMessage('Kliknij „Nowa gra”, aby rozpocząć rundę.', 'info');
    }

    function bindEvents() {
        elements.newGameBtn.addEventListener('click', startNewGame);
        elements.hintBtn.addEventListener('click', showHint);
        elements.revealBtn.addEventListener('click', revealPhrase);
        elements.resetStatsBtn.addEventListener('click', resetStats);
        elements.soundToggle.addEventListener('click', toggleSound);
        elements.themeToggle.addEventListener('click', toggleTheme);
        elements.openInfoModal.addEventListener('click', openModal);
        elements.closeInfoModal.addEventListener('click', closeModal);

        elements.infoModal.addEventListener('click', (event) => {
            if (event.target.hasAttribute('data-close-modal')) {
                closeModal();
            }
        });

        elements.mobileMenuButton.addEventListener('click', toggleMobileMenu);

        elements.mainNavigation.addEventListener('click', (event) => {
            if (event.target.matches('a')) {
                closeMobileMenu();
            }
        });

        elements.keyboard.addEventListener('click', (event) => {
            const button = event.target.closest('[data-letter]');
            if (!button) {
                return;
            }
            handleGuess(button.dataset.letter);
        });

        document.addEventListener('keydown', handleKeyboardInput);
        window.addEventListener('beforeunload', stopTimer);
    }

    function startNewGame() {
        const difficulty = DIFFICULTY[elements.difficultySelect.value] || DIFFICULTY.normal;
        stopTimer();

        state.category = elements.categorySelect.value;
        state.difficulty = elements.difficultySelect.value;
        state.phrase = drawPhrase(state.category);
        state.guessedLetters = new Set();
        state.wrongLetters = new Set();
        state.maxWrong = difficulty.maxWrong;
        state.hintLimit = difficulty.hintLimit;
        state.usedHints = 0;
        state.status = 'playing';
        state.startedAt = Date.now();
        state.score = 0;

        hideHint();
        renderKeyboard();
        renderWord();
        updateHangmanImage();
        updateAllStats();
        updateControls();
        startTimer();

        setMessage(`Nowa runda rozpoczęta. Poziom: ${difficulty.label}.`, 'info');
        showToast('Nowa gra została uruchomiona.', 'success');
    }

    function drawPhrase(category) {
        const pool = getWordPool(category);
        if (pool.length === 0) {
            return 'JAVASCRIPT';
        }

        let phrase = pool[Math.floor(Math.random() * pool.length)];
        if (pool.length > 1 && phrase === state.lastPhrase) {
            phrase = pool.find((item) => item !== state.lastPhrase) || phrase;
        }
        state.lastPhrase = phrase;
        return normalizePhrase(phrase);
    }

    function getWordPool(category) {
        if (category === 'heroes') return WORDS.heroes;
        if (category === 'items') return WORDS.items;
        if (category === 'skills') return WORDS.skills;
        return [...WORDS.heroes, ...WORDS.items, ...WORDS.skills];
    }

    function normalizePhrase(value) {
        return String(value).trim().toUpperCase();
    }

    function handleGuess(letter) {
        if (state.status !== 'playing') {
            showToast('Najpierw rozpocznij nową grę.', 'warning');
            return;
        }

        const normalizedLetter = normalizePhrase(letter);
        if (!isGuessableLetter(normalizedLetter)) {
            return;
        }

        if (state.guessedLetters.has(normalizedLetter) || state.wrongLetters.has(normalizedLetter)) {
            showToast('Ta litera była już użyta.', 'warning');
            return;
        }

        if (state.phrase.includes(normalizedLetter)) {
            state.guessedLetters.add(normalizedLetter);
            playSound('correct');
            setMessage(`Dobrze. Litera „${normalizedLetter}” występuje w haśle.`, 'success');
        } else {
            state.wrongLetters.add(normalizedLetter);
            playSound('wrong');
            setMessage(`Błąd. Litera „${normalizedLetter}” nie występuje w haśle.`, 'danger');
        }

        renderWord();
        renderKeyboard();
        updateHangmanImage();
        updateAllStats();
        checkRoundEnd();
    }

    function isGuessableLetter(letter) {
        return POLISH_ALPHABET.includes(letter) || /^[A-Z]$/.test(letter);
    }

    function checkRoundEnd() {
        if (isPhraseSolved()) {
            finishRound('won');
            return;
        }

        if (state.wrongLetters.size >= state.maxWrong) {
            finishRound('lost');
        }
    }

    function isPhraseSolved() {
        return Array.from(state.phrase).every((character) => {
            if (!isPhraseLetter(character)) return true;
            return state.guessedLetters.has(character);
        });
    }

    function isPhraseLetter(character) {
        return /^[A-ZĄĆĘŁŃÓŚŹŻ]$/.test(character);
    }

    function finishRound(result) {
        state.status = result;
        stopTimer();
        revealWordOnBoard();

        stats.games += 1;
        if (result === 'won') {
            stats.wins += 1;
            state.score = calculateScore(true);
            if (state.score > stats.bestScore) {
                stats.bestScore = state.score;
            }
            playSound('win');
            setMessage(`Wygrana. Hasło to: ${state.phrase}. Wynik: ${state.score} pkt.`, 'success');
            showToast('Runda zakończona wygraną.', 'success');
        } else {
            stats.losses += 1;
            playSound('lose');
            setMessage(`Przegrana. Poprawne hasło to: ${state.phrase}.`, 'danger');
            showToast('Runda zakończona przegraną.', 'danger');
        }

        saveStats();
        renderKeyboard();
        updateHangmanImage();
        updateAllStats();
        updateControls();
    }

    function revealPhrase() {
        if (state.status !== 'playing') {
            showToast('Nie ma aktywnej rundy do poddania.', 'warning');
            return;
        }

        finishRound('lost');
    }

    function showHint() {
        if (state.status !== 'playing') {
            showToast('Najpierw rozpocznij nową grę.', 'warning');
            return;
        }

        if (state.usedHints >= state.hintLimit) {
            showToast('Limit podpowiedzi został wykorzystany.', 'warning');
            return;
        }

        const hiddenLetters = Array.from(new Set(Array.from(state.phrase).filter((character) => {
            return isPhraseLetter(character) && !state.guessedLetters.has(character);
        })));

        if (hiddenLetters.length === 0) {
            showToast('Nie ma już liter do podpowiedzi.', 'warning');
            return;
        }

        const hintLetter = hiddenLetters[Math.floor(Math.random() * hiddenLetters.length)];
        state.guessedLetters.add(hintLetter);
        state.usedHints += 1;

        elements.hintBox.hidden = false;
        elements.hintBox.textContent = `Podpowiedź: odkryto literę „${hintLetter}”.`;

        renderWord();
        renderKeyboard();
        updateAllStats();
        checkRoundEnd();
        setMessage('Podpowiedź została użyta. Wynik zostanie pomniejszony.', 'warning');
    }

    function hideHint() {
        elements.hintBox.hidden = true;
        elements.hintBox.textContent = '';
    }

    function renderWord() {
        elements.wordBoard.innerHTML = '';

        if (!state.phrase) {
            elements.wordBoard.innerHTML = '<span class="word-letter word-placeholder">?</span>';
            return;
        }

        Array.from(state.phrase).forEach((character) => {
            const span = document.createElement('span');

            if (character === ' ') {
                span.className = 'word-space';
                span.setAttribute('aria-label', 'spacja');
                elements.wordBoard.appendChild(span);
                return;
            }

            if (!isPhraseLetter(character)) {
                span.className = 'word-letter word-symbol';
                span.textContent = character;
                elements.wordBoard.appendChild(span);
                return;
            }

            const visible = state.guessedLetters.has(character) || state.status === 'won' || state.status === 'lost';
            span.className = visible ? 'word-letter is-visible' : 'word-letter';
            span.textContent = visible ? character : '';
            span.setAttribute('aria-label', visible ? character : 'ukryta litera');
            elements.wordBoard.appendChild(span);
        });
    }

    function revealWordOnBoard() {
        renderWord();
    }

    function renderKeyboard() {
        elements.keyboard.innerHTML = '';

        POLISH_ALPHABET.forEach((letter) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'key-button';
            button.textContent = letter;
            button.dataset.letter = letter;
            button.setAttribute('aria-label', `Litera ${letter}`);

            if (state.guessedLetters.has(letter)) {
                button.classList.add('is-correct');
                button.disabled = true;
            }

            if (state.wrongLetters.has(letter)) {
                button.classList.add('is-wrong');
                button.disabled = true;
            }

            if (state.status !== 'playing') {
                button.disabled = true;
            }

            elements.keyboard.appendChild(button);
        });
    }

    function updateHangmanImage() {
        const ratio = state.maxWrong > 0 ? state.wrongLetters.size / state.maxWrong : 0;
        const stage = Math.min(9, Math.max(0, Math.ceil(ratio * 9)));
        elements.hangmanImage.src = `img/s${stage}.png`;
        elements.hangmanImage.alt = `Wisielec - etap ${stage}`;
    }

    function updateAllStats() {
        state.score = calculateScore(false);
        const elapsedSeconds = getElapsedSeconds();
        const difficulty = DIFFICULTY[state.difficulty] || DIFFICULTY.normal;
        const winRate = stats.games > 0 ? Math.round((stats.wins / stats.games) * 100) : 0;

        elements.attemptsStat.textContent = `${state.wrongLetters.size}/${state.maxWrong}`;
        elements.timeStat.textContent = formatTime(elapsedSeconds);
        elements.scoreStat.textContent = String(state.score);
        elements.bestScoreStat.textContent = String(stats.bestScore);
        elements.gamesStat.textContent = String(stats.games);
        elements.winsStat.textContent = String(stats.wins);
        elements.lossesStat.textContent = String(stats.losses);
        elements.winRateStat.textContent = `${winRate}%`;
        elements.categoryStat.textContent = CATEGORY_LABELS[state.category] || '-';
        elements.difficultyStat.textContent = difficulty.label;
        elements.hintsStat.textContent = `${state.usedHints}/${state.hintLimit}`;
        elements.wrongLettersStat.textContent = state.wrongLetters.size ? Array.from(state.wrongLetters).join(', ') : 'brak';
        elements.roundStatus.textContent = getStatusLabel(state.status);
        elements.roundStatus.dataset.status = state.status;
    }

    function updateControls() {
        const playing = state.status === 'playing';
        elements.hintBtn.disabled = !playing || state.hintLimit === 0 || state.usedHints >= state.hintLimit;
        elements.revealBtn.disabled = !playing;
        elements.categorySelect.disabled = playing;
        elements.difficultySelect.disabled = playing;
    }

    function getStatusLabel(status) {
        if (status === 'playing') return 'W trakcie';
        if (status === 'won') return 'Wygrana';
        if (status === 'lost') return 'Przegrana';
        return 'Gotowy';
    }

    function startTimer() {
        stopTimer();
        state.timerId = window.setInterval(updateAllStats, 1000);
    }

    function stopTimer() {
        if (state.timerId) {
            window.clearInterval(state.timerId);
            state.timerId = null;
        }
    }

    function getElapsedSeconds() {
        if (!state.startedAt) return 0;
        return Math.floor((Date.now() - state.startedAt) / 1000);
    }

    function formatTime(totalSeconds) {
        const minutes = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
        const seconds = String(totalSeconds % 60).padStart(2, '0');
        return `${minutes}:${seconds}`;
    }

    function calculateScore(finalScore) {
        if (!state.phrase || state.status === 'idle') return 0;

        const difficulty = DIFFICULTY[state.difficulty] || DIFFICULTY.normal;
        const correctLetters = Array.from(state.guessedLetters).filter((letter) => state.phrase.includes(letter)).length;
        const uniqueLetters = new Set(Array.from(state.phrase).filter(isPhraseLetter)).size || 1;
        const progress = correctLetters / uniqueLetters;
        const base = 500 * progress * difficulty.scoreMultiplier;
        const timePenalty = Math.floor(getElapsedSeconds() / 3);
        const wrongPenalty = state.wrongLetters.size * 35;
        const hintPenalty = state.usedHints * 50;
        const finishBonus = finalScore ? 250 * difficulty.scoreMultiplier : 0;

        return Math.max(0, Math.round(base + finishBonus - timePenalty - wrongPenalty - hintPenalty));
    }

    function handleKeyboardInput(event) {
        if (event.ctrlKey || event.metaKey || event.altKey) return;

        if (event.key === 'Escape') {
            closeModal();
            closeMobileMenu();
            return;
        }

        if (event.key === 'Enter' && state.status !== 'playing') {
            startNewGame();
            return;
        }

        if (event.key.length !== 1) return;
        const letter = normalizePhrase(event.key);
        if (isGuessableLetter(letter)) {
            handleGuess(letter);
        }
    }

    function setMessage(text, type) {
        elements.gameMessage.textContent = text;
        elements.gameMessage.dataset.type = type;
    }

    function showToast(text, type) {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.dataset.type = type;
        toast.textContent = text;
        elements.toastContainer.appendChild(toast);

        window.setTimeout(() => {
            toast.classList.add('is-hiding');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 2600);
    }

    function toggleSound() {
        state.soundEnabled = !state.soundEnabled;
        elements.soundToggle.classList.toggle('is-active', state.soundEnabled);
        elements.soundToggle.setAttribute('aria-pressed', String(state.soundEnabled));
        showToast(state.soundEnabled ? 'Dźwięki włączone.' : 'Dźwięki wyłączone.', 'info');
    }

    function playSound(name) {
        if (!state.soundEnabled) return;
        const audio = elements.sounds[name];
        if (!audio) return;
        try {
            audio.currentTime = 0;
            const promise = audio.play();
            if (promise && typeof promise.catch === 'function') {
                promise.catch(() => null);
            }
        } catch (error) {
            // Audio is optional. The game must work even when the browser blocks sound playback.
        }
    }

    function resetStats() {
        if (!state.resetArmed) {
            state.resetArmed = true;
            elements.resetStatsBtn.textContent = 'Kliknij ponownie, aby potwierdzić';
            showToast('Kliknij ponownie przycisk czyszczenia, aby potwierdzić.', 'warning');

            if (state.resetTimerId) {
                window.clearTimeout(state.resetTimerId);
            }

            state.resetTimerId = window.setTimeout(() => {
                state.resetArmed = false;
                elements.resetStatsBtn.textContent = 'Wyczyść statystyki';
                state.resetTimerId = null;
            }, 3500);
            return;
        }

        if (state.resetTimerId) {
            window.clearTimeout(state.resetTimerId);
            state.resetTimerId = null;
        }

        state.resetArmed = false;
        elements.resetStatsBtn.textContent = 'Wyczyść statystyki';
        Object.assign(stats, createEmptyStats());
        saveStats();
        updateAllStats();
        showToast('Statystyki zostały wyczyszczone.', 'success');
    }

    function createEmptyStats() {
        return {
            bestScore: 0,
            games: 0,
            wins: 0,
            losses: 0
        };
    }

    function loadStats() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return createEmptyStats();
            const parsed = JSON.parse(raw);
            return Object.assign(createEmptyStats(), parsed);
        } catch (error) {
            return createEmptyStats();
        }
    }

    function saveStats() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(stats));
        } catch (error) {
            showToast('Nie można zapisać statystyk w przeglądarce.', 'warning');
        }
    }

    function toggleTheme() {
        const isDark = document.body.classList.toggle('dark-mode');
        elements.themeIcon.textContent = isDark ? '☀️' : '🌙';
        localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
    }

    function applySavedTheme() {
        const savedTheme = localStorage.getItem(THEME_KEY);
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const useDark = savedTheme ? savedTheme === 'dark' : prefersDark;
        document.body.classList.toggle('dark-mode', useDark);
        elements.themeIcon.textContent = useDark ? '☀️' : '🌙';
    }

    function openModal() {
        elements.infoModal.classList.add('is-visible');
        elements.infoModal.setAttribute('aria-hidden', 'false');
        elements.closeInfoModal.focus();
    }

    function closeModal() {
        elements.infoModal.classList.remove('is-visible');
        elements.infoModal.setAttribute('aria-hidden', 'true');
    }

    function toggleMobileMenu() {
        const isOpen = elements.mainNavigation.classList.toggle('is-open');
        elements.mobileMenuButton.classList.toggle('is-open', isOpen);
        elements.mobileMenuButton.setAttribute('aria-expanded', String(isOpen));
    }

    function closeMobileMenu() {
        elements.mainNavigation.classList.remove('is-open');
        elements.mobileMenuButton.classList.remove('is-open');
        elements.mobileMenuButton.setAttribute('aria-expanded', 'false');
    }
})();
