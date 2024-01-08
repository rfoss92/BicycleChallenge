<?php

use PHPUnit\Framework\TestCase;
require 'app/Models/Bicycle.php';

class BicycleTest extends TestCase {
    public function testConstructor() {
        $bicycle = new Bicycle();
        $this->assertEquals("Steel", $bicycle->getFrame());
        $this->assertTrue($bicycle->getHandlebars());
        $this->assertTrue($bicycle->getSeat());
        $this->assertEquals(2, $bicycle->getWheels());
        $this->assertEquals(2, $bicycle->getPedals());
        $this->assertTrue($bicycle->getBrakes());
        $this->assertEquals(10, $bicycle->getGears());
        $this->assertTrue($bicycle->getChain());
        $this->assertEquals(0, $bicycle->getSpeed());
        $this->assertEquals(1, $bicycle->getCurrentGear());
        $this->assertEquals(0, $bicycle->getSeatHeight());
    }

    public function testInvalidConstructorParameters() {
        $this->expectException(\InvalidArgumentException::class);
        new Bicycle("Steel", true, true, -1, 2, true, 6, true, 0, 1, 1); // Invalid number of wheels
    }

    public function testStart() {
        $bicycle = new Bicycle();
        $result = $bicycle->start();
        $this->assertEquals("Bicycle is running.\n", $result);
    }

    public function testPedal() {
        $bicycle = new Bicycle();
        $bicycle->pedal(10);
        $this->assertEquals(10, $bicycle->getSpeed());
    }

    public function testPedalWhenBicycleCannotRun() {
        $bicycle = new Bicycle();
        $bicycle->simulateFlatTire();
        $this->expectException(\RuntimeException::class);
        $bicycle->pedal(10);
    }

    public function testBrake() {
        $bicycle = new Bicycle("Steel", true, true, 2, 2, true, 6, true, 10, 1, 1);
        $bicycle->brake();
        $this->assertEquals(9, $bicycle->getSpeed());
    }

    public function testBrakeWhenBicycleIsStopped() {
        $bicycle = new Bicycle();
        $bicycle->brake();
        $this->assertEquals(0, $bicycle->getSpeed());
    }

    public function testAdjustSeatHeight() {
        $bicycle = new Bicycle();
        $bicycle->adjustSeatHeight(3);
        $this->assertEquals(3, $bicycle->getSeatHeight());
    }

    public function testAdjustSeatHeightBeyondLimits() {
        $bicycle = new Bicycle();

        $bicycle->adjustSeatHeight(Bicycle::MAX_SEAT_HEIGHT + 1);
        $this->assertEquals(Bicycle::MAX_SEAT_HEIGHT, $bicycle->getSeatHeight());

        $bicycle->adjustSeatHeight(Bicycle::MIN_SEAT_HEIGHT - 1);
        $this->assertEquals(Bicycle::MIN_SEAT_HEIGHT, $bicycle->getSeatHeight());
    }

    public function testChangeGear() {
        $bicycle = new Bicycle();
        $bicycle->changeGear(3);
        $this->assertEquals(3, $bicycle->getCurrentGear());
    }

    public function testChangeGearOutOfRange() {
        $bicycle = new Bicycle();
        $this->expectException(\InvalidArgumentException::class);
        $bicycle->changeGear(11); // Assuming the maximum gear is 10
    }
}
