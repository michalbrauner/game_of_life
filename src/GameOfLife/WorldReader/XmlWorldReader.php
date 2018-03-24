<?php

namespace GameOfLife\WorldReader;

use GameOfLife\CellsPositionsMap;
use GameOfLife\World;
use Generator;
use SimpleXMLElement;

class XmlWorldReader implements WorldReaderInterface
{

    /**
     * @var string
     */
    private $xmlFile;

    public function __construct(string $xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }

    /**
     * @return World
     * @throws InvalidWorldConfiguration
     * @throws InvalidNonZeroNumberException
     */
    public function load(): World
    {
        $configuration = simplexml_load_file($this->xmlFile);

        $xmlName = $configuration->getName();

        if ($xmlName !== 'World') {
            throw InvalidWorldConfiguration::byNonExistingField('World');
        }

        $attributes = $configuration->attributes();
        $sizeX = $attributes['sizeX'];
        if ($sizeX === null) {
            throw InvalidWorldConfiguration::byNonExistingAttribute('sizeX', 'World');
        }
        $this->validNumber($sizeX);

        $sizeY = $attributes['sizeY'];
        if ($sizeY === null) {
            throw InvalidWorldConfiguration::byNonExistingAttribute('sizeY', 'World');
        }
        $this->validNumber($sizeY);

        if (!isset($configuration->AliveCells)) {
            throw InvalidWorldConfiguration::byNonExistingField('World.AliveCells');
        }

        $cellsPositionsMap = new CellsPositionsMap($this->getAliveCellsPositions($configuration));

        return new World((int)$sizeX, (int)$sizeY, $cellsPositionsMap);
    }

    /**
     * @param string $number
     * @throws InvalidNonZeroNumberException
     */
    private function validNumber(string $number)
    {
        $numberAsInt = (int)$number;

        if ($numberAsInt <= 0) {
            throw InvalidNonZeroNumberException::byValue($number);
        }
    }

    /**
     * @param SimpleXMLElement $configuration
     * @return int[]
     * @throws InvalidWorldConfiguration
     */
    private function getAliveCellsPositions(SimpleXMLElement $configuration): array
    {
        $cellPositions = [];

        /** @var SimpleXMLElement $aliveCells */
        $aliveCellsElement = $configuration->AliveCells;

        if (isset($aliveCellsElement->Cell)) {
            /** @var SimpleXMLElement $cell */
            foreach ($aliveCellsElement->Cell as $cell) {
                $attributes = $cell->attributes();

                $positionX = $attributes['positionX'];
                if ($positionX === null) {
                    throw InvalidWorldConfiguration::byNonExistingAttribute('positionX', 'World.AliveCells.Cell');
                }

                $positionY = $attributes['positionY'];
                if ($positionY === null) {
                    throw InvalidWorldConfiguration::byNonExistingAttribute('positionY', 'World.AliveCells.Cell');
                }

                $cellPositions[] = [(string)$positionX, (string)$positionY];
            }
        }

        return $cellPositions;
    }

}
