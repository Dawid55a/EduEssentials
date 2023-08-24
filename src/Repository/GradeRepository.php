<?php

namespace App\Repository;

use App\Entity\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grade>
 *
 * @method Grade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grade[]    findAll()
 * @method Grade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    public function findGradeByStudentId($studentId)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.student = :studentId')
            ->setParameter('studentId', $studentId)
            ->getQuery()
            ->getResult();
    }

    public function findGradesWithSubjectAndTestByStudentId($studentId)
    {
        $qb = $this->createQueryBuilder('g');
        $qb->select('g.grade', 's.name as subject', 't.name', 't.weight')
            ->andWhere('g.student = :studentId')
            ->setParameter('studentId', $studentId)
            ->leftJoin('g.test', 't')
            ->leftJoin('t.subject', 's');
        return $qb->getQuery()->getResult();
    }

}
