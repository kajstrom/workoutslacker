<?php
declare(strict_types=1);

namespace Domain\Logging\Model;


class Set
{
    /**
     * @var int
     */
    private $repetitions;
    /**
     * @var int
     */
    private $weight;

    public function __construct(int $repetitions, int $weight)
    {
        $this->repetitions = $repetitions;
        $this->weight = $weight;
    }
}