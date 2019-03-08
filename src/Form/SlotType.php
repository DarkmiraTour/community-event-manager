<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SlotRequest;
use App\Entity\Space;
use App\Entity\SlotType as SlotTypeEntity;
use App\Entity\Talk;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'required' => true,
                'class' => SlotTypeEntity::class,
                'choice_label' => function (SlotTypeEntity $slotType) {
                    return $slotType->getDescription();
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('space', EntityType::class, [
                'required' => true,
                'class' => Space::class,
                'choice_label' => 'name',
                'group_by' => function (Space $space) {
                    return $space->getSchedule()
                        ->getDay()
                        ->format('d/m/Y');
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Example: PHP in 2019',
                ],
            ])
            ->add('start', TimeType::class, [
                'required' => true,
            ])
            ->add('end', TimeType::class, [
                'required' => true,
            ])
            ->add('talk', EntityType::class, [
                'required' => false,
                'class' => Talk::class,
                'choice_label' => 'title',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SlotRequest::class,
        ]);
    }
}
