<?php
declare(strict_types=1);

namespace Domain\Logging\Model;


class Exercise
{
    private $name;

    /**
     * Exercise constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}