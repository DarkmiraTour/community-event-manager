<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SpaceRequest;
use App\Entity\SpaceType as SpaceTypeEntity;
use App\Schedule\Schedule;
use App\Schedule\ScheduleRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpaceType extends AbstractType
{
    private $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('visible', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('type', EntityType::class, [
                'required' => true,
                'class' => SpaceTypeEntity::class,
                'choice_label' => function (SpaceTypeEntity $spaceType) {
                    return $spaceType->getName();
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Example: Room 1, Hall',
                ],
            ])
            ->add('schedule', EntityType::class, [
                'class' => Schedule::class,
                'choices' => $this->scheduleRepository->findAllForSelectedEvent(),
                'choice_label' => function (Schedule $schedule) {
                    return $schedule->getDay()->format('d/m/Y');
                },
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpaceRequest::class,
        ]);
    }
}
