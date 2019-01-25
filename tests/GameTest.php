<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 1/25/19
 * Time: 4:58 PM
 */

use \PHPUnit\Framework\TestCase;

use TIC_TAC_TOE\Game;

/**
 * Class GameTest
 */
class GameTest extends TestCase
{
    public function providerValidBoard(): Generator
    {
        yield [['x', 'o', 'x', '', 'o', '', '', 'x', 'o']];

        yield [['', 'o', 'x', 'x', '', 'o', '', 'x', '']];

        yield [['', '', '', '', 'x', '', '', '', '']];

        yield [['', 'o', 'o', '', 'x', 'o', 'o', '', 'x']];

        yield [['o', '', 'x', '', '', '', '', '', '']];

        yield [['', '', '', '', 'o', '', '', '', '']];

        yield [['x', '', '', '', 'o', 'x', '', 'o', 'x']];
    }

    /**
     * @param array $board
     * @dataProvider providerValidBoard
     */
    public function testValidBoard(array $board): void
    {
        $this->assertInstanceOf(Game::class, new Game($board));
    }

    public function providerInvalidBoard(): Generator
    {
        yield 'board size is not valid' => [
            ['x', '', 'o'],
            'Board should have exactly 9 values'
        ];

        yield 'value is not valid' => [
            ['', '', '', '', 'i', '', '', '', ''],
            'Board line value should be either...'
        ];
    }

    /**
     * @param $input
     * @param string $expectedMessage
     * @dataProvider providerInvalidBoard
     */
    public function testInvalidBoard($board, string $expectedMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        new Game($board);
    }
}