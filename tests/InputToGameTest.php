<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 1/25/19
 * Time: 4:12 PM
 */

use \PHPUnit\Framework\TestCase;

use TIC_TAC_TOE\InputToGame\SquareBoard;
use TIC_TAC_TOE\Game;

/**
 * Class InputToGameTest
 */
class InputToGameTest extends TestCase
{
    /**
     * @var SquareBoard
     */
    private $squareBoard;

    public function setUp(): void
    {
        parent::setUp();

        $this->squareBoard = new SquareBoard();
    }

    public function providerValidSquareBoardTransfer(): Generator
    {
        yield '3x3' => [
            [
                ['x', 'o', 'x'],
                ['', 'o', ''],
                ['', 'x', 'o'],
            ],
            ['x', 'o', 'x', '', 'o', '', '', 'x', 'o']
        ];

        yield '4x4' => [
            [
                ['o', 'o', 'x', 'x'],
                ['', 'o', '', 'o'],
                ['', 'x', 'o', ''],
                ['', 'x', 'o', ''],
            ],
            ['o', 'o', 'x', 'x', '', 'o', '', 'o', '', 'x', 'o', '', '', 'x', 'o', '']
        ];

        yield '2x2' => [
            [
                ['o', 'x'],
                ['', 'x']
            ],
            ['o', 'x', '', 'x']
        ];
    }

    /**
     * @param array $input
     * @param array $expected
     * @dataProvider providerValidSquareBoardTransfer
     */
    public function testValidSquareBoardTransfer(array $input, array $expected): void
    {
        $this->assertEquals($this->squareBoard->transferBoard($input), $expected);
    }

    public function providerValidSquareBoardGetGame(): Generator
    {
        yield [
            [
                ['x', 'o', 'x'],
                ['', 'o', ''],
                ['', 'x', 'o'],
            ],
            new Game(['x', 'o', 'x', '', 'o', '', '', 'x', 'o'])
        ];

        yield [
            [
                ['', '', 'x'],
                ['x', 'o', ''],
                ['o', 'x', 'o'],
            ],
            new Game(['', '', 'x', 'x', 'o', '', 'o', 'x', 'o'])
        ];

        yield [
            [
                ['x', '', 'x'],
                ['x', '', ''],
                ['o', '', 'o'],
            ],
            new Game(['x', '', 'x', 'x', '', '', 'o', '', 'o'])
        ];
    }

    /**
     * @param array $input
     * @param Game $expected
     * @dataProvider providerValidSquareBoardGetGame
     */
    public function testValidSquareBoardGetGame(array $input, Game $expected): void
    {
        $this->assertEquals($this->squareBoard->getGame($input), $expected);
    }

    public function providerInvalidSquareBoardTransfer(): Generator
    {
        yield 'board is not an array' => [
            'x',
            'Square board should be an array'
        ];

        yield 'board line in not an array' => [
            ['x'],
            'Square board line should be an array'
        ];

        yield 'not a square' => [
            [
                ['o', 'x'],
                ['', 'x', 'o']
            ],
            'Square board lines should have the same length'
        ];
    }

    /**
     * @param $input
     * @param string $expectedMessage
     * @dataProvider providerInvalidSquareBoardTransfer
     */
    public function testInvalidSquareBoardTransfer($input, string $expectedMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $this->squareBoard->transferBoard($input);
    }
}