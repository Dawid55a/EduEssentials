<?php

namespace App\DataFixtures;

use App\Entity\CourseSubject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseSubjectFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $courseSubject = new CourseSubject();
        $courseSubject->setCourse($this->getReference('basic'));
        $courseSubject->setSubject($this->getReference('math'));
        $courseSubject->setTeacher($this->getReference('teacher1'));
        $manager->persist($courseSubject);

        $courseSubject2 = new CourseSubject();
        $courseSubject2->setCourse($this->getReference('basic'));
        $courseSubject2->setSubject($this->getReference('eng'));
        $courseSubject2->setTeacher($this->getReference('teacher1'));
        $manager->persist($courseSubject2);

        $courseSubject3 = new CourseSubject();
        $courseSubject3->setCourse($this->getReference('advanced'));
        $courseSubject3->setSubject($this->getReference('math'));
        $courseSubject3->setTeacher($this->getReference('teacher2'));
        $manager->persist($courseSubject3);

        $courseSubject4 = new CourseSubject();
        $courseSubject4->setCourse($this->getReference('advanced'));
        $courseSubject4->setSubject($this->getReference('eng'));
        $courseSubject4->setTeacher($this->getReference('teacher3'));
        $manager->persist($courseSubject4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CourseFixtures::class,
            SubjectFixtures::class,
            TeacherFixtures::class
        ];
    }
}