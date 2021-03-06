<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setName('Task number: ' . $i);
            $task->setCreatedAt(new \DateTime('now'));

            $manager->persist($task);
        }

        $manager->flush();
    }
}
