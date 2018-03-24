<?php

namespace Tests\GameOfLife\WorldReader;

use GameOfLife\CellInterface;
use GameOfLife\WorldReader\CellOutOfWorldException;
use GameOfLife\WorldReader\InvalidNonZeroNumberException;
use GameOfLife\WorldReader\InvalidWorldConfiguration;
use GameOfLife\WorldReader\XmlWorldReader;
use PHPUnit\Framework\TestCase;

class XmlWorldReaderTest extends TestCase
{

    /**
     * @dataProvider invalidWorldsData
     *
     * @param string $exception
     * @param string $exceptionMessage
     * @param string $xmlFile
     * @throws InvalidNonZeroNumberException
     * @throws InvalidWorldConfiguration
     */
    public function testShouldThrownExceptionWhenWorldIsInvalid(
        string $exception,
        string $exceptionMessage,
        string $xmlFile
    ) {
        $xmlWorldReader = new XmlWorldReader($this->getXmlFileWithDirectory($xmlFile));

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $xmlWorldReader->load();
    }

    public function invalidWorldsData()
    {
        return [
            'World with invalid size X' => [
                InvalidNonZeroNumberException::class,
                "Invalid non-zero number: 'invalid_size'",
                'world_with_invalid_size_x.xml',
            ],
            'World with invalid size Y' => [
                InvalidNonZeroNumberException::class,
                "Invalid non-zero number: 'invalid_size'",
                'world_with_invalid_size_x.xml',
            ],
            'World with zero size X' => [
                InvalidNonZeroNumberException::class,
                "Invalid non-zero number: '0'",
                'world_with_zero_size_x.xml',
            ],
            'World with zero size Y' => [
                InvalidNonZeroNumberException::class,
                "Invalid non-zero number: '0'",
                'world_with_zero_size_y.xml',
            ],
            'World with alive cell out of the world on x' => [
                CellOutOfWorldException::class,
                "Cell [5,2] is out of world",
                'world_with_alive_cell_out_of_the_world_on_x.xml',
            ],
            'World with alive cell out of the world on y' => [
                CellOutOfWorldException::class,
                "Cell [2,6] is out of world",
                'world_with_alive_cell_out_of_the_world_on_y.xml',
            ],
        ];
    }

    /**
     * @dataProvider validWorldsData
     *
     * @param array $expectedAliveCellPositions
     * @param string $xmlFile
     * @throws InvalidNonZeroNumberException
     * @throws InvalidWorldConfiguration
     */
    public function testShouldLoadValidWorld(array $expectedAliveCellPositions, string $xmlFile)
    {
        $xmlWorldReader = new XmlWorldReader($this->getXmlFileWithDirectory($xmlFile));

        $world = $xmlWorldReader->load();

        $aliveCells = array_filter(
            iterator_to_array($world->getGrid()->getCells()),
            function (CellInterface $cell) {
                return $cell->isAlive();
            }
        );

        $aliveCellsPositions = array_map(
            function (CellInterface $cell) {
                return [$cell->getPositionX(), $cell->getPositionY()];
            },
            $aliveCells
        );

        $this->assertEquals(
            $this->sortCellPositions(array_values($expectedAliveCellPositions)),
            $this->sortCellPositions(array_values($aliveCellsPositions))
        );
    }

    /**
     * @return array
     */
    public function validWorldsData()
    {
        return [
            'World with two alive cells' => [
                [
                    [2, 2],
                    [2, 3],
                ],
                'world_with_two_alive_cells.xml',
            ],
            'World with no alive cells' => [
                [],
                'world_with_no_alive_cells.xml',
            ],
        ];
    }

    /**
     * @param string $xmlFile
     * @return string
     */
    private function getXmlFileWithDirectory(string $xmlFile): string
    {
        $xmlFileWithDirectory = __DIR__ . '/test_files/' . $xmlFile;

        return $xmlFileWithDirectory;
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
