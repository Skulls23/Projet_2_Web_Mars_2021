<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uai', TextType::class)
            ->add('appellation_officelle', TextType::class)
            ->add('denomination', TextType::class)
            ->add('secteur', TextType::class)
            ->add('latitude', NumberType::class)
            ->add('longitude', NumberType::class)
            ->add('adresse', TextType::class)
            ->add('departement', TextType::class)
            ->add('code_departement', IntegerType::class)
            ->add('commune', TextType::class)
            ->add('region', TextType::class)
            ->add('academie', TextType::class)
            ->add('code_postal', IntegerType::class)
            ->add('date_ouverture', DateType::class, array("years" => range(1950, 2100)))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
