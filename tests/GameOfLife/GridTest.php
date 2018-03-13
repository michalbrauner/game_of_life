<?php

namespace Tests\GameOfLife;

use GameOfLife\CellInterface;
use GameOfLife\CellsPositionsMap;
use GameOfLife\Grid;
use Generator;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{

    public function testGetCellsWithMoreCalls()
    {
        $grid = new Grid(2, 2, new CellsPositionsMap([]));

        $positions1 = $this->getPositionsFromCellsGenerator($grid->getCells());
        $this->assertCount(4, $positions1);

        $positions2 = $this->getPositionsFromCellsGenerator($grid->getCells());
        $this->assertEquals($positions1, $positions2);
    }

    /**
     * @dataProvider  getCellsProvider
     *
     * @param array $expectedPositions
     * @param int $sizeX
     * @param int $sizeY
     */
    public function testGetCells(array $expectedPositions, int $sizeX, int $sizeY)
    {
        $grid = new Grid($sizeX, $sizeY, new CellsPositionsMap([]));

        $positions = $this->getPositionsFromCellsGenerator($grid->getCells());

        $this->assertEquals($this->sortCellPositions($expectedPositions), $this->sortCellPositions($positions));
    }

    /**
     * @return array
     */
    public function getCellsProvider(): array
    {
        return [
            '2 x 3' => [
                [
                    [0, 0], [1, 0],
                    [0, 1], [1, 1],
                    [0, 2], [1, 2],
                ],
                2,
                3,
            ],
            '1 x 1' => [
                [
                    [0, 0],
                ],
                1,
                1,
            ],
            '0 x 0' => [
                [],
                0,
                0,
            ],
            '1 x 0' => [
                [],
                1,
                0,
            ],
            '0 x 1' => [
                [],
                1,
                0,
            ],
        ];
    }

    /**
     * @dataProvider  neighboursProvider
     *
     * @param array $expectedNeighbourPositions
     * @param int $cellPositionX
     * @param int $cellPositionY
     * @param CellsPositionsMap $aliveCellsPositionsMap
     */
    public function testGetAliveNeighbours(
        array $expectedNeighbourPositions,
        int $cellPositionX,
        int $cellPositionY,
        CellsPositionsMap $aliveCellsPositionsMap
    ) {
        $grid = new Grid(5, 5, $aliveCellsPositionsMap);

        $neighboursPositions = $this->getPositionsFromCellsGenerator(
            $grid->getAliveNeighbours($cellPositionX, $cellPositionY)
        );

        $this->assertEquals(
            $this->sortCellPositions($expectedNeighbourPositions),
            $this->sortCellPositions($neighboursPositions)
        );
    }

    /**
     * @return array
     */
    public function neighboursProvider(): array
    {
        $allNeighboursPositions = [
            [1, 1], [2, 1], [3, 1],
            [1, 2], [3, 2],
            [1, 3], [2, 3], [3, 3],
        ];

        $neighboursTopLeftCorner = [[0, 1], [1, 0], [1, 1]];
        $neighboursBottomLeftCorner = [[0, 3], [1, 3], [1, 4]];
        $neighboursTopRightCorner = [[3, 0], [3, 1], [4, 1]];
        $neighboursBottomRightCorner = [[3, 3], [3, 4], [4, 3]];

        return [
            'Cell have all neighbours, all cells are alive' => [
                $allNeighboursPositions,
                2,
                2,
                new CellsPositionsMap($allNeighboursPositions),
            ],
            'Cell have only one alive neighbours' => [
                [
                    [2, 1], [2, 3], [3, 3],
                ],
                2,
                2,
                new CellsPositionsMap(
                    [
                        [2, 1], [2, 3], [3, 3],
                    ]
                ),
            ],
            'Cell is in top left corner of grid, all cells are alive' => [
                $neighboursTopLeftCorner,
                0,
                0,
                new CellsPositionsMap($neighboursTopLeftCorner),
            ],
            'Cell is in bottom left corner of grid, all cells are alive' => [
                $neighboursBottomLeftCorner,
                0,
                4,
                new CellsPositionsMap($neighboursBottomLeftCorner),
            ],
            'Cell is in top right corner of grid, all cells are alive' => [
                $neighboursTopRightCorner,
                4,
                0,
                new CellsPositionsMap($neighboursTopRightCorner),
            ],
            'Cell is in bottom right corner of grid, all cells are alive' => [
                $neighboursBottomRightCorner,
                4,
                4,
                new CellsPositionsMap($neighboursBottomRightCorner),
            ],
        ];
    }

    /**
     * @param array $positions
     * @return array
     */
    private function sortCellPositions(array $positions): array
    {
        usort(
            $positions,
            function (array $positionData1, array $positionData2) {

                if ($positionData1[0] != $positionData2[0]) {
                    return ($positionData1[0] < $positionData2[0]) ? -1 : 1;
                }

                return ($positionData1[1] < $positionData2[1]) ? -1 : 1;

            }
        );

        return $positions;
    }

    /**
     * @param Generator $cellsGenerator
     * @return array
     */
    private function getPositionsFromCellsGenerator(Generator $cellsGenerator): array
    {
        return array_map(
            function (CellInterface $cell) {
                return [
                    $cell->getPositionX(),
                    $cell->getPositionY(),
                ];
            },
            iterator_to_array($cellsGenerator)
        );
    }

}
