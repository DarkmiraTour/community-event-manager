<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\ScheduleRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daysAvailables = [
            ' -- Select -- ' => '',
            '2019-06-08' => '2019-06-08',
            '2019-06-09' => '2019-06-09',
        ];

        $builder
            ->add('day', ChoiceType::class, [
                'choices' => $daysAvailables,
                'required' => true,
                'data' => ' -- Select -- ',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('location', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Room 1, Room 2...']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScheduleRequest::class,
        ]);
    }
}