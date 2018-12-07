<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SponsorshipLevelRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SponsorshipLevelType extends AbstractType implements DataMapperInterface
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
            ->setDataMapper($this);
    }

    public function mapDataToForms($data, $forms): void
    {
        if (null !== $data) {
            $forms = iterator_to_array($forms);
            $forms['label']->setData($data->label ?? '');
            $forms['price']->setData($data->price ?? null);
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        if (null === $data) {
            $data = new SponsorshipLevelRequest();
        }

        $data = new SponsorshipLevelRequest();
        $data->label = $forms['label']->getData();
        $data->price = $forms['price']->getData();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorshipLevelRequest::class,
            'empty_data' => null,
        ]);
    }
}
