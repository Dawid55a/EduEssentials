<?php

namespace App\DataFixtures;

use App\Entity\Attendance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AttendanceFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $attendance = new Attendance();
        $attendance->setStudent($this->getReference('user1'));
        $attendance->setLesson($this->getReference('lesson1'));
        $attendance->setStatus('present');
        $manager->persist($attendance);

        $attendance2 = new Attendance();
        $attendance2->setStudent($this->getReference('user2'));
        $attendance2->setLesson($this->getReference('lesson1'));
        $attendance2->setStatus('present');
        $manager->persist($attendance2);

        $attendance3 = new Attendance();
        $attendance3->setStudent($this->getReference('user3'));
        $attendance3->setLesson($this->getReference('lesson1'));
        $attendance3->setStatus('absent');

        $manager->persist($attendance3);

        $attendance4 = new Attendance();
        $attendance4->setStudent($this->getReference('user4'));
        $attendance4->setLesson($this->getReference('lesson1'));
        $attendance4->setStatus('absent');
        $manager->persist($attendance4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LessonFixtures::class,
            UserFixtures::class,
        ];
    }
}