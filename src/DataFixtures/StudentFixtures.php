<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $student1 = new Student();
        $student1->setAuthUser($this->getReference('user1'));
        $student1->setCourse($this->getReference('basic'));
        $student1->setNumber(1);
        $manager->persist($student1);

        $student2 = new Student();
        $student2->setAuthUser($this->getReference('user2'));
        $student2->setCourse($this->getReference('basic'));
        $student2->setNumber(2);
        $manager->persist($student2);

        $student3 = new Student();
        $student3->setAuthUser($this->getReference('user3'));
        $student3->setCourse($this->getReference('advanced'));
        $student3->setNumber(1);
        $manager->persist($student3);

        $student4 = new Student();
        $student4->setAuthUser($this->getReference('user4'));
        $student4->setCourse($this->getReference('advanced'));
        $student4->setNumber(2);
        $manager->persist($student4);

        $manager->flush();

        $this->addReference('student1', $student1);
        $this->addReference('student2', $student2);
        $this->addReference('student3', $student3);
        $this->addReference('student4', $student4);

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CourseFixtures::class
        ];
    }
}