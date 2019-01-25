<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 5:45 PM
 */
declare(strict_types=1);

namespace TIC_TAC_TOE;

/**
 * Class Game
 * @package TIC_TAC_TOE
 */
class Game
{
    public const MARK_EMPTY = '';
    public const MARK_X = 'x';
    public const MARK_O = 'o';

    public const VALID_VALUES = [self::MARK_EMPTY, self::MARK_O, self::MARK_X];

    public $board;
    public $player;

    /**
     * Game constructor.
     * @param array $board
     * @param string $player
     */
    public function __construct(array $board, string $player = self::MARK_O)
    {
        $this->setBoard($board);
        $this->setPlayer($player);
    }

    /**
     * @param $board
     * @return Game
     */
    public function setBoard(array $board): Game
    {
        $this->validateBoard($board);
        $this->board = $board;

        return $this;
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    public function setPlayer($player): Game
    {
        if ($this->validatePlayer($player)) {
            $this->player = $player;
        }

        return $this;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getOpponent()
    {
        return Game::MARK_X == $this->player ? Game::MARK_O : Game::MARK_X;
    }

    public function isOver(): bool
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

    public function getWinner(): int
    {
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
                    return -1;
                } else if (self::MARK_X == $line[0]) {
                    return 1;
                }
            }
        }

        return 0;
    }

    public function isPlayerWon()
    {
        return 1 == $this->getWinner();
    }

    public function isPlayerLost()
    {
        return -1 == $this->getWinner();
    }

    /**
     * @param $board
     * @return bool
     */
    private function validateBoard($board): bool
    {
        if (!is_array($board)) {
            throw new \InvalidArgumentException('Board should be an array');
        }

        if (count($board) != 9) {
            throw new \InvalidArgumentException('Board should have exactly 9 values');
        }

        foreach ($board as $value) {
            if (!in_array($value, self::VALID_VALUES)) {
                throw new \InvalidArgumentException('Board line value should be either...');
            }
        }

        return true;
    }

    private function validatePlayer($player): bool
    {
        if (!in_array($player, self::VALID_VALUES)) {
            throw new \InvalidArgumentException('Player should be either...');
        }

        return true;
    }
}