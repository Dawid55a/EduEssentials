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
        $qb = $this->createQueryBuilder('grade');
        $qb->select('grade.grade', 'subject.name as subjectName', 'test.name', 'test.weight')
            ->andWhere('grade.student = :studentId')
            ->setParameter('studentId', $studentId)
            ->leftJoin('grade.test', 'test')
            ->leftJoin('test.course_subject', 'courseSubject')
            ->leftJoin('courseSubject.subject', 'subject');
        return $qb->getQuery()->getResult();
    }

    public function findStudentsGradesForCourseAndSubject(int $courseId, int $subjectId)
    {
        $qb = $this->createQueryBuilder('g');
        $qb->select('g.id as gradeId', 'g.grade as grade', 'user.first_name', 'user.last_name')
            ->addSelect('t.name as testName', 't.weight as testWeight', 't.id as testId')
            ->andWhere('courseSubject.course = :courseId')
            ->andWhere('courseSubject.subject = :subjectId')
            ->setParameter('courseId', $courseId)
            ->setParameter('subjectId', $subjectId)
            ->leftJoin('g.student', 'student')
            ->leftJoin('student.auth_user', 'user')
            ->leftJoin('g.test', 't')
            ->leftJoin('t.course_subject', 'courseSubject');
//        dd($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    public function findGradesOnTestForCourseAndSubject(int $courseId, int $subjectId)
    {
        $qb = $this->createQueryBuilder('grade')
            ->select('test', 'grade')
            ->leftJoin('grade.test', 'test')
            ->leftJoin('test.course_subject', 'courseSubject')
            ->andWhere('courseSubject.course = :courseId')
            ->andWhere('courseSubject.subject = :subjectId')
            ->setParameter('courseId', $courseId)
            ->setParameter('subjectId', $subjectId);
        return $qb->getQuery()->getResult();
    }
}
