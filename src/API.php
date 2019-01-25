<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/5/17
 * Time: 7:27 PM
 */

namespace TIC_TAC_TOE;

use TIC_TAC_TOE\GameToNewGame\MiniMax;
use TIC_TAC_TOE\GameToOutput\Point;
use TIC_TAC_TOE\InputToGame\SquareBoard;

/**
 * Very simple API class (all in one)
 *
 * Class API
 * @package TIC_TAC_TOE
 */
class API implements MoveInterface
{
    public function __construct(array $request)
    {
        if (!isset($request['action'])) {
            //@todo implement
            throw new BadRequestException();
        }

        $action = 'action' . ucfirst($request['action']);

        if (!method_exists($this, $action)) {
            //@todo implement
            throw new NotFoundException();
        }

        //simple parsing & execution & output
        echo json_encode($this->{$action}($request));
    }

    public function actionMove(array $request)
    {
//        sleep(1);
        return $this->makeMove($request['board'] ?? null, $request['player'] ?? null);
    }

    /**
     * Makes a move using the $boardState
     * $boardState contains 2 dimensional array of the game
     * field
     * X represents one team, O - the other team,
     * empty string means field is not yet taken.
     * example
     * [['X', 'O', '']
     * ['X', 'O', 'O']
     * ['', '', '']]
     * Returns an array, containing x and y coordinates for
     * next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
     *
     * @param array $boardState Current board state
     * @param string $playerUnit Player unit representation
     *
     * @return array
     */
    public function makeMove($boardState, $playerUnit = 'x')
    {
        //replace (inject, pass etc.) with any other input strategy
        $inputToGame = new SquareBoard();
        $game = $inputToGame->getGame($boardState);

        $game->setPlayer($playerUnit);

        //replace (inject, pass etc.) with any other logic strategy
        $gameToNewGame = new MiniMax();
        $newGame = $gameToNewGame->getNewGame($game);

        //replace (inject, pass etc.) with any other output strategy
        $gameToOutput = new Point();
        return $gameToOutput->transfer($game, $newGame);
    }
}