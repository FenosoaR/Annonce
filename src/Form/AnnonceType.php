<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Categorie', EntityType::class, [
            'class' => 'App:Categorie',
            'choice_label' => 'nom',
            'multiple' => false
        ])
            ->add('detail')
            ->add('date_limite')
            ->add('Ajouter' , SubmitType::class)
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
