<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 5:47 PM
 */
namespace TIC_TAC_TOE\GameToNewGame;

use TIC_TAC_TOE\Game;
use TIC_TAC_TOE\GameToNewGame;

/**
 * Class MiniMax
 * @package TIC_TAC_TOE\GameToNewGame
 * @see https://medium.freecodecamp.org/how-to-make-your-tic-tac-toe-game-unbeatable-by-using-the-minimax-algorithm-9d690bad4b37
 * @see https://github.com/andrewgph/TicTacToe-Players/tree/master/Php
 */
class MiniMax extends GameToNewGame
{
    public function getNewGame(Game $game) : Game
    {
        $games = $this->getPossibleGames($game);

        $newGame = $games[0];
        $min = 1;

        foreach ($games as $game) {
            $v = $this->getMiniMaxValue($game);

            if ($v <= $min) {
                $newGame = $game;
                $min = $v;
            }
        }

        return $newGame;
    }

    public function getPossibleGames(Game $game)
    {
        $output = [];

        foreach ($game->getBoard() as $k => $v) {
            if (Game::MARK_EMPTY == $v) {
                $tmp = $game->getBoard();
                $tmp[$k] = $game->getPlayer();
                $output[] = new Game($tmp, $game->getOpponent());
            }
        }

        return $output;
    }

    protected function getMiniMaxValue(Game $game)
    {
        if (Game::MARK_X == $game->getPlayer()) {
            return $this->getMaxValue($game);
        }

        return $this->getMinValue($game);
    }

    public function getMaxValue(Game $game, $alpha = -5, $beta = 5)
    {
        if ($game->isOver()) {
            return $game->getWinner();
        }

        $v = -2;

        foreach ($this->getPossibleGames($game) as $game) {
            $v = max($v, $this->getMinValue($game, $alpha, $beta));

            if ($v >= $beta) {
                return $v;
            }

            $alpha = max($alpha, $v);
        }

        return $v;
    }

    public function getMinValue(Game $game, $alpha = -5, $beta = 5)
    {
        if ($game->isOver()) {
            return $game->getWinner();
        }

        $v = 2;

        foreach ($this->getPossibleGames($game) as $game) {
            $v = min($v, $this->getMaxValue($game, $alpha, $beta));

            if ($v <= $alpha) {
                return $v;
            }

            $beta = min($beta, $v);
        }

        return $v;
    }
}