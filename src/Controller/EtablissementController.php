<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissement', name: 'etablissement')]
    public function index(): Response
    {
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }

    #[Route('/lecture_csv', name: 'lecture_csv')]
    public function lecture_csv(): Response
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $sRet           = '';



        return new Response('Lecture réalisé sans echec, les retours sont:<br/>' . $sRet);
    }
}
