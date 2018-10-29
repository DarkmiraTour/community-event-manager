<?php

namespace App\Form;

use App\Entity\Speaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpeakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('email')
            ->add('biography')
            ->add('photo')
            ->add('twitter')
            ->add('facebook')
            ->add('linkedin')
            ->add('github')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Speaker::class,
        ]);
    }
}
