<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtablissementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $csv = fopen("./data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv", "r+");

        while(! feof($csv))
        {
            $donnees = fgetcsv($csv, 0, ";"); //taille 0 = taille infinie
            $i=0;
            if($i > 0 && $donnees) //donnees renvoie false si on est a la derniere ligne
            {
                $etablissement = new Etablissement();

                $etablissement->setUai                 ($donnees[0]);
                $etablissement->setAppellationOfficelle($donnees[1]);
                $etablissement->setDenomination        ($donnees[2]);
                $etablissement->setSecteur             ($donnees[4]);
                $etablissement->setLatitude            ($donnees[14]);
                $etablissement->setLongitude           ($donnees[15]);
                $etablissement->setAdresse             ($donnees[5]);
                $etablissement->setDepartement         ($donnees[26]);
                $etablissement->setCodeDepartement     ($donnees[22]);
                $etablissement->setCommune             ($donnees[10]);
                $etablissement->setRegion              ($donnees[27]);
                $etablissement->setAcademie            ($donnees[28]);
                $etablissement->setCodePostal          ($donnees[7]);
                $etablissement->setDateOuverture       ($donnees[34]);
            }
        }

        $manager->flush();
    }
}
