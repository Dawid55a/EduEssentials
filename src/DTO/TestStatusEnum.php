<?php

namespace App\DTO;
// Test status enum
enum TestStatusEnum: int
{
    case PLANNED = 0;
    case IN_PROGRESS = 1;
    case FINISHED = 2;
    case GRADED = 3;
}
