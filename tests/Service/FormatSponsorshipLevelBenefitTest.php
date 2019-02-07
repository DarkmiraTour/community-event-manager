<?php
/**
 * Created by PhpStorm.
 * User: btaralle
 * Date: 2019-02-07
 * Time: 17:41
 */

namespace App\Tests\Service;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Service\FormatSponsorshipLevelBenefit;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

class FormatSponsorshipLevelBenefitTest extends TestCase
{
    private $sponsorshipBenefitManagerProphecy;
    private $sponsorshipLevelManagerProphecy;
    private $sponsorshipLevelBenefitManagerProphecy;
    private $formatSponsorshipLevelBenefit;

    public function setUp()
    {
        $this->sponsorshipBenefitManagerProphecy = $this->prophesize(SponsorshipBenefitManagerInterface::class);
        $this->sponsorshipLevelManagerProphecy = $this->prophesize(SponsorshipLevelManagerInterface::class);
        $this->sponsorshipLevelBenefitManagerProphecy = $this->prophesize(SponsorshipLevelBenefitManagerInterface::class);

        $this->formatSponsorshipLevelBenefit = new FormatSponsorshipLevelBenefit(
            $this->sponsorshipBenefitManagerProphecy->reveal(),
            $this->sponsorshipLevelManagerProphecy->reveal(),
            $this->sponsorshipLevelBenefitManagerProphecy->reveal()
        );
    }

    public function testFormat()
    {
        $this->sponsorshipLevelManagerProphecy->getOrderedList()->shouldBeCalled()->willReturn([]);
        $this->sponsorshipBenefitManagerProphecy->getOrderedList()->shouldBeCalled()->willReturn([]);

        $this->sponsorshipLevelBenefitManagerProphecy->getByBenefitAndLevel(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->formatSponsorshipLevelBenefit->format();
    }
}