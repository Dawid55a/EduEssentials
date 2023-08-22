<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $teacher = new Teacher();
        $teacher->setAuthUser($this->getReference('user-teacher1'));
        $teacher->addSubject($this->getReference('math'));
        $teacher->addSubject($this->getReference('eng'));
        $manager->persist($teacher);

        $teacher2 = new Teacher();
        $teacher2->setAuthUser($this->getReference('user-teacher2'));
        $teacher2->addSubject($this->getReference('math'));
        $manager->persist($teacher2);

        $teacher3 = new Teacher();
        $teacher3->setAuthUser($this->getReference('user-teacher3'));
        $teacher3->addSubject($this->getReference('eng'));
        $manager->persist($teacher3);


        $manager->flush();

        $this->addReference('teacher1', $teacher);
        $this->addReference('teacher2', $teacher2);
        $this->addReference('teacher3', $teacher3);

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SubjectFixtures::class
        ];
    }
}