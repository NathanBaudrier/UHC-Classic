<?php

namespace uhc\game\teams;

use uhc\Main;
use uhc\UPlayer;

class Team {

    private int $id;
    private string $name;
    private string $colorPrefix;
    private string $imagePath = "textures/";

    /**
     * @var UPlayer[]
     */
    private array $members = [];
    private int $size = 2;
    private bool $enabled = false;

    public function __construct(int $id, string $name, string $colorPrefix, string $imagePath) {
        $this->id = $id;
        $this->name = $name;
        $this->colorPrefix = $colorPrefix;
        $this->imagePath .= $imagePath;
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

    public function getImagePath() : string {
        return $this->imagePath;
    }

    public function getMembers() : array {
        return $this->members;
    }

    public function addMember(UPlayer $member) : bool {
        if(count($this->members) >= $this->size) return false;

        $this->members[] = $member;
        return true;
    }

    public function removeMember(UPlayer $member) : void {
        unset($this->members[array_search($member, $this->members)]);
    }

    public function getSize() : int {
        return $this->size;
    }

    public function setSize(int $size) : bool {
        if($size <= 1 || $size > 5) return false;

        $this->size = $size;
        return true;
    }

    public function isEnabled() : bool {
        return $this->enabled;
    }

    public function enable() : void {
        $this->enabled = true;
    }

    public function disable() : void {
        $this->enabled = false;
        $this->members = [];
    }

}