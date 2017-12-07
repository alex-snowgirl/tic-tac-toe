<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 5:48 PM
 */
namespace TIC_TAC_TOE;

/**
 * Makes new move and returns new game (current game + new move = new game)
 *
 * Class GameToNewGame
 * @package TIC_TAC_TOE
 */
abstract class GameToNewGame
{
    abstract public function getNewGame(Game $game) : Game;
}