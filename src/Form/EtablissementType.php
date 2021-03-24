<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\SecteurEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('appellation_officelle', TextType::class, array("attr"=>array("required")))
            ->add('denomination', TextType::class)
            ->add('secteur', ChoiceType::class, array("choices" => SecteurEnum::assocValues()))
            ->add('latitude', NumberType::class, array("scale" => 15))
            ->add('longitude', NumberType::class, array("scale" => 15))
            ->add('adresse', TextType::class)
            ->add('departement', TextType::class)
            ->add('code_departement', IntegerType::class, array("attr"=>array("max"=>100000, "min"=>0)))
            ->add('commune', TextType::class)
            ->add('region', TextType::class)
            ->add('academie', TextType::class)
            ->add('code_postal', IntegerType::class, array("attr"=>array("max"=>100000, "min"=>0)))
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
