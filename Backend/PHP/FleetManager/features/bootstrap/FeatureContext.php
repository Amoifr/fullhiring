<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\App\Query\GetVehicleLocationQuery;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\CommandBus;
use Fulll\Infra\ErrorDTO\AlreadyParkAtThisLocationErrorDTO;
use Fulll\Infra\ErrorDTO\AlreadyPresentVehicleInFleetErrorDTO;
use Fulll\Infra\ErrorStack;

class FeatureContext implements Context
{
    private Fleet $fleet;
    private Fleet $secondFleet;
    private Vehicle $vehicle;
    private Location $location;
    private ErrorStack $errorStack;

    public function __construct()
    {
        $this->errorStack = ErrorStack::getInstance();
    }

    /**
     * @Given my fleet
     */
    public function createFleet(): void
    {
        $this->fleet = new Fleet();
    }

    /**
     * @Given the fleet of another user
     */
    public function createSecondFleet(): void
    {
        $this->secondFleet = new Fleet();
    }


    /**
     * @Given a vehicle
     *
     */
    public function createVehicle(): void
    {
        $this->vehicle = new Vehicle();
    }

    /**
     * @Given my vehicle has been parked into this location
     *
     */
    public function parkVehicleToLocation(): void
    {
        $this->parkVehicle();
    }

    /**
     * @When I try to park my vehicle at this location
     *
     */
    public function tryParkVehicleToLocation(): void
    {
        $this->parkVehicle();
    }

    /**
     * @Given a location
     */
    public function createLocation(): void
    {
        $this->location = new Location(0.0, 0.0);
    }
    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function registerVehicleIntoFleet(Fleet $fleet): void
    {
        try {
            $commandBus = new CommandBus();
            $commandBus->handle(new RegisterVehicleIntoFleetCommand($fleet, $this->vehicle));
        } catch (Exception $e) {
            $this->errorStack->addError(
                new AlreadyPresentVehicleInFleetErrorDTO(
                    $this->vehicle,
                    $fleet
                )
            );
        }
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function registerVehicleIntoAnotherFleet(): void
    {
        $this->registerVehicleIntoFleet($this->secondFleet);
    }


    /**
     * @When I register this vehicle into my fleet
     */
    public function registerVehicleIntoMyFleet(): void
    {
        $this->registerVehicleIntoFleet($this->fleet);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function assertVehicleIsPartOfFleet(): void
    {
        try {
            $commandBus = new CommandBus();
            $vehicles = $commandBus->handle(new GetFleetVehiclesQuery($this->fleet));
            if (!in_array($this->vehicle, $vehicles)) {
                throw new \RuntimeException('Vehicle is not part of fleet');
            }
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @Then I try to register this vehicle into my fleet
     */
    public function registerVehicleIntoAFleet(): void
    {
        $this->registerVehicleIntoFleet($this->fleet);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function parkVehicle(): void
    {
        try {
            $commandBus = new CommandBus();
            $commandBus->handle(new ParkVehicleCommand($this->vehicle, $this->location));
        } catch (Exception $e) {
            $this->errorStack->addError(
                new AlreadyParkAtThisLocationErrorDTO(
                    $this->vehicle,
                    $this->location
                )
            );
        }
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function assertLocationStoredIsCorrect(): void
    {
        try {
            $commandBus = new CommandBus();
            $location = $commandBus->handle(new GetVehicleLocationQuery($this->vehicle));
            if ($location->getLatitude() !== $this->location->getLatitude() || $location->getLongitude() !== $this->location->getLongitude()) {
                throw new \RuntimeException('location is different than expected');
            }
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function assertGetInformedAlreadyVehicleInFleet(): void
    {
        try {
            $errorStack = ErrorStack::getInstance();
            $errorExists = $errorStack->errorExists(
                new AlreadyPresentVehicleInFleetErrorDTO(
                    $this->vehicle,
                    $this->fleet
                )
            );
            if (!$errorExists) {
                throw new \RuntimeException("Don't throw error");
            }
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function assertGetInformedAlreadyParked(): void
    {
        try {
            $errorStack = ErrorStack::getInstance();
            $errorExists = $errorStack->errorExists(
                new AlreadyParkAtThisLocationErrorDTO(
                    $this->vehicle,
                    $this->location
                )
            );
            if (!$errorExists) {
                throw new \RuntimeException("Don't throw error");
            }
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
