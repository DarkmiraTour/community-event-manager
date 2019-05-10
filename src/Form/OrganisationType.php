<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\OrganisationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrganisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('website', UrlType::class, [
                'required' => true,
                'help' => 'Must start with http:// or https://',
            ])
            ->add('contact', ContactType::class, ['required' => true])
            ->add('comment', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrganisationRequest::class,
        ]);
    }
}
