<?php

namespace App\Repository;

use App\Entity\CourseSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseSubject>
 *
 * @method CourseSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseSubject[]    findAll()
 * @method CourseSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseSubject::class);
    }

//    /**
//     * @return CourseSubject[] Returns an array of CourseSubject objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CourseSubject
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findTeachersGroupedBySubjectsByIds(array $ids): array
    {
        $qb = $this->createQueryBuilder('courseSubject');

        $qb
            ->addSelect('teacher')
            ->addSelect('subject')
            ->addSelect('course')
            ->leftJoin('courseSubject.teacher', 'teacher')
            ->leftJoin('courseSubject.subject', 'subject')
            ->leftJoin('courseSubject.course', 'course')
            ->andWhere('teacher.id IN (:ids)')
            ->orderBy('subject.name', 'ASC')
            ->addOrderBy('course.name', 'ASC')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
