<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('teacher, u, s')
            ->from('App\Entity\Teacher', 'teacher')
            ->join('teacher.auth_user', 'u')
            ->join('teacher.subjects', 's')
            ->where('teacher.id IN (:ids)')
            ->setParameter('ids', $ids);
        return $qb->getQuery()->getResult();
    }

    public function searchTeachers(string $search): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('teacher')
            ->from('App\Entity\Teacher', 'teacher')
            ->join('teacher.auth_user', 'u')
            ->where('u.first_name LIKE :search')
            ->orWhere('u.last_name LIKE :search');
        $qb->setParameter('search', '%' . $search . '%');
        $result = $qb->getQuery()->getResult();
        return $result;
    }

}
