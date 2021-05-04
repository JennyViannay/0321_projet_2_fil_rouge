<?php

namespace App\Controller;

use Exception;
use PhpParser\Node\Stmt\TryCatch;

class TryController extends AbstractController
{
    private function index($a, $b)
    {
        if ($b === 0 || $a === 0) {
            throw new Exception('La divion par 0 n\'est pas possible');
        }
        return $a / $b;
    }
}