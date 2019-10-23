<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Example: Headquarter, Antenna...',
                    'class' => 'form-control',
                    'maxlength' => '63',
                ],
            ])
            ->add('streetAddress', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '127',
                ],
            ])
            ->add('streetAddressComplementary', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '127',
                ],
            ])
            ->add('postalCode', TextType::class, ['required' => true], [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '15',
                ],
            ])
            ->add('city', TextType::class, ['required' => true], [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '63',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
