<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'carte')]
    public function index(): Response
    {
        return $this->render('carte/index.html.twig', [
            'controller_name' => 'CarteController',
        ]);
    }

    #[Route('/carte/commune/{id}', name: 'vueCarte')]
    public function vueCarte(): Response
    {
        return $this->render('carte/vue.html.twig');
    }
}
