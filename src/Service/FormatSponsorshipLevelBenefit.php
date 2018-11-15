<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;

final class FormatSponsorshipLevelBenefit
{
    private $sponsorshipBenefitManager;
    private $sponsorshipLevelManager;
    private $sponsorshipLevelBenefitManager;

    public function __construct(
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager
    ) {
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
    }

    /**
     * @return array
     */
    public function format(): array
    {
        $finalTab = [];

        $benefits = $this->sponsorshipBenefitManager->getOrderedList();
        $levels = $this->sponsorshipLevelManager->getOrderedList();

        foreach ($benefits as $benefit) {
            $tab = [];
            $tab['benefit']['id'] = $benefit->getId();
            $tab['benefit']['label'] = $benefit->getLabel();

            foreach ($levels as $level) {
                $sponsorshipLevelBenefit = $this->sponsorshipLevelBenefitManager->getByBenefitAndLevel($benefit, $level);

                $tabLevel['id'] = $level->getId();
                $tabLevel['isChecked'] = $sponsorshipLevelBenefit != null ? true : false;
                $tabLevel['text'] = $sponsorshipLevelBenefit != null ? $sponsorshipLevelBenefit->getContent() : null;

                $tab['levels'][] = $tabLevel;
            }
            $finalTab[] = $tab;
        }

        return $finalTab;
    }
}
