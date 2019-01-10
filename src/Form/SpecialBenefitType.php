<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SpecialBenefitRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SpecialBenefitType extends AbstractType implements DataMapperInterface
{
    private $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->add('price', MoneyType::class, [
                'currency' => $this->currency,
            ])
            ->add('description', TextareaType::class)
            ->setDataMapper($this);
    }

    public function mapDataToForms($data, $forms): void
    {
        if (null !== $data) {
            $forms = iterator_to_array($forms);
            $forms['label']->setData($data->label ?? '');
            $forms['price']->setData($data->price ?? null);
            $forms['description']->setData($data->description ?? '');
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        if (null === $data) {
            $data = new SpecialBenefitRequest();
        }
        $data->label = $forms['label']->getData();
        $data->price = $forms['price']->getData();
        $data->description = $forms['description']->getData();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpecialBenefitRequest::class,
            'empty_data' => null,
        ]);
    }
}
