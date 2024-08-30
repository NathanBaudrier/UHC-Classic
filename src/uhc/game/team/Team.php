<?php

namespace uhc\game\team;

use uhc\UPlayer;

class Team {

    private int $id;
    private string $name;
    private string $colorPrefix;
    /**
     * @var UPlayer[]
     */
    private array $members = [];

    public function __construct(int $id, string $name, string $colorPrefix) {
        $this->id = $id;
        $this->name = $name;
        $this->colorPrefix = $colorPrefix;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getColorPrefix() : string {
        return $this->colorPrefix;
    }

    public function getMembers() : array {
        return $this->members;
    }

    public function addMember(UPlayer $member) : bool {
        $this->members[] = $member;
        return true;
    }

    public function removeMember(UPlayer $member) : void {
        unset($this->members[array_search($member, $this->members)]);
    }

}