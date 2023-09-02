<?php

namespace App\Repository;

use App\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Test>
 *
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function findGradesOnTestForCourseAndSubject(int $courseSubjectId)
    {
        $qb = $this->createQueryBuilder('test')
            ->addSelect('grades')
            ->addSelect('student')
            ->leftJoin('test.grades', 'grades')
            ->innerJoin('test.course_subject', 'courseSubject')
            ->leftJoin('grades.student', 'student')
            ->orderBy('grades.student', 'ASC')
            ->andWhere('courseSubject = :courseSubjectId')
            ->setParameter('courseSubjectId', $courseSubjectId);
        return $qb->getQuery()->getResult();


    }

}
