<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 1/25/19
 * Time: 4:58 PM
 */

use \PHPUnit\Framework\TestCase;

use TIC_TAC_TOE\GameToNewGame\MiniMax;
use TIC_TAC_TOE\Game;

/**
 * Class GameToNewGameTest
 */
class GameToNewGameTest extends TestCase
{
    /**
     * @var MiniMax
     */
    private $minimax;

    public function setUp(): void
    {
        parent::setUp();

        $this->minimax = new MiniMax();
    }

    public function providerValidMiniMaxGetGame(): Generator
    {
        yield [
            new Game(['', '', '', '', 'x', '', '', '', ''], 'o'),
            new Game(['', '', '', '', 'x', '', '', '', 'o'], 'x')
        ];

        yield [
            new Game(['', '', '', '', 'o', '', '', 'o', 'x'], 'x'),
            new Game(['', '', '', '', 'o', '', 'x', 'o', 'x'], 'o')
        ];

        yield [
            new Game(['', 'o', '', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'x')
        ];

        yield [
            new Game(['x', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['x', 'o', 'o', '', 'x', 'o', 'x', 'x', 'o'], 'x'),
        ];

        yield [
            new Game(['', '', '', '', 'o', '', '', '', ''], 'x'),
            new Game(['', '', '', '', 'o', '', '', 'x', ''], 'o')
        ];

        yield [
            new Game(['', '', '', '', 'x', '', '', 'x', 'o'], 'o'),
            new Game(['', 'o', '', '', 'x', '', '', 'x', 'o'], 'x')
        ];

        yield [
            new Game(['', 'o', '', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'x')
        ];

        yield [
            new Game(['', 'o', 'o', '', 'x', 'x', 'x', 'x', 'o'], 'o'),
            new Game(['o', 'o', 'o', '', 'x', 'x', 'x', 'x', 'o'], 'x')
        ];

        yield [
            new Game(['x', '', '', '', '', '', '', '', ''], 'o'),
            new Game(['x', '', '', '', 'o', '', '', '', ''], 'x')
        ];

        yield [
            new Game(['x', 'x', '', '', 'o', '', '', '', ''], 'o'),
            new Game(['x', 'x', 'o', '', 'o', '', '', '', ''], 'x'),
        ];

        yield [
            new Game(['x', 'x', 'o', '', 'o', '', 'x', '', ''], 'o'),
            new Game(['x', 'x', 'o', 'o', 'o', '', 'x', '', ''], 'x'),
        ];

        yield [
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', ''], 'o'),
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', 'o'], 'x'),
        ];

        yield [
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', 'o'], 'o'),
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', 'o', 'o'], 'x')
        ];
    }

    /**
     * @param Game $input
     * @param Game $expected
     * @dataProvider providerValidMiniMaxGetGame
     */
    public function testValidSquareBoardGetGame(Game $input, Game $expected): void
    {
        $this->assertEquals($this->minimax->getNewGame($input), $expected);
    }
}