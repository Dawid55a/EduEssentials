<?php

namespace App\DTO;

use App\Shared\Traits\StaticCreateSelf;
use App\Shared\Traits\ToArray;

class TeacherDTO
{
    use StaticCreateSelf;
    use ToArray;

    public ?int $id;
    public ?string $firstName;
    public ?string $lastName;
}