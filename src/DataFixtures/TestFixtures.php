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
        $test->setSubject($this->getReference('math'));
        $test->setTeacher($this->getReference('teacher1'));

        $manager->persist($test);
        $test2 = new Test();
        $test2->setName('Test 2');
        $test2->setWeight(5);
        $test2->setStatus(0);
        $test2->setSubject($this->getReference('eng'));
        $test2->setTeacher($this->getReference('teacher3'));

        $manager->persist($test2);
        $manager->flush();

        $this->addReference('test1', $test);
        $this->addReference('test2', $test2);
    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
            SubjectFixtures::class
        ];
    }
}