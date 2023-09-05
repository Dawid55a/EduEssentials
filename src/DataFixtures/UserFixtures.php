<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Create subjects


        // Create course

        // Name array
        $names = array(
            'John',
            'Jane',
            'Jack',
            'Jill',
            'Jim');
        // Surname array
        $surnames = array(
            'Smith',
            'Jones',
            'Williams',
            'Brown',
            'Taylor');

        // Create teachers
        $teacher1 = new User();
        $teacher1->setRoles(['ROLE_TEACHER']);
        $teacher1->setEmail('teacher1@example.com');
        $teacher1->setPassword($this->passwordHasher->hashPassword($teacher1, 'password'));
        $teacher1->setFirstName('John');
        $teacher1->setLastName('Smith');
        $teacher1->setPhoneNumber("123456789");
        $teacher1->setAddress("123 Fake Street");
        $teacher1->setDateOfBirth(new DateTime('now'));
        $manager->persist($teacher1);

        $teacher2 = new User();
        $teacher2->setRoles(['ROLE_TEACHER']);
        $teacher2->setEmail('teacher2@example.com');
        $teacher2->setPassword($this->passwordHasher->hashPassword($teacher2, 'password'));
        $teacher2->setFirstName('Jane');
        $teacher2->setLastName('Jones');
        $teacher2->setPhoneNumber("123456789");
        $teacher2->setAddress("123 Fake Street");
        $teacher2->setDateOfBirth(new DateTime('now'));
        $manager->persist($teacher2);

        $teacher3 = new User();
        $teacher3->setRoles(['ROLE_TEACHER']);
        $teacher3->setEmail('teacher3@example.com');
        $teacher3->setPassword($this->passwordHasher->hashPassword($teacher3, 'password'));
        $teacher3->setFirstName('Jack');
        $teacher3->setLastName('Williams');
        $teacher3->setPhoneNumber("123456789");
        $teacher3->setAddress("123 Fake Street");
        $teacher3->setDateOfBirth(new DateTime('now'));
        $manager->persist($teacher3);


        $user1 = new User();
        $user1->setRoles(['ROLE_STUDENT']);
        $user1->setEmail('user1@example.com');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password'));
        $user1->setFirstName('First1');
        $user1->setLastName('Last1');
        $user1->setPhoneNumber("123456789");
        $user1->setAddress("123 Fake Street");
        $user1->setDateOfBirth(new DateTime('now'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setRoles(['ROLE_STUDENT']);
        $user2->setEmail('user2@example.com');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'password'));
        $user2->setFirstName('First2');
        $user2->setLastName('Last2');
        $user2->setPhoneNumber("123456789");
        $user2->setAddress("123 Fake Street");
        $user2->setDateOfBirth(new DateTime('now'));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setRoles(['ROLE_STUDENT']);
        $user3->setEmail('user3@example.com');
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'password'));
        $user3->setFirstName('First3');
        $user3->setLastName('Last3');
        $user3->setPhoneNumber("123456789");
        $user3->setAddress("123 Fake Street");
        $user3->setDateOfBirth(new DateTime('now'));
        $manager->persist($user3);

        $user4 = new User();
        $user4->setRoles(['ROLE_STUDENT']);
        $user4->setEmail('user4@example.com');
        $user4->setPassword($this->passwordHasher->hashPassword($user4, 'password'));
        $user4->setFirstName('First4');
        $user4->setLastName('Last4');
        $user4->setPhoneNumber("123456789");
        $user4->setAddress("123 Fake Street");
        $user4->setDateOfBirth(new DateTime('now'));
        $manager->persist($user4);
        $manager->flush();

        $this->addReference('user-teacher1', $teacher1);
        $this->addReference('user-teacher2', $teacher2);
        $this->addReference('user-teacher3', $teacher3);
        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
        $this->addReference('user4', $user4);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setFirstName('Admin');
        $admin->setLastName('Admin');
        $admin->setPhoneNumber("123456789");
        $admin->setAddress("123 Fake Street");
        $admin->setDateOfBirth(new DateTime('now'));
        $manager->persist($admin);
        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
            SubjectFixtures::class,
            CourseFixtures::class,
        ];
    }
}
