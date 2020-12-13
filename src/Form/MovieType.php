<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('resume', null, [
                'label' => 'Résumé',
            ])
            ->add('synopsis')
            ->add('ad_sortie', null, [
                'label' => 'Jour de sortie',
            ])
            ->add('affiche')
            ->add('afficher', null, [
                'label' => 'Ne pas afficher',
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
            ])
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'label' => 'Acteurs',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
