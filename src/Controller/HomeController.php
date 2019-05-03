<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
    *   @param PropertyRepository $repository
    */

    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLastest();
        return $this->render('pages/home/index.html.twig', [
            'properties'=> $properties
        ]);
    }
}
