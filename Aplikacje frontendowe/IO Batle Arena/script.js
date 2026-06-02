'use strict';

const gameState = {
  running: false,
  paused: false,
  score: 0,
  combo: 1,
  timeLeft: 60,
  bots: [],
  animationId: null,
  timerId: null,
  lastFrameTime: 0,
  difficulty: 'normal',
  bestScore: Number(localStorage.getItem('ioAiArenaBestScore') || 0),
};

const difficultySettings = {
  easy: {
    time: 75,
    speedMin: 40,
    speedMax: 95,
    points: 10,
    spawnEvery: 5000,
  },
  normal: {
    time: 60,
    speedMin: 70,
    speedMax: 145,
    points: 15,
    spawnEvery: 3800,
  },
  hard: {
    time: 45,
    speedMin: 110,
    speedMax: 210,
    points: 25,
    spawnEvery: 2600,
  },
};

const botTypes = [
  { label: 'E', name: 'explorer', color: '#7c3aed' },
  { label: 'R', name: 'runner', color: '#0891b2' },
  { label: 'C', name: 'chaser', color: '#ea580c' },
  { label: 'S', name: 'support', color: '#16a34a' },
];

const elements = {};

window.addEventListener('DOMContentLoaded', () => {
  cacheElements();
  bindEvents();
  updateUi();
  showMessage('Wybierz poziom trudności i rozpocznij rozgrywkę.', 'info');
});

function cacheElements() {
  elements.arena = document.getElementById('gameArena');
  elements.emptyHint = document.getElementById('emptyArenaHint');
  elements.status = document.getElementById('gameStatus');
  elements.timeLeft = document.getElementById('timeLeft');
  elements.score = document.getElementById('scoreValue');
  elements.bestScore = document.getElementById('bestScoreValue');
  elements.botCount = document.getElementById('botCountValue');
  elements.combo = document.getElementById('comboValue');
  elements.message = document.getElementById('gameMessage');
  elements.startBtn = document.getElementById('startGameBtn');
  elements.pauseBtn = document.getElementById('pauseGameBtn');
  elements.resetBtn = document.getElementById('resetGameBtn');
  elements.addBotsBtn = document.getElementById('addBotsBtn');
  elements.clearBotsBtn = document.getElementById('clearBotsBtn');
  elements.difficulty = document.getElementById('difficultySelect');
  elements.botAmount = document.getElementById('botAmountRange');
  elements.botAmountLabel = document.getElementById('botAmountLabel');
  elements.themeToggle = document.getElementById('themeToggle');
}

function bindEvents() {
  elements.startBtn.addEventListener('click', startGame);
  elements.pauseBtn.addEventListener('click', togglePause);
  elements.resetBtn.addEventListener('click', resetGame);
  elements.addBotsBtn.addEventListener('click', () => addBots(10));
  elements.clearBotsBtn.addEventListener('click', clearBots);
  elements.difficulty.addEventListener('change', () => {
    gameState.difficulty = elements.difficulty.value;
    if (!gameState.running) {
      gameState.timeLeft = difficultySettings[gameState.difficulty].time;
      updateUi();
    }
  });
  elements.botAmount.addEventListener('input', () => {
    elements.botAmountLabel.textContent = elements.botAmount.value;
  });
  elements.themeToggle.addEventListener('click', toggleTheme);

  document.addEventListener('keydown', (event) => {
    const key = event.key.toLowerCase();

    if (key === ' ' && gameState.running) {
      event.preventDefault();
      togglePause();
    }

    if (key === 'r') {
      resetGame();
    }

    if (key === 'a') {
      addBots(10);
    }
  });
}

function startGame() {
  resetGame(false);

  gameState.running = true;
  gameState.paused = false;
  gameState.score = 0;
  gameState.combo = 1;
  gameState.difficulty = elements.difficulty.value;
  gameState.timeLeft = difficultySettings[gameState.difficulty].time;

  addBots(Number(elements.botAmount.value));
  startTimer();
  startAnimation();

  elements.startBtn.disabled = true;
  elements.pauseBtn.disabled = false;
  elements.difficulty.disabled = true;
  elements.botAmount.disabled = true;

  showMessage('Gra rozpoczęta. Klikaj boty, aby zdobywać punkty.', 'success');
  updateUi();
}

function togglePause() {
  if (!gameState.running) return;

  gameState.paused = !gameState.paused;
  elements.pauseBtn.innerHTML = gameState.paused
    ? '<i class="bi bi-play-fill"></i> Wznów'
    : '<i class="bi bi-pause-fill"></i> Pauza';

  showMessage(gameState.paused ? 'Gra została zatrzymana.' : 'Gra została wznowiona.', 'info');
  updateUi();
}

