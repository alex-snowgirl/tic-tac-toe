<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 8:14 PM
 */
namespace TIC_TAC_TOE\GameToOutput;

use TIC_TAC_TOE\Game;
use TIC_TAC_TOE\GameToOutput;

/**
 * Class Point
 * @package TIC_TAC_TOE\GameToOutput
 */
class Point extends GameToOutput
{
    public function transfer(Game $prevGame, Game $newGame) : array
    {
        $board1 = $prevGame->getBoard();
        $board2 = $newGame->getBoard();

        foreach ($board2 as $k => $v) {
            if ($board1[$k] != $v) {
                return [$k % 3, intdiv($k, 3), $v];
            }
        }

        return [null, null, null];
    }
}