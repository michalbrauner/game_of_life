<?php

namespace GameOfLife;

class Cell implements CellInterface
{

    /**
     * @var string
     */
    private $state;

    /**
     * @var int
     */
    private $positionX;

    /**
     * @var int
     */
    private $positionY;

    /**
     * @inheritdoc
     */
    public function __construct(string $state, int $positionX, int $positionY)
    {
        $this->state = $state;
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    /**
     * @inheritdoc
     */
    public function updateStateForNextIteration(int $numberOfAliveNeighbours): void
    {
        if ($this->state === self::STATE_DEAD && $this->shouldBecomeAlive($numberOfAliveNeighbours)) {
            $this->state = self::STATE_ALIVE;
        } elseif ($this->state === self::STATE_ALIVE && $this->shouldDie($numberOfAliveNeighbours)) {
            $this->state = self::STATE_DEAD;
        }
    }

    /**
     * @param int $numberOfAliveNeighbours
     * @return bool
     */
    private function shouldBecomeAlive(int $numberOfAliveNeighbours): bool
    {
        return $numberOfAliveNeighbours === 3;
    }

    /**
     * @param int $numberOfAliveNeighbours
     * @return bool
     */
    private function shouldDie(int $numberOfAliveNeighbours): bool
    {
        return $numberOfAliveNeighbours < 2 || $numberOfAliveNeighbours > 3;
    }

    /**
     * @inheritdoc
     */
    public function getPositionX(): int
    {
        return $this->positionX;
    }

    /**
     * @inheritdoc
     */
    public function getPositionY(): int
    {
        return $this->positionY;
    }

    /**
     * @inheritdoc
     */
    public function isAlive(): bool
    {
        return $this->state === self::STATE_ALIVE;
    }

}
