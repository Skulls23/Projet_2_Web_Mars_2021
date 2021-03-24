<?php

namespace App\Controller;

use App\Entity\Etablissement;
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
    public function vueCarte(int $id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Etablissement::class);

        $etablissements = $reposit->findBy(array("code_commune" => $id));

        return $this->render('carte/vue.html.twig', array("etablissements"=>$etablissements));
    }
}
