<?php

namespace App\DTO;

use App\Shared\Traits\StaticCreateSelf;
use App\Shared\Traits\ToArray;

class TeachersBySubjectDTO
{
    use StaticCreateSelf;
    use ToArray;

    public ?string $subjectName;
    /**
     * @var array<int, TeacherDTO>|null
     */
    public ?array $teachers;
}