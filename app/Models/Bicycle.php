<?php

/**
 * Class Bicycle
 * Represents a bicycle with operational and physical characteristics.
 * Tests exist in tests/Unit/BicycleTest.php
 */
class Bicycle {
    const MAX_SPEED = 50; // mph
    const DECELERATE_SPEED = 1;
    const MAX_SEAT_HEIGHT = 6; // in
    const MIN_SEAT_HEIGHT = 0;
    
    private $frame;
    private $handlebars;
    private $seat;
    private $wheels;
    private $pedals;
    private $brakes;
    private $gears;
    private $chain;
    private $speed;
    private $currentGear;
    private $seatHeight;
    private $hasFlatTire = false;

    /**
     * Constructor for the Bicycle class.
     * 
     * @param string $frame The frame material of the bicycle, defaults to Steel.
     * @param bool $handlebars Presence or type of handlebars, defaults to true.
     * @param bool $seat Presence of a seat, defaults to false.
     * @param int $wheels Number of wheels, defaults to 2.
     * @param int $pedals Number of pedals, defaults to 2.
     * @param bool $brakes Presence of brakes, defaults to true.
     * @param int $gears Number of gears, defaults to 10.
     * @param bool $chain Presence of a chain, defaults to true.
     * @param int $speed Initial speed, defaults to 0.
     * @param int $currentGear Initial gear, defaults to 1.
     * @param int $seatHeight Initial seat height, defaults to 0.
     */
    public function __construct(
        string $frame = "Steel",
        bool $handlebars = true,
        bool $seat = true,
        int $wheels = 2,
        int $pedals = 2,
        bool $brakes = true,
        int $gears = 10,
        bool $chain = true,
        int $speed = 0,
        int $currentGear = 1,
        int $seatHeight = 0
    ) {
        if ($wheels <= 0) {
            throw new \InvalidArgumentException("Number of wheels must be positive.");
        }
        if ($pedals <= 0) {
            throw new \InvalidArgumentException("Number of pedals must be positive.");
        }
        if ($gears <= 0) {
            throw new \InvalidArgumentException("Number of gears must be positive.");
        }
        if ($speed < 0) {
            throw new \InvalidArgumentException("Speed cannot be negative.");
        }
        if ($currentGear < 1 || $currentGear > $gears) {
            throw new \InvalidArgumentException("Current gear must be within the range of available gears.");
        }
        if ($seatHeight < self::MIN_SEAT_HEIGHT || $seatHeight > self::MAX_SEAT_HEIGHT) {
            throw new \InvalidArgumentException("Seat height must be between " . self::MIN_SEAT_HEIGHT . " and " . self::MAX_SEAT_HEIGHT . ".");
        }

        $this->frame = $frame;
        $this->handlebars = $handlebars;
        $this->seat = $seat;
        $this->wheels = $wheels;
        $this->pedals = $pedals;
        $this->brakes = $brakes;
        $this->gears = $gears;
        $this->chain = $chain;
        $this->speed = $speed;
        $this->currentGear = $currentGear;
        $this->seatHeight = $seatHeight;
    }

    public function getFrame() {
        return $this->frame;
    }

    public function getHandlebars() {
        return $this->handlebars;
    }

    public function getSeat() {
        return $this->seat;
    }

    public function getWheels() {
        return $this->wheels;
    }

    public function getPedals() {
        return $this->pedals;
    }

    public function getBrakes() {
        return $this->brakes;
    }

    public function getGears() {
        return $this->gears;
    }

    public function getChain() {
        return $this->chain;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getCurrentGear() {
        return $this->currentGear;
    }

    public function getSeatHeight() {
        return $this->seatHeight;
    }

    /**
     * simulates a scenerio for testing where the bicycle cannot run
     */
    public function simulateFlatTire() {
        $this->hasFlatTire = true;
    }
    
    /**
     * Attempts to start the bicycle.
     * Throws an exception if the bicycle cannot run.
     *
     * @throws \Exception If the bicycle is not in a runnable state.
     */
    public function start() {
        if ($this->canRun()) {
            $this->pedal(1);
            return "Bicycle is running.\n";
        } else {
            throw new Exception("Bicycle cannot run.");
        }
    }

    /**
     * Checks if the bicycle is in a runnable state using the bare essentials.
     *
     * @return bool True if the bicycle can run, false otherwise.
     */
    private function canRun() {
        return $this->frame && $this->handlebars && $this->wheels == 2 && $this->pedals === 2 && $this->brakes && $this->gears && $this->chain && !$this->hasFlatTire;;
    }

    /**
     * Increases the bicycle's speed based on the power of pedaling.
     *
     * @param int $power The power applied to the pedals.
     */
    public function pedal(int $power) {
        if (!$this->canRun()) {
            throw new \RuntimeException("Cannot pedal because bicycle cannot run.");
        }
        $this->speed += $power;
        if ($this->speed > self::MAX_SPEED) {
            $this->speed = self::MAX_SPEED;
        }
    }

    /**
     * Applies the brakes to reduce the bicycle's speed.
     * If the bicycle is not moving or brakes are not functional, it does nothing.
     */
    public function brake() {
        if ($this->speed && $this->brakes) {
            $this->speed -= self::DECELERATE_SPEED;
            if ($this->speed <= 0) {
                $this->speed = 0;
                return "Bicycle has stopped.\n";
            } else {
                return "Braking. Speed: $this->speed.\n";
            }
        } else {
            return "Cannot apply brakes. Bicycle is not moving or brakes are not functional.\n";
        }
    }

    /**
     * Adjusts the height of the bicycle seat.
     *
     * @param int $newHeight The new height of the seat.
     */
    public function adjustSeatHeight(int $newHeight) {
        $this->seatHeight = $newHeight;
        if ($this->seatHeight > self::MAX_SEAT_HEIGHT) {
            $this->seatHeight = self::MAX_SEAT_HEIGHT;
        }
        if ($this->seatHeight < self::MIN_SEAT_HEIGHT) {
            $this->seatHeight = self::MIN_SEAT_HEIGHT;
        }
        return "Seat height adjusted to $this->seatHeight.\n";
    }

    /**
     * Changes the current gear of the bicycle.
     *
     * @param int $gear The gear number to change to.
     * @throws \Exception If the specified gear is invalid.
     */
    public function changeGear(int $gear) {
        if ($gear > 0 && $gear <= $this->gears) {
            $this->currentGear = $gear;
            return "Gear changed to $gear.\n";
        } else {
            throw new \InvalidArgumentException("Invalid gear: $gear");
        }
    }
}