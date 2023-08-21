<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $course = new Course();
        $course->setName('Basic Course');
        $manager->persist($course);

        $course2 = new Course();
        $course2->setName('Advanced Course');
        $manager->persist($course2);

        $manager->flush();

        $this->addReference('basic', $course);
        $this->addReference('advanced', $course2);
    }
}