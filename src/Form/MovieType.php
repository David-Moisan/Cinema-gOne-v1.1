<?php

namespace App\Form;

use App\Entity\Movie;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
