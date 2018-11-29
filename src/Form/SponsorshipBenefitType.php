<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\SponsorshipBenefitRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SponsorshipBenefitType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->setDataMapper($this)
        ;
    }

    public function mapDataToForms($data, $forms): void
    {
        if (null !== $data) {
            $forms = iterator_to_array($forms);
            $forms['label']->setData($data->label ?? '');
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);

        if (null !== $data) {
            $data->updateFromForm(
                $forms['label']->getData()
            );

            return;
        }

        $data = new SponsorshipBenefitRequest(
            $forms['label']->getData()
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorshipBenefitRequest::class,
            'empty_data' => null,
        ]);
    }
}
