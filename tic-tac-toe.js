import {TicTacToe} from "./components/TicTacToe.js";

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}

function init() {    
    const moveEl = document.getElementById('move-value')
    
    const onMove = (isXTurn) => {
        let currentMove
        
        if (isXTurn) {
            currentMove = 'X'
        } else {
            currentMove = 'O'
        }

        moveEl.innerText = currentMove
    }

    const game = TicTacToe.init(
        {
            el: document.getElementById('tic-tac-toe'),
            onMove,
        }
    )
    
    game.startGame()
    
    const restartBtn = document.getElementById('restart-btn')

    restartBtn.addEventListener('click', () => {
        game.restartGame()
    })

const themes = {
  classic: {
    bgClass: 'bg-paper',
    xImg: null,
    oImg: null,
  },
  underground: {
    bgClass: 'bg-underground',
    xImg: 'assets/style/graffiti.jpg',
    oImg: 'assets/style/skull.jpg',
  },
  sport: {
    bgClass: 'bg-sport',
    xImg: 'assets/style/adik.jpg',
    oImg: 'assets/style/nike.jpg',
  }
}

let currentTheme = 'classic'
setTheme(currentTheme)

function setTheme(themeName) {
  document.body.className = '' // убрать предыдущие фоны
  const theme = themes[themeName]
  document.body.classList.add(theme.bgClass)
  currentTheme = themeName
  game.restartGame()
}

// слушатели на кнопки тем
document.querySelectorAll('.theme-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    setTheme(btn.dataset.theme)
  })
})

// переопределим отрисовку символов
const originalSetBlockDom = game.setBlockDom.bind(game)
game.setBlockDom = (target, clear) => {
  if (clear) {
    target.textContent = ''
    target.innerHTML = ''
    return
  }

  const turn = game.getCurrentTurnValue()
  const theme = themes[currentTheme]

  if (theme.xImg && theme.oImg) {
    target.innerHTML = `<img src="${turn === 'X' ? theme.xImg : theme.oImg}" alt="${turn}">`
  } else {
    originalSetBlockDom(target, clear)
  }
}

}
