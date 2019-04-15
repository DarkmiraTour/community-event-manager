<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\OrganisationSponsorRequest;
use App\Entity\SpecialBenefit;
use App\Entity\SponsorshipLevel;
use App\Repository\SpecialBenefit\SpecialBenefitRepositoryInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrganisationSponsorType extends AbstractType
{
    private $benefitRepository;
    private $levelRepository;

    public function __construct(SpecialBenefitRepositoryInterface $benefitRepository, SponsorshipLevelRepositoryInterface $levelRepository)
    {
        $this->benefitRepository = $benefitRepository;
        $this->levelRepository = $levelRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialBenefit', EntityType::class, [
                'required' => false,
                'class' => SpecialBenefit::class,
                'choices' => $this->benefitRepository->findAll(),
                'label' => 'Special package',
                'choice_label' => function (SpecialBenefit $specialBenefit) {
                    return $specialBenefit->getLabel().' - '.number_format($specialBenefit->getPrice(), 2).'€';
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('sponsorshipLevel', EntityType::class, [
                'required' => false,
                'class' => SponsorshipLevel::class,
                'choices' => $this->levelRepository->findAll(),
                'choice_label' => function (SponsorshipLevel $sponsorshipLevel) {
                    return $sponsorshipLevel->getLabel().' - '.number_format($sponsorshipLevel->getPrice(), 2).'€';
                },
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrganisationSponsorRequest::class,
        ]);
    }
}
