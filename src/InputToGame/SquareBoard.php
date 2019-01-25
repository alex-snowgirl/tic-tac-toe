<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 1/25/19
 * Time: 3:31 PM
 */

namespace TIC_TAC_TOE\InputToGame;

use TIC_TAC_TOE\InputToGame;

/**
 * Class SquareBoard
 * @package TIC_TAC_TOE\InputToGame
 */
class SquareBoard extends InputToGame
{
    public function transferBoard($input): array
    {
        $this->validate($input);

        return call_user_func_array('array_merge', $input);
    }

    private function validate($squareBoard): bool
    {
        if (!is_array($squareBoard)) {
            throw new \InvalidArgumentException('Square board should be an array');
        }

        $count = count($squareBoard);

        foreach ($squareBoard as $line) {
            if (!is_array($line)) {
                throw new \InvalidArgumentException('Square board line should be an array');
            }

            if ($count != count($line)) {
                throw new \InvalidArgumentException('Square board lines should have the same length');
            }
        }

        return true;
    }
}