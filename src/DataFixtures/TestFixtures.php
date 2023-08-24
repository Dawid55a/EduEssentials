<?php

namespace App\DataFixtures;

use App\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $test = new Test();
        $test->setName('Test 1');
        $test->setWeight(2);
        $test->setStatus(1);
        $test->setCourseSubject($this->getReference('courseSubject1'));
        $test->setTeacher($this->getReference('teacher1'));

        $manager->persist($test);
        $test2 = new Test();
        $test2->setName('Test 2');
        $test2->setWeight(5);
        $test2->setStatus(0);
        $test2->setTeacher($this->getReference('teacher3'));
        $test2->setCourseSubject($this->getReference('courseSubject4'));
        $manager->persist($test2);

        $test3 = new Test();
        $test3->setName('Test 3');
        $test3->setWeight(3);
        $test3->setStatus(1);
        $test3->setCourseSubject($this->getReference('courseSubject1'));
        $test3->setTeacher($this->getReference('teacher1'));
        $manager->persist($test3);

        $manager->flush();

        $this->addReference('test1', $test);
        $this->addReference('test2', $test2);
        $this->addReference('test3', $test3);

    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
            CourseSubjectFixtures::class
        ];
    }
}