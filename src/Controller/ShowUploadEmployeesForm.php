<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShowUploadEmployeesForm extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('upload.html.twig');
    }
}
