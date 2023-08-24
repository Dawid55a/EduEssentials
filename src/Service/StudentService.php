<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Repository\GradeRepository;
use App\Repository\StudentRepository;

#[AllowDynamicProperties]
class StudentService
{

    public function __construct(GradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    public function getGradesBySubjectForStudent($studentId)
    {
        $grades = $this->gradeRepository->findGradesWithSubjectAndTestByStudentId($studentId);
        $groupedGrades = [];
        foreach ($grades as $grade) {
            $subjectName = $grade['subject'];
            if (!array_key_exists($subjectName, $groupedGrades)) {
                $groupedGrades[$subjectName] = [];
            }
            $testName = $grade['name'];
            $groupedGrades[$subjectName][$testName] = [
                'grade' => $grade['grade'],
                'weight' => $grade['weight']
            ];
        }
        return $groupedGrades;
    }

}