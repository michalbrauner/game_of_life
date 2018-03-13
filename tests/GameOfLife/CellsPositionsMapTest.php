<?php

namespace Tests\GameOfLife;

use GameOfLife\CellsPositionsMap;
use PHPUnit\Framework\TestCase;

class CellsPositionsMapTest extends TestCase
{

    const EXISTS = true;
    const DOES_NOT_EXIST = false;

    /**
     * @dataProvider cellsPositionsProvider
     *
     * @param array $positions
     */
    public function testGetCellsPositions(array $positions)
    {
        $positionsMap = new CellsPositionsMap($positions);

        $returnedPositions = iterator_to_array($positionsMap->getCellsPositions());

        $this->assertEquals($positions, $returnedPositions);
    }

    /**
     * @return array
     */
    public function cellsPositionsProvider(): array
    {
        return [
            'Empty positions' => [
                []
            ],
            'Some positions set' => [
                [
                    [0, 1], [1, 5], [5, 6],
                ],
            ],
        ];
    }

    public function testAddCellPosition()
    {
        $positionsMap = new CellsPositionsMap([]);

        $existsBeforeAdding = $positionsMap->positionExists(0, 0);

        $positionsMap->addCellPosition(0, 0);

        $existsAfterAdding = $positionsMap->positionExists(0, 0);

        $this->assertFalse($existsBeforeAdding);
        $this->assertTrue($existsAfterAdding);
    }

    /**
     * @dataProvider positionsProvider
     *
     * @param bool $expectedExists
     * @param int $positionX
     * @param int $positionY
     */
    public function testPositionExists(bool $expectedExists, int $positionX, int $positionY)
    {
        $positionsMap = new CellsPositionsMap([
            [0, 0], [1, 5], [5, 9],
        ]);

        $exists = $positionsMap->positionExists($positionX, $positionY);

        $this->assertEquals($expectedExists, $exists);
    }

    /**
     * @return array
     */
    public function positionsProvider(): array
    {
        return [
            [self::EXISTS, 0, 0],
            [self::DOES_NOT_EXIST, 0, 1],
            [self::EXISTS, 1, 5],
            [self::DOES_NOT_EXIST, 9, 9],
        ];
    }

}
