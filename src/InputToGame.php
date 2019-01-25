<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/6/17
 * Time: 7:54 PM
 */

namespace TIC_TAC_TOE;

/**
 * Makes Game instance from abstract input
 *
 * Class InputToGame
 * @package TIC_TAC_TOE
 */
abstract class InputToGame
{
    public function getGame($input): Game
    {
        return new Game($this->transferBoard($input));
    }

    abstract public function transferBoard($input): array;
}