<?php

namespace App\Tests\Utils;


use App\DataFixtures\CourseFixtures;
use App\DataFixtures\CourseSubjectFixtures;
use App\DataFixtures\GradeFixture;
use App\DataFixtures\StudentFixtures;
use App\DataFixtures\SubjectFixtures;
use App\DataFixtures\TeacherFixtures;
use App\DataFixtures\TestFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DataFixtureTestCase extends WebTestCase
{

    /** @var AbstractDatabaseTool */
    protected static AbstractDatabaseTool $databaseTool;
    protected ?EntityManagerInterface $entityManager;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        self::loadFixtures();
    }

    private static function loadFixtures(): void
    {
        self::$databaseTool->loadFixtures([
            CourseFixtures::class,
            CourseSubjectFixtures::class,
            GradeFixture::class,
            StudentFixtures::class,
            SubjectFixtures::class,
            TeacherFixtures::class,
            TestFixtures::class,
            UserFixtures::class
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        self::$databaseTool->reloadDatabase();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}