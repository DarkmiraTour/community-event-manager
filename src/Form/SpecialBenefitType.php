<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SpecialBenefitRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SpecialBenefitType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->add('price', NumberType::class)
            ->add('description', TextareaType::class)
            ->setDataMapper($this)
        ;
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);
        $data = new SpecialBenefitRequest(
            $forms['label']->getData(),
            $forms['price']->getData(),
            $forms['description']->getData()
        );
    }

    public function mapDataToForms($data, $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['label']->setData($data && isset($data->label) ? $data->label : '');
        $forms['price']->setData($data && isset($data->price) ? $data->price : null);
        $forms['description']->setData($data && isset($data->description) ? $data->description : '');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialBenefitRequest::class,
            'empty_data' => null,
        ]);
    }
}
