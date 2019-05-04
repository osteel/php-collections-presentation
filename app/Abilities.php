<?php

namespace App;

class Abilities
{
    /**
     * @var int
     */
    public $hp;

    /**
     * @var int
     */
    public $attack;

    /**
     * @var int
     */
    public $spAttack;

    /**
     * @var int
     */
    public $defense;

    /**
     * @var int
     */
    public $spDefense;

    /**
     * @var int
     */
    public $speed;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hp        = (int) $data['HP'];
        $this->attack    = (int) $data['Attack'];
        $this->spAttack  = (int) $data['Sp. Attack'];
        $this->defense   = (int) $data['Defense'];
        $this->spDefense = (int) $data['Sp. Defense'];
        $this->speed     = (int) $data['Speed'];
    }

    /**
     * Return the sum of the abilities.
     *
     * @return int
     */
    public function sum(): int
    {
        return $this->hp + $this->attack + $this->spAttack + $this->defense + $this->spDefense + $this->speed;
    }
}
