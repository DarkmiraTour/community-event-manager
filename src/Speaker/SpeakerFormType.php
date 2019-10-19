<?php

declare(strict_types=1);

namespace App\Speaker;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SpeakerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'title',
                ChoiceType::class,
                ['choices' => [
                    'Mr' => 'mr',
                    'Ms' => 'ms',
                ]]
            )
            ->add(
                'email',
                EmailType::class,
                ['required' => true]
            )
            ->add(
                'biography',
                TextareaType::class,
                ['required' => true]
            )
            ->add(
                'photo',
                FileType::class,
                ['required' => false]
            )
            ->add(
                'twitter',
                TextType::class,
                ['required' => false]
            )
            ->add(
                'facebook',
                TextType::class,
                ['required' => false]
            )
            ->add(
                'linkedin',
                TextType::class,
                ['required' => false]
            )
            ->add(
                'github',
                TextType::class,
                ['required' => false]
            )
            ->add(
                'isInterviewSent',
                ChoiceType::class,
                [
                    'expanded' => true,
                    'choices' => [
                        'Yes' => true,
                        'No' => false,
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpeakerRequest::class,
        ]);
    }
}
