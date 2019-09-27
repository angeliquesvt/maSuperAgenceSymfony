<?php

namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManagerInterface;


class AdminPropertyController extends AbstractController {

    /**
    *   @var PropertyRepository
    */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $en) {
        $this->repository = $repository;
        $this->en = $en;
    }

    public function index() {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    public function new(Request $request) {
      $property = new Property();
      $form = $this->createForm(PropertyType::class, $property);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $this->en->persist($property);
        $this->en->flush();
        $this->addFlash('success', 'Bien créé avec succès');
        return $this->redirectToRoute('admin');
      }

      return $this->render('admin/property/new.html.twig', [
          'property' => $property,
          'form' => $form->createView()
      ]);
    }

    /**
    *
    *   @param Property $property
    *   @param Request $resquest
    *
    */

    public function edit(Property $property, Request $request) {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
          $this->en->flush();
          $this->addFlash('success', 'Bien modifié avec succès');
          return $this->redirectToRoute('admin');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    public function delete(Property $property, Request $request) {
      if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get("_token"))) {
        $this->en->remove($property);
        $this->en->flush();
        $this->addFlash('success', 'Bien supprimé avec succès');
      }
      return $this->redirectToRoute('admin');
    }
}
