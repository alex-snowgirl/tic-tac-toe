<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 7:54 PM
 */
namespace TIC_TAC_TOE;

/**
 * Makes output from two games (new game - previous game = result in some specific format)
 *
 * Class GameToOutput
 * @package TIC_TAC_TOE
 */
abstract class GameToOutput
{
    abstract public function transfer(Game $prevGame, Game $newGame) : array;
}