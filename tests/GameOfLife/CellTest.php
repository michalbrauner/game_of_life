<?php

namespace Tests\GameOfLife;

use GameOfLife\Cell;
use GameOfLife\CellInterface;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{

    const STATE_ALIVE = true;
    const STATE_DEAD = false;

    /**
     * @dataProvider stateForNextIterationProvider
     *
     * @param bool $expectedIsAlive
     * @param string $initialState
     * @param int $numberOfAliveNeighbours
     */
    public function testUpdateStateForNextIteration(
        bool $expectedIsAlive,
        string $initialState,
        int $numberOfAliveNeighbours
    ) {
        $cell = new Cell($initialState, 1, 1);

        $cell->updateStateForNextIteration($numberOfAliveNeighbours);

        $this->assertEquals($expectedIsAlive, $cell->isAlive());
    }

    /**
     * @return array
     */
    public function stateForNextIterationProvider(): array
    {
        return [
            [self::STATE_ALIVE, CellInterface::STATE_DEAD, 3],
            [self::STATE_DEAD, CellInterface::STATE_DEAD, 2],
            [self::STATE_DEAD, CellInterface::STATE_DEAD, 4],
            [self::STATE_DEAD, CellInterface::STATE_ALIVE, 1],
            [self::STATE_DEAD, CellInterface::STATE_ALIVE, 1],
            [self::STATE_ALIVE, CellInterface::STATE_ALIVE, 2],
            [self::STATE_ALIVE, CellInterface::STATE_ALIVE, 3],
        ];
    }

    public function testGetPosition()
    {
        $cell = new Cell(CellInterface::STATE_ALIVE, 1, 2);

        $this->assertEquals(1, $cell->getPositionX());
    }

    public function testGetPositionY()
    {
        $cell = new Cell(CellInterface::STATE_ALIVE, 1, 2);

        $this->assertEquals(2, $cell->getPositionY());
    }

    /**
     * @dataProvider cellStateProvider
     *
     * @param string $state
     */
    public function testIsAlive(string $state)
    {
        $cell = new Cell($state, 1, 1);

        if ($state === CellInterface::STATE_ALIVE) {
            $this->assertTrue($cell->isAlive());
        } else {
            $this->assertFalse($cell->isAlive());
        }
    }

    /**
     * @return array
     */
    public function cellStateProvider(): array
    {
        return [
            [CellInterface::STATE_DEAD],
            [CellInterface::STATE_ALIVE],
        ];
    }

}