function resetGame(showResetMessage = true) {
  gameState.running = false;
  gameState.paused = false;
  gameState.score = 0;
  gameState.combo = 1;
  gameState.timeLeft = difficultySettings[elements.difficulty.value].time;
  gameState.lastFrameTime = 0;

  stopTimer();
  stopAnimation();
  clearBots();

  elements.startBtn.disabled = false;
  elements.pauseBtn.disabled = true;
  elements.pauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i> Pauza';
  elements.difficulty.disabled = false;
  elements.botAmount.disabled = false;

  if (showResetMessage) {
    showMessage('Gra została zresetowana.', 'info');
  }

  updateUi();
}

function endGame() {
  gameState.running = false;
  gameState.paused = false;
  stopTimer();
  stopAnimation();

  if (gameState.score > gameState.bestScore) {
    gameState.bestScore = gameState.score;
    localStorage.setItem('ioAiArenaBestScore', String(gameState.bestScore));
    showMessage(`Koniec gry. Nowy rekord: ${gameState.score} punktów.`, 'success');
  } else {
    showMessage(`Koniec gry. Wynik: ${gameState.score} punktów.`, 'info');
  }

  elements.startBtn.disabled = false;
  elements.pauseBtn.disabled = true;
  elements.pauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i> Pauza';
  elements.difficulty.disabled = false;
  elements.botAmount.disabled = false;
  updateUi();
}

function startTimer() {
  stopTimer();
  gameState.timerId = window.setInterval(() => {
    if (!gameState.running || gameState.paused) return;

    gameState.timeLeft -= 1;

    if (gameState.timeLeft <= 0) {
      gameState.timeLeft = 0;
      updateUi();
      endGame();
      return;
    }

    if (gameState.timeLeft % 8 === 0) {
      addBots(3);
    }

    updateUi();
  }, 1000);
}

function stopTimer() {
  if (gameState.timerId) {
    window.clearInterval(gameState.timerId);
    gameState.timerId = null;
  }
}

function startAnimation() {
  stopAnimation();
  gameState.lastFrameTime = performance.now();

  const frame = (time) => {
    const delta = Math.min((time - gameState.lastFrameTime) / 1000, 0.05);
    gameState.lastFrameTime = time;

    if (gameState.running && !gameState.paused) {
      updateBots(delta);
    }

    gameState.animationId = window.requestAnimationFrame(frame);
  };

  gameState.animationId = window.requestAnimationFrame(frame);
}

function stopAnimation() {
  if (gameState.animationId) {
    window.cancelAnimationFrame(gameState.animationId);
    gameState.animationId = null;
  }
}

function addBots(amount) {
  if (!elements.arena) return;

  const arenaRect = elements.arena.getBoundingClientRect();
  const settings = difficultySettings[elements.difficulty.value];

  for (let i = 0; i < amount; i += 1) {
    const type = randomFromArray(botTypes);
    const size = randomNumber(18, 34);
    const speed = randomNumber(settings.speedMin, settings.speedMax);
    const angle = randomNumber(0, Math.PI * 2);
    const botElement = document.createElement('button');
    const bot = {
      id: crypto.randomUUID ? crypto.randomUUID() : `bot-${Date.now()}-${Math.random()}`,
      x: randomNumber(size, Math.max(size, arenaRect.width - size)),
      y: randomNumber(size, Math.max(size, arenaRect.height - size)),
      vx: Math.cos(angle) * speed,
      vy: Math.sin(angle) * speed,
      size,
      type,
      energy: randomNumber(60, 100),
      element: botElement,
    };

    botElement.type = 'button';
    botElement.className = 'ai-bot';
    botElement.textContent = type.label;
    botElement.title = `Bot ${type.name}`;
    botElement.style.width = `${size}px`;
    botElement.style.height = `${size}px`;
    botElement.style.background = type.color;
    botElement.style.color = '#ffffff';
    botElement.addEventListener('click', (event) => {
      event.stopPropagation();
      hitBot(bot.id);
    });

    elements.arena.appendChild(botElement);
    gameState.bots.push(bot);
    renderBot(bot);
  }

  updateUi();
}

function updateBots(delta) {
  const arenaRect = elements.arena.getBoundingClientRect();

  gameState.bots.forEach((bot) => {
    applyBotAi(bot, delta, arenaRect);

    bot.x += bot.vx * delta;
    bot.y += bot.vy * delta;

    const radius = bot.size / 2;

    if (bot.x < radius) {
      bot.x = radius;
      bot.vx *= -1;
    }

    if (bot.x > arenaRect.width - radius) {
      bot.x = arenaRect.width - radius;
      bot.vx *= -1;
    }

    if (bot.y < radius) {
      bot.y = radius;
      bot.vy *= -1;
    }

    if (bot.y > arenaRect.height - radius) {
      bot.y = arenaRect.height - radius;
      bot.vy *= -1;
    }

    renderBot(bot);
  });
}

function applyBotAi(bot, delta, arenaRect) {
  bot.energy -= delta * 2;

  if (bot.energy <= 0) {
    bot.energy = randomNumber(50, 100);
    rotateBot(bot, randomNumber(-1.8, 1.8));
  }

  if (bot.type.name === 'runner') {
    bot.vx *= 1 + delta * 0.08;
    bot.vy *= 1 + delta * 0.08;
  }

  if (bot.type.name === 'chaser') {
    const centerX = arenaRect.width / 2;
    const centerY = arenaRect.height / 2;
    bot.vx += Math.sign(centerX - bot.x) * delta * 16;
    bot.vy += Math.sign(centerY - bot.y) * delta * 16;
  }

  if (bot.type.name === 'support') {
    bot.vx += Math.sin(performance.now() / 500) * delta * 10;
    bot.vy += Math.cos(performance.now() / 700) * delta * 10;
  }

  limitSpeed(bot);
}

function rotateBot(bot, angle) {
  const cos = Math.cos(angle);
  const sin = Math.sin(angle);
  const vx = bot.vx * cos - bot.vy * sin;
  const vy = bot.vx * sin + bot.vy * cos;
  bot.vx = vx;
  bot.vy = vy;
}

function limitSpeed(bot) {
  const settings = difficultySettings[elements.difficulty.value];
  const currentSpeed = Math.hypot(bot.vx, bot.vy);
  const maxSpeed = settings.speedMax * 1.25;

  if (currentSpeed > maxSpeed) {
    bot.vx = (bot.vx / currentSpeed) * maxSpeed;
    bot.vy = (bot.vy / currentSpeed) * maxSpeed;
  }
}

function renderBot(bot) {
  bot.element.style.left = `${bot.x}px`;
  bot.element.style.top = `${bot.y}px`;
}

function hitBot(botId) {
  if (!gameState.running || gameState.paused) {
    showMessage('Najpierw uruchom grę.', 'warning');
    return;
  }

  const index = gameState.bots.findIndex((bot) => bot.id === botId);
  if (index === -1) return;

  const bot = gameState.bots[index];
  const settings = difficultySettings[gameState.difficulty];
  const points = settings.points * gameState.combo;

  gameState.score += points;
  gameState.combo = Math.min(gameState.combo + 1, 10);

  showFloatingPoints(bot.x, bot.y, `+${points}`);
  bot.element.classList.add('is-hit');

  window.setTimeout(() => {
    bot.element.remove();
  }, 180);

  gameState.bots.splice(index, 1);

  if (gameState.bots.length === 0 && gameState.running) {
    addBots(8);
    showMessage('Dobra seria. Arena została uzupełniona nowymi botami.', 'success');
  }

  updateUi();
}

function showFloatingPoints(x, y, text) {
  const points = document.createElement('span');
  points.className = 'floating-points';
  points.textContent = text;
  points.style.left = `${x}px`;
  points.style.top = `${y}px`;
  elements.arena.appendChild(points);

  window.setTimeout(() => points.remove(), 800);
}

function clearBots() {
  gameState.bots.forEach((bot) => bot.element.remove());
  gameState.bots = [];
  updateUi();
}

function updateUi() {
  elements.status.textContent = getStatusText();
  elements.timeLeft.textContent = gameState.timeLeft;
  elements.score.textContent = gameState.score;
  elements.bestScore.textContent = gameState.bestScore;
  elements.botCount.textContent = gameState.bots.length;
  elements.combo.textContent = `x${gameState.combo}`;
  elements.emptyHint.style.display = gameState.bots.length === 0 ? 'flex' : 'none';
}

function getStatusText() {
  if (!gameState.running) return 'Gotowa do startu';
  if (gameState.paused) return 'Pauza';
  return 'Gra aktywna';
}

function showMessage(message, type = 'info') {
  elements.message.className = `game-message game-message-${type}`;
  elements.message.textContent = message;
}

function toggleTheme() {
  const currentTheme = document.documentElement.getAttribute('data-theme');
  const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', nextTheme);
  localStorage.setItem('ioAiArenaTheme', nextTheme);
}

function randomNumber(min, max) {
  return Math.random() * (max - min) + min;
}

function randomFromArray(items) {
  return items[Math.floor(Math.random() * items.length)];
}

const savedTheme = localStorage.getItem('ioAiArenaTheme');
if (savedTheme) {
  document.documentElement.setAttribute('data-theme', savedTheme);
}
