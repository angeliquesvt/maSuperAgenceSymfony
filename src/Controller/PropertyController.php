<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;


class PropertyController extends AbstractController
{
    /**
    *   @var PropertyRepository
    */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
    *
    *   @return Response
    *
    */
    public function index(): Response
    {
        return $this->render('pages/property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
    *
    *   @param Property $property
    *
    */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() != $slug) {
            return $this->redirectToRoute('showproperty', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('pages/property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
