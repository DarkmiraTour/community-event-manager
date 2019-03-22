<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SlotRequest;
use App\Entity\Space;
use App\Entity\SlotType as SlotTypeEntity;
use App\Entity\Talk;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SlotType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => SlotTypeEntity::class,
                'choice_label' => function (SlotTypeEntity $slotType) {
                    return $slotType->getDescription();
                },
            ])
            ->add('space', EntityType::class, [
                'class' => Space::class,
                'choice_label' => 'name',
                'group_by' => function (Space $space) {
                    return $space->getSchedule()
                        ->getDay()
                        ->format('d/m/Y')
                    ;
                },
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Example: PHP in 2019',
                    'minlength' => '5',
                    'maxlength' => '50',
                ],
            ])
            ->add('start', TimeType::class)
            ->add('end', TimeType::class)
            ->add('talk', EntityType::class, [
                'required' => false,
                'class' => Talk::class,
                'choice_label' => 'title',
                'attr' => ['class' => 'form-control'],
            ])
            ->setDataMapper($this)
        ;
    }

    public function mapDataToForms($data, $forms): void
    {
        if (null !== $data) {
            $forms = iterator_to_array($forms);
            $forms['title']->setData($data->title ?? null);
            $forms['type']->setData($data->type ?? null);
            $forms['start']->setData($data->start ?? null);
            $forms['end']->setData($data->end ?? null);
            $forms['space']->setData($data->space ?? null);
            $forms['talk']->setData($data->talk ?? null);
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        $data = new SlotRequest();
        $data->title = $forms['title']->getData();
        $data->type = $forms['type']->getData();
        $data->start = $forms['start']->getData();
        $data->end = $forms['end']->getData();
        $data->space = $forms['space']->getData();
        $data->talk = $forms['talk']->getData();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SlotRequest::class,
        ]);
    }
}
