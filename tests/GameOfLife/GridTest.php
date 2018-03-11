<?php

namespace GameOfLife;

use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{

    /**
     * @dataProvider  neighboursProvider
     *
     * @param array $expectedNeighbourPositions
     * @param int $cellPositionX
     * @param int $cellPositionY
     */
    public function testGetNeighbours(array $expectedNeighbourPositions, int $cellPositionX, int $cellPositionY)
    {
        $grid = new Grid(5, 5);

        $neighbours = $grid->getNeighbours($cellPositionX, $cellPositionY);
        $neighboursPositions = array_map(
            function (Cell $cell): array {
                return [$cell->getPositionX(), $cell->getPositionY()];
            },
            $neighbours
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
        return [
//            'Cell have all neighbours' => [
//                [
//                    [1, 1], [2, 1], [3, 1],
//                    [1, 2], [3, 2],
//                    [1, 3], [2, 3], [3, 3],
//                ],
//                2,
//                2,
//            ],
            'Cell is in top left corner of grid' => [
                [
                    [0, 1], [1, 0], [1, 1],
                ],
                0,
                0,
            ],
//            'Cell is in bottom left corner of grid' => [
//                [
//                    [0, 3], [1, 3], [1, 4],
//                ],
//                0,
//                4,
//            ],
//            'Cell is in top right corner of grid' => [
//                [
//                    [3, 0], [3, 1], [4, 1],
//                ],
//                4,
//                0,
//            ],
//            'Cell is in bottom right corner of grid' => [
//                [
//                    [3, 3], [3, 4], [4, 3],
//                ],
//                4,
//                4,
//            ],
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

}
