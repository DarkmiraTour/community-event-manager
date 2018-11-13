<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\SpaceType as SpaceTypeEntity;
use App\Dto\SpaceRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SpaceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpaceRequest::class,
        ]);
    }
}