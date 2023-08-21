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
        $grade->setValue(5);
        $grade->setStudent($this->getReference('user1'));
        $grade->setTest($this->getReference('test1'));
        $grade->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade);

        $grade2 = new Grade();
        $grade2->setValue(4);
        $grade2->setStudent($this->getReference('user2'));
        $grade2->setTest($this->getReference('test1'));
        $grade2->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade2);

        $grade3 = new Grade();
        $grade3->setValue(3);
        $grade3->setStudent($this->getReference('user3'));
        $grade3->setTest($this->getReference('test1'));
        $grade3->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade3);

        $grade4 = new Grade();
        $grade4->setValue(2);
        $grade4->setStudent($this->getReference('user4'));
        $grade4->setTest($this->getReference('test1'));
        $grade4->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade4);

        $grade5 = new Grade();
        $grade5->setValue(1);
        $grade5->setStudent($this->getReference('user1'));
        $grade5->setTest($this->getReference('test2'));
        $grade5->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade5);

        $grade6 = new Grade();
        $grade6->setValue(2);
        $grade6->setStudent($this->getReference('user2'));
        $grade6->setTest($this->getReference('test2'));
        $grade6->setIssueDatetime(new \DateTime('now'));
        $manager->persist($grade6);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TestFixtures::class,
            UserFixtures::class,
        ];
    }
}