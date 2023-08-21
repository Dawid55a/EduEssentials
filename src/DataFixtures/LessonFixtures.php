<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LessonFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $lesson = new Lesson();
        $lesson->setSubject($this->getReference('math'));
        $lesson->setCourse($this->getReference('basic'));
        $lesson->setLessonNumber(1);
        $lesson->setStartDatetime(new \DateTime('now'));
        $lesson->setEndDatetime(new \DateTime('now'));
        $lesson->setTeacher($this->getReference('teacher1'));
        $lesson->setSubstitution(false);
        $lesson->setStatus('active');

        $manager->persist($lesson);

        $lesson2 = new Lesson();
        $lesson2->setSubject($this->getReference('eng'));
        $lesson2->setCourse($this->getReference('advanced'));
        $lesson2->setLessonNumber(2);
        $lesson2->setStartDatetime(new \DateTime('now'));
        $lesson2->setEndDatetime(new \DateTime('now'));
        $lesson2->setTeacher($this->getReference('teacher2'));
        $lesson2->setSubstitution(false);
        $lesson2->setStatus('planned');

        $manager->persist($lesson2);

        $lesson3 = new Lesson();
        $lesson3->setSubject($this->getReference('math'));
        $lesson3->setCourse($this->getReference('basic'));
        $lesson3->setLessonNumber(3);
        $lesson3->setStartDatetime(new \DateTime('now'));
        $lesson3->setEndDatetime(new \DateTime('now'));
        $lesson3->setTeacher($this->getReference('teacher3'));
        $lesson3->setSubstitution(false);
        $lesson3->setStatus('cancelled');

        $manager->persist($lesson3);
        $manager->flush();

        $this->addReference('lesson1', $lesson);
        $this->addReference('lesson2', $lesson2);
        $this->addReference('lesson3', $lesson3);

    }

    public function getDependencies(): array
    {
        return [
            SubjectFixtures::class,
            CourseFixtures::class,
            UserFixtures::class,
        ];
    }
}