<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\SortiesSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
            'class'=> Campus::class,
            'choice_label'=> 'nom',
            'placeholder'=>'Choisissez un campus',
            'required'=>false
        ])
            ->add('keyword', null,[
                'label' => 'Le nom de la sortie contient :'
            ])
            ->add('dateDebut', DateType::class,[
                'label' =>'Entre : ',
                'widget' => 'single_text',
                'required'=>false
            ])
            ->add('dateFin', DateType::class,[
                'label' =>'et : ',
                'widget' => 'single_text',
                'required'=>false
            ])
            ->add('isOrganisateur', CheckboxType::class, [
                'label'=>'Sorties dont je suis l\'oganisateur/trice',
                'required'=>false
            ])
            ->add('isInscrit', CheckboxType::class,[
                'label'=>'Sorties auxquelles je suis inscrit/e',
                'required'=>false
            ])
            ->add('isNotInscrit', CheckboxType::class,[
                'label'=>'Sorties auxquelles je ne suis pas incrit/e',
                'required'=>false
            ])
            ->add('isFinished', CheckboxType::class,[
                'label'=>'Sorties passées',
                'required'=>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SortiesSearch::class,
            'method'=> 'get',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
