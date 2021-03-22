<?php

namespace App\DataFixtures;

use App\Controller\EtablissementController;
use App\Entity\Commentaire;
use App\Repository\EtablissementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $commentaire = new Commentaire();
        $commentaire->setAuteur("Niccolò Paganini");
        $commentaire->setDateCreation(new \DateTime("now", null));
        $commentaire->setTexte("Aggiacciato tremar trà nevi algenti
Al Severo Spirar d'orrido Vento,
Correr battendo i piedi ogni momento;
E pel Soverchio gel batter i denti;

Passar al foco i di quieti e contenti
Mentre la pioggia fuor bagna ben cento

Caminar Sopra 'l giaccio, e à passo lento
Per timor di cader gersene intenti;");
        $commentaire->setNote(4);
        $etablissement = $manager->getRepository(EtablissementRepository::class)->findByUAI("9870033X");
        $commentaire->setUai($etablissement);

        $manager->persist();

        $manager->flush();
    }
}
