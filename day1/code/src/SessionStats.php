<?php

namespace tdd;

/**
 * This is intended as a quick object just to hold the values we need for this
 * short exercise, decoupling the data from the other logic. In a real
 * environment this could be a Doctrine Entity or some other storage object.
 * Having it be it's own class allows this change to be done later without
 * interfering with the other code
 */
class SessionStats
{
    public int   $minimum_value;
    public int   $maximum_value;
    public int   $number_of_values;
    public float $average_value;

    public function __construct(int $minimum_value, int $maximum_value, int $number_of_values, float $average_value)
    {
        $this->minimum_value = $minimum_value;
        $this->maximum_value = $maximum_value;
        $this->number_of_values = $number_of_values;
        $this->average_value = $average_value;
    }
}
