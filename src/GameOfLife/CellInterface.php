<?php

namespace GameOfLife;

interface CellInterface
{

    const STATE_ALIVE = 'alive';
    const STATE_DEAD = 'dead';

    /**
     * @param string $state
     * @param int $positionX
     * @param int $positionY
     */
    public function __construct(string $state, int $positionX, int $positionY);

    /**
     * @param int $numberOfAliveNeighbours
     */
    public function updateStateForNextIteration(int $numberOfAliveNeighbours): void;

    /**
     * @return bool
     */
    public function isAlive(): bool;

    /**
     * @return int
     */
    public function getPositionX(): int;

    /**
     * @return int
     */
    public function getPositionY(): int;

}
