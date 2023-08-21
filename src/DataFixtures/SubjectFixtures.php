<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $subject1 = new Subject();
        $subject1->setName('Mathematics');
        $subject1->setShortName('MATH');
        $manager->persist($subject1);

        $subject2 = new Subject();
        $subject2->setName('English');
        $subject2->setShortName('ENG');
        $manager->persist($subject2);

        $manager->flush();

        $this->addReference('math', $subject1);
        $this->addReference('eng', $subject2);

    }


}