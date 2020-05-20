<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>'Nom de la sortie : '
            ])
            ->add('dateHeureDebut', null,[
                'label'=>'Date et heure de la sortie : '
            ])
            ->add('dateLimiteInscription',DateType::class,[
                'label'=>'Date limite d\'inscription : '
            ])
            ->add('nbInscriptionsMax',null,[
                'label'=>'Nombres de places : '
            ])
            ->add('duree',IntegerType::class,[
                'label'=>'Durée : '
            ])
            ->add('infosSortie', null,[
                'label'=>'Description et infos : '
            ])

            ->add('lieu', EntityType::class,[
                'class'=>Lieu::class,
                'choice_label'=>'name',
                'placeholder'=>'Choisir un lieu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Sortie::class,
        ]);
    }
}
