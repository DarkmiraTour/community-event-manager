<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Dto\UserRequest;

final class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['required' => true])
            ->add('username', TextType::class, ['required' => true])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['required' => true],
                'first_options' => ['label' => 'Enter password'],
                'second_options' => ['label' => 'Repeat password'],
                'first_name' => 'firstPassword',
                'second_name' => 'secondPassword',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
        ]);
    }
}
