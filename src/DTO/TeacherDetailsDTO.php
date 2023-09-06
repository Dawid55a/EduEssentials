<?php

namespace App\DTO;

use App\Entity\Subject;
use App\Shared\Traits\StaticCreateSelf;
use App\Shared\Traits\ToArray;
use DateTime;
use Doctrine\Common\Collections\Collection;

class TeacherDetailsDTO
{
    use StaticCreateSelf;
    use ToArray;

    public ?string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $phone;
    public ?string $address;
    public ?DateTime $dateOfBirth;
    /**
     * @var Collection<int, Subject>|null
     */
    public ?Collection $subjects = null;
}