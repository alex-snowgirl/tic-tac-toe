<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 5:45 PM
 */
namespace TIC_TAC_TOE;

/**
 * Class Game
 * @package TIC_TAC_TOE
 */
class Game
{
    const MARK_EMPTY = '';
    const MARK_X = 'x';
    const MARK_O = 'o';

    public $board;
    public $opponent;

    /**
     * @param array[] $board
     * @param string $opponent
     */
    public function __construct(array $board, $opponent = self::MARK_X)
    {
        $this->setBoard($board);
        $this->setOpponent($opponent);
    }

    /**
     * @param array[] $board
     * @return Game
     */
    public function setBoard(array $board) : Game
    {
        if (isset($board[0]) && is_array($board[0])) {
            $this->board = call_user_func_array('array_merge', $board);
        } else {
            $this->board = $board;
        }

        return $this;
    }

    public function getBoard() : array
    {
        return $this->board;
    }

    public function setOpponent($opponent) : Game
    {
        $this->opponent = $opponent;
        return $this;
    }

    public function getOpponent()
    {
        return $this->opponent;
    }

    public function getPlayer()
    {
        return Game::MARK_X == $this->opponent ? Game::MARK_O : Game::MARK_X;
    }

    public function isOver() : bool
    {
        if (0 != $this->getWinner()) {
            return true;
        }

        foreach ($this->board as $v) {
            if (self::MARK_EMPTY == $v) {
                return false;
            }
        }

        return true;
    }

    protected $winner;

    public function getWinner() : int
    {
        if (null !== $this->winner) {
            return $this->winner;
        }

        $lines = [
            [$this->board[0], $this->board[4], $this->board[8]],
            [$this->board[2], $this->board[4], $this->board[6]]
        ];

        for ($i = 0; $i <= 2; $i++) {
            $lines[] = [$this->board[$i], $this->board[$i + 3], $this->board[$i + 6]];
            $lines[] = [$this->board[$i * 3], $this->board[$i * 3 + 1], $this->board[$i * 3 + 2]];
        }

        foreach ($lines as $line) {
            if (self::MARK_EMPTY != $line[0] && $line[0] == $line[1] && $line[1] == $line[2]) {
                if (self::MARK_O == $line[0]) {
                    return $this->winner = -1;
                } else if (self::MARK_X == $line[0]) {
                    return $this->winner = 1;
                }
            }
        }

        return $this->winner = 0;
    }

    public function isPlayerWon()
    {
        return 1 == $this->getWinner();
    }

    public function isPlayerLost()
    {
        return -1 == $this->getWinner();
    }
}