<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 1/25/19
 * Time: 5:51 PM
 */

use \PHPUnit\Framework\TestCase;

use TIC_TAC_TOE\Game;
use TIC_TAC_TOE\GameToOutput\Point;

/**
 * Class GameToOutputTest
 */
class GameToOutputTest extends TestCase
{
    /**
     * @var Point
     */
    private $point;

    public function setUp(): void
    {
        parent::setUp();

        $this->point = new Point();
    }

    public function providerValidPointTransfer(): Generator
    {
        yield [
            new Game(['', '', '', '', 'x', '', '', '', ''], 'o'),
            new Game(['', '', '', '', 'x', '', '', '', 'o'], 'x'),
            [2, 2, 'o']
        ];

        yield [
            new Game(['', '', '', '', 'x', '', '', 'x', 'o'], 'o'),
            new Game(['', 'o', '', '', 'x', '', '', 'x', 'o'], 'x'),
            [1, 0, 'o']
        ];

        yield [
            new Game(['', 'o', '', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'x'),
            [2, 0, 'o']
        ];

        yield [
            new Game(['x', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['x', 'o', 'o', '', 'x', 'o', 'x', 'x', 'o'], 'x'),
            [2, 1, 'o']
        ];

        yield [
            new Game(['', '', '', '', 'o', '', '', '', ''], 'x'),
            new Game(['', '', '', '', 'o', '', '', '', 'x'], 'o'),
            [2, 2, 'x']
        ];

        yield [
            new Game(['', '', '', '', 'x', '', '', 'x', 'o'], 'o'),
            new Game(['', 'o', '', '', 'x', '', '', 'x', 'o'], 'x'),
            [1, 0, 'o']
        ];

        yield [
            new Game(['', 'o', '', '', 'x', '', 'x', 'x', 'o'], 'o'),
            new Game(['', 'o', 'o', '', 'x', '', 'x', 'x', 'o'], 'x'),
            [2, 0, 'o']
        ];

        yield [
            new Game(['', 'o', 'o', '', 'x', 'x', 'x', 'x', 'o'], 'o'),
            new Game(['o', 'o', 'o', '', 'x', 'x', 'x', 'x', 'o'], 'x'),
            [0, 0, 'o']
        ];

        yield [
            new Game(['o', '', '', '', '', '', '', '', ''], 'x'),
            new Game(['o', '', '', '', 'x', '', '', '', ''], 'o'),
            [1, 1, 'x']
        ];

        yield [
            new Game(['x', 'x', '', '', 'o', '', '', '', ''], 'o'),
            new Game(['x', 'x', 'o', '', 'o', '', '', '', ''], 'x'),
            [2, 0, 'o']
        ];

        yield [
            new Game(['o', 'o', 'x', '', 'x', '', 'o', '', ''], 'x'),
            new Game(['o', 'o', 'x', 'x', 'x', '', 'o', '', ''], 'o'),
            [0, 1, 'x']
        ];

        yield [
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', ''], 'o'),
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', 'o'], 'x'),
            [2, 2, 'o']
        ];

        yield [
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', '', 'o'], 'o'),
            new Game(['x', 'x', 'o', 'o', 'o', 'x', 'x', 'o', 'o'], 'x'),
            [1, 2, 'o']
        ];
    }

    /**
     * @param Game $game
     * @param Game $newGame
     * @param array $expected
     * @dataProvider providerValidPointTransfer
     */
    public function testValidPointerTransfer(Game $game, Game $newGame, array $expected): void
    {
        $this->assertEquals($this->point->transfer($game, $newGame), $expected);
    }
}