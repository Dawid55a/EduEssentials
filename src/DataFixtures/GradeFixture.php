<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GradeFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $grade = new Grade();
        $grade->setGrade(5);
        $grade->setStudent($this->getReference('student1'));
        $grade->setTest($this->getReference('test1'));
        $grade->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade);

        $grade2 = new Grade();
        $grade2->setGrade(4);
        $grade2->setStudent($this->getReference('student2'));
        $grade2->setTest($this->getReference('test1'));
        $grade2->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade2);

        $grade3 = new Grade();
        $grade3->setGrade(3);
        $grade3->setStudent($this->getReference('student3'));
        $grade3->setTest($this->getReference('test2'));
        $grade3->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade3);

        $grade4 = new Grade();
        $grade4->setGrade(2);
        $grade4->setStudent($this->getReference('student4'));
        $grade4->setTest($this->getReference('test2'));
        $grade4->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade4);

        $grade5 = new Grade();
        $grade5->setGrade(1);
        $grade5->setStudent($this->getReference('student1'));
        $grade5->setTest($this->getReference('test3'));
        $grade5->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade5);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TestFixtures::class,
            StudentFixtures::class,
        ];
    }
}