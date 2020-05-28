<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : '
            ])
            ->add('dateHeureDebut', null, [
                'label' => 'Date et heure de la sortie : '
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite d\'inscription : '
            ])
            ->add('nbInscriptionsMax', null, [
                'label' => 'Nombres de places : '
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée : '
            ])
            ->add('infosSortie', null, [
                'label' => 'Description et infos : '
            ])
            ->add('campusOrganisateur', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                }

            ])
            /*->add('ville', EntityType::class, [
                'class' => Ville::class,
                'placeholder' => 'Selectionnez votre ville',
                'choice_label' => 'nom',
                'mapped' => false,
                'required' => false,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                }

            ])*/
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'placeholder' => 'Selectionnez votre lieu',
                'choice_label' => 'nom',
                'mapped' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                }

            ])
            ->add('enregistrer', SubmitType::class,[
                'label'=>'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary'
                    ]
                ])
            ->add('enregistrerEtPublier', SubmitType::class,[
                'label'=>'Publier',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]

            ]);
    }


       /* $builder->get('ville')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addLieuField($form->getParent(), $form->getData());
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                $lieu = $data->getLieu();
                $form = $event->getForm();
                if($lieu){
                    //On récupère la ville
                    $ville = $lieu->getVille();
                    //On créée le champ supplémentaire
                    $this->addLieuField($form, $ville);
                    //On set les données
                    $form->get('ville')->setData($ville);
                    $form->get('lieu')->setData($lieu);
                }else{
                    //On crée le champ en le laissant vide
                    $this->addLieuField($form, null);
                }
            }
        );



    }

    private function addLieuField(FormInterface $form, ?Ville $ville)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'lieu',
            EntityType::class,
            null,
            [
                'class'=>Lieu::class,
                'placeholder'=>$ville ? 'Sélectionnez le lieu' : 'Selectionnez votre ville',
                'mapped'=>true,
                'required'=>false,
                'auto_initialize'=>false,
                'choices'=>$ville ? $ville->getLieux() : []
            ]
       
        );
        $form->add($builder->getForm());
    }*/




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Sortie::class,
        ]);
    }


}
