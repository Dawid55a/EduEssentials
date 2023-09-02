<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findStudentsInCourse($courseId)
    {
        $qb = $this->createQueryBuilder('student')
            ->addSelect('authUser')
            ->leftJoin('student.course', 'course')
            ->leftJoin('student.auth_user', 'authUser')
            ->andWhere('course.id = :courseId')
            ->setParameter('courseId', $courseId);
        return $qb->getQuery()->getResult();
    }
}
