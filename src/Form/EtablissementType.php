<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uai')
            ->add('appellation_officelle')
            ->add('denomination')
            ->add('secteur')
            ->add('latitude')
            ->add('longitude')
            ->add('adresse')
            ->add('departement')
            ->add('code_departement')
            ->add('commune')
            ->add('region')
            ->add('academie')
            ->add('code_postal')
            ->add('date_ouverture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
