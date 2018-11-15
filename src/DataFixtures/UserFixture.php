<?php declare(strict_types=1);

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class UserFixture extends Fixture
{

	private $encodedPassword;

	public function __construct(UserPasswordEncoderInterface $encodedPassword)
	{
		$this->encodedPassword = $encodedPassword;
	}

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();

        $user->setPassword($this->encodedPassword->encodePassword($user, 'random_password'));

        $manager->flush();
    }
}
