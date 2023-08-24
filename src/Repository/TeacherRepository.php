<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teacher>
 *
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    public function searchTeachersInfoGroupedBySubject(array $ids)
    {
        $qb = $this->createQueryBuilder('teacher');

        $qb
            ->addSelect('authUser')
            ->addSelect('courseSubjects')
            ->leftJoin('teacher.auth_user', 'authUser')
            ->leftJoin('teacher.courseSubjects', 'courseSubjects')
            ->where('teacher.id IN (:ids)')
            ->setParameter('ids', $ids);
        return $qb->getQuery()->getResult();
    }

    public function searchTeachers(string $search): array
    {
        $qb = $this->createQueryBuilder('teacher');

        $qb->innerJoin('teacher.auth_user', 'u')
            ->andWhere('u.first_name LIKE :search OR u.last_name LIKE :search')
            ->setParameter('search', '%' . $search . '%');;
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findTeacherById(int $id): ?Teacher
    {
        $qb = $this->createQueryBuilder('teacher');

        return $qb
            ->select('teacher')
            ->join('teacher.auth_user', 'u')
            ->where('teacher.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findTeacherCourseSubjects(int $id): ?Teacher
    {
        $qb = $this->createQueryBuilder('teacher');

        return $qb
            ->select('teacher')
            ->join('teacher.course', 'c')
            ->join('teacher.subjects', 's')
            ->where('teacher.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
