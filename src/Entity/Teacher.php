<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Teacher extends User
{
    public function __construct()
    {
        parent::__construct();

        // Check if the user has the ROLE_TEACHER role
        if (!in_array('ROLE_TEACHER', $this->getRoles())) {
            throw new \LogicException('A Teacher must have the ROLE_TEACHER role.');
        }
    }

}