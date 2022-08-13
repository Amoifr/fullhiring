<?php

namespace Fulll\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\User;
use Fulll\Domain\Entity\Vehicle;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            'user1' => [
                'username' => 'user1',
                'password' => 'user1',
                'email' => 'user1@email.com',
                'fleet' => [
                    'vehicles' => [
                        'v1' => [
                            'location' => [
                                'latitude' => 1.1,
                                'longitude' => 1.1,
                            ],
                            'plateNumber' => 'AB-000-01',
                        ],
                        'v2' => [
                            'location' => [
                                'latitude' => 1.2,
                                'longitude' => 1.2,
                            ],
                            'plateNumber' => 'AB-000-02',
                        ],
                    ],
                ],
            ],
            'user2' => [
                'username' => 'user2',
                'password' => 'user2',
                'email' => 'user2@email.com',
                'fleet' => [
                    'vehicles' => [
                        'v3' => [
                            'location' => [
                                'latitude' => 1.3,
                                'longitude' => 1.3,
                            ],
                            'plateNumber' => 'AB-000-03',
                        ],
                        'v4' => [
                            'location' => [
                                'latitude' => 1.4,
                                'longitude' => 1.4,
                            ],
                            'plateNumber' => 'AB-000-04',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $user) {
            $userItem = new User();
            $userItem->setUsername($user['username']);
            $userItem->setPassword($user['password']);
            $userItem->setEmail($user['email']);
            $manager->persist($userItem);
            $fleet = new Fleet();
            $fleet->setUser($userItem);
            foreach ($user['fleet']['vehicles'] as $vehicle) {
                $vehicleItem = new Vehicle();
                $vehicleItem->setFleet($fleet);
                $vehicleItem->setPlateNumber($vehicle['plateNumber']);
                $vehicleItem->setLocation(
                    new Location(
                        $vehicle['location']['latitude'],
                        $vehicle['location']['longitude']
                    )
                );
                $fleet->addVehicle($vehicleItem);
                $manager->persist($vehicleItem);
            }
            $userItem->setFleet($fleet);
            $manager->persist($fleet);
            $manager->persist($userItem);
        }

        $manager->flush();
    }
}
