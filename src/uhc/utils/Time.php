<?php


declare(strict_types=1);

namespace uhc\utils;

final class Time {

    private int $seconds;
    private int $minutes;
    private int $hours;

    public function __construct(int $seconds = 0, int $minutes = 0, int $hours = 0) {
        $this->seconds = $seconds;
        $this->minutes = $minutes;
        $this->hours = $hours;

        $this->update();
    }

    public function getSeconds() : int {
        return $this->seconds;
    }

    public function setSeconds(int $seconds) : void {
        $this->seconds = $seconds;
    }

    public function addSeconds(int $seconds) : void {
        $this->seconds += $seconds;
    }

    public function getMinutes() : int {
        return $this->minutes;
    }

    public function setMinutes(int $minutes) : void {
        $this->minutes = $minutes;
    }

    public function addMinutes(int $minutes) : void {
        $this->minutes += $minutes;
    }

    public function getHours() : int {
        return $this->hours;
    }

    public function setHours(int $hours) : void {
        $this->hours = $hours;
    }

    public function addHours(int $hours) : void {
        $this->hours += $hours;
    }

    //to remake
    public function getFormat() : string {
        $text = "";
        if ($this->hours > 0) $text .= $this->hours . "h ";
        if ($this->minutes > 0) $text .= $this->minutes . "m ";
        return $text .= $this->seconds . "s";
    }

    public function bigger(Time $time) : Time {
        if ($this->hours == $time->getHours()) {
            if ($this->minutes == $time->getMinutes()) {
                return $this->seconds >= $time->getSeconds() ? $this : $time;
            } else return $this->minutes > $time->getMinutes() ? $this : $time;
        } else return $this->hours > $time->getHours() ? $this : $time;
    }

    public function equals(self $time) : bool {
        return $time->getSeconds() == $this->seconds && $time->getMinutes() == $this->minutes && $time->getHours() == $this->hours;
    }

    public function plus(self $time) : self {
        return new self(
            $this->seconds + $time->getSeconds(),
            $this->minutes + $time->getMinutes(),
            $this->hours + $time->getHours()
        );
    }

    public function minus(self $time) : self {
        if ($this->bigger($time) !== $this) return new self();

        $hours = $this->hours - $time->getHours();

        if ($time->getMinutes() > $this->minutes) {
            $hours -= 1;
            $minutes = 60 - abs($time->getMinutes() - $this->minutes);
        } else $minutes = $this->minutes - $time->getMinutes();

        if ($time->getSeconds() > $this->seconds) {
            $minutes -= 1;
            $seconds = 60 - abs($time->getSeconds() - $this->seconds);
        } else $seconds = $this->seconds - $time->getSeconds();

        return new self($seconds, $minutes, $hours);
    }

    public function timestampToTime(int $timestamp) : self {
        $hours = (int)($timestamp / 3600);
        $minutes = (int)(($timestamp - $hours * 3600) / 60);
        $seconds = (int)(($timestamp - $hours * 3600 - $minutes * 60) / 60);

        return new self($seconds, $minutes, $hours);
    }

    public function update() : void {
        if ($this->seconds >= 60) $this->seconds = 0;
        $this->minutes++;
        if ($this->minutes >= 60) $this->minutes = 0;
        $this->hours++;
    }
}