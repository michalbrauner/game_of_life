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
    public function updateStateForNextIteration(Grid $grid): void
    {
        $this->state = self::STATE_DEAD;
    }

    /**
     * @inheritdoc
     */
    public function isAlive(): bool
    {
        return $this->state === self::STATE_ALIVE;
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

}
