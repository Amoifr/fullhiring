<?php

declare(strict_types=1);

namespace Fulll\Tests\Integration\Context;

use Behat\Behat\Context\Context;
use Exception;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\App\Query\GetVehicleLocationQuery;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\ErrorDTO\AlreadyParkAtThisLocationErrorDTO;
use Fulll\Infra\ErrorDTO\AlreadyPresentVehicleInFleetErrorDTO;
use Fulll\Infra\ErrorStack;
use Fulll\Kernel;
use RuntimeException;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class FeatureContext implements Context
{
    protected static $kernel;

    private Fleet $fleet;
    private Fleet $secondFleet;
    private Vehicle $vehicle;
    private Location $location;
    private ErrorStack $errorStack;

    public MessageBus $commandBus;
    public MessageBus $queryBus;

    public function __construct()
    {
        $this->errorStack = ErrorStack::getInstance();
        $this->commandBus = static::$kernel->getContainer()->get('messenger.default_bus');
        $this->queryBus = static::$kernel->getContainer()->get('messenger.default_bus');
    }

    /**
     * @BeforeSuite
     */
    public static function prepare($scope)
    {
        require_once __DIR__ . '/../../bootstrap.php';
        self::$kernel = new Kernel('test', true);
        self::$kernel->boot();
        global $kernel;
        $kernel = self::$kernel;
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
     */
    public function createVehicle(): void
    {
        $this->vehicle = new Vehicle();
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function parkVehicleToLocation(): void
    {
        $this->parkVehicle();
    }

    /**
     * @When I try to park my vehicle at this location
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
    public function registerVehicleIntoFleet(): void
    {
        $this->VehicleIntoFleet($this->fleet);
    }

    private function VehicleIntoFleet(Fleet $fleet): void
    {
        try {
            $this->commandBus->dispatch(new RegisterVehicleIntoFleetCommand($fleet, $this->vehicle));
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
            $envelope = $this->queryBus->dispatch(new GetFleetVehiclesQuery($this->fleet));
            $handledStamp = $envelope->last(HandledStamp::class);
            $vehicles = $handledStamp->getResult();
            if (!in_array($this->vehicle, $vehicles)) {
                throw new RuntimeException('Vehicle is not part of fleet');
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @When I try to register this vehicle into my fleet
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
            $this->commandBus->dispatch(new ParkVehicleCommand($this->vehicle, $this->location));
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
            $envelope = $this->queryBus->dispatch(new GetVehicleLocationQuery($this->vehicle));
            $handledStamp = $envelope->last(HandledStamp::class);
            $location = $handledStamp->getResult();
            if ($location->getLatitude() !== $this->location->getLatitude() || $location->getLongitude() !== $this->location->getLongitude()) {
                throw new RuntimeException('location is different than expected');
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     * (see the typo (this this) but I want to keet test files as they have been provided)
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
                throw new RuntimeException("Don't throw error");
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
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
                throw new RuntimeException("Don't throw error");
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
