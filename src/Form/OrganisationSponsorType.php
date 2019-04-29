<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\OrganisationSponsorRequest;
use App\Repository\SpecialBenefit\SpecialBenefitRepositoryInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrganisationSponsorType extends AbstractType
{
    private $benefitRepository;
    private $levelRepository;
    private $currency;
    private $locale;
    private $numberFormatCurrency;

    public function __construct(
        SpecialBenefitRepositoryInterface $benefitRepository,
        SponsorshipLevelRepositoryInterface $levelRepository,
        string $currency,
        string $locale,
        int $numberFormatCurrency
    ) {
        $this->benefitRepository = $benefitRepository;
        $this->levelRepository = $levelRepository;
        $this->currency = $currency;
        $this->locale = $locale;
        $this->numberFormatCurrency = $numberFormatCurrency;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialBenefit', ChoiceType::class, [
                'required' => false,
                'choices' => $this->getSpecialBenefitsList(),
                'label' => 'Special package',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('sponsorshipLevel', ChoiceType::class, [
                'required' => false,
                'choices' => $this->getSponsorshipLevelsList(),
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    private function getSpecialBenefitsList(): array
    {
        $specialBenefits = [];
        foreach ($this->benefitRepository->findAll() as $specialBenefit) {
            $specialBenefits[$specialBenefit->getLabel().' - '.(new NumberFormatter($this->locale, $this->numberFormatCurrency))->formatCurrency($specialBenefit->getPrice(), $this->currency)] = $specialBenefit;
        }

        return $specialBenefits;
    }

    private function getSponsorshipLevelsList(): array
    {
        $sponsorshipLevels = [];
        foreach ($this->levelRepository->findAll() as $sponsorshipLevel) {
            $sponsorshipLevels[$sponsorshipLevel->getLabel().' - '.(new NumberFormatter($this->locale, $this->numberFormatCurrency))->formatCurrency($sponsorshipLevel->getPrice(), $this->currency)] = $sponsorshipLevel;
        }

        return $sponsorshipLevels;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrganisationSponsorRequest::class,
        ]);
    }
}
