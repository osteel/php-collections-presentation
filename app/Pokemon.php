<?php

namespace App;

class Pokemon
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $types;

    /**
     * @var Abilities
     */
    public $abilities;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id        = (int) $data['id'];
        $this->name      = $data['name']['english'];
        $this->types     = array_map('strtolower', $data['type']);
        $this->abilities = new Abilities($data['base']);
    }

    /**
     * Whether the Pokemon is of the provided type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType(string $type): bool
    {
        return in_array($type, $this->types);
    }

    /**
     * Attack!
     */
    public function attack()
    {
        $this->action('attacks!');
    }

    /**
     * Defend!
     */
    public function defend()
    {
        $this->action('defends itself!');
    }

    /**
     * Run away!
     */
    public function flee()
    {
        $this->action('runs away!');
    }

    /**
     * Display a Pokemon's action.
     *
     * @param string $description
     */
    private function action(string $description)
    {
        echo sprintf("=> %s %s\n", $this->name, $description);
    }
}
