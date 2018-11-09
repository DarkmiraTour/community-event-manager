<?php declare(strict_types=1);

namespace App\Dto;

use App\Entity\Speaker;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

final class SpeakerRequest
{
    /**
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\Length(max=5)
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @Assert\Email()
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     */
    public $biography;

    /**
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"})
     */
    public $photo;

    /**
     * @Assert\Length(max=255)
     */
    public $photoPath;

    /**
     * @Assert\Url()
     * @Assert\Length(max=255)
     */
    public $twitter;

    /**
     * @Assert\Url()
     * @Assert\Length(max=255)
     */
    public $facebook;

    /**
     * @Assert\Url()
     * @Assert\Length(max=255)
     */
    public $linkedin;

    /**
     * @Assert\Url()
     * @Assert\Length(max=255)
     */
    public $github;

    public static function createFromEntity(Speaker $speaker): self
    {
        $request = new self;

        $request->name = $speaker->getName();
        $request->title = $speaker->getTitle();
        $request->email = $speaker->getEmail();
        $request->biography = $speaker->getBiography();
        $request->photo = new File($speaker->getPhoto(), false);
        $request->twitter = $speaker->getTwitter();
        $request->facebook = $speaker->getFacebook();
        $request->linkedin = $speaker->getLinkedin();
        $request->github = $speaker->getGithub();

        return $request;
    }

    public function updateEntity(Speaker $speaker): Speaker
    {
        $speaker->setName($this->name)
            ->setTitle($this->title)
            ->setEmail($this->email)
            ->setBiography($this->biography)
            ->setTwitter($this->twitter)
            ->setFacebook($this->facebook)
            ->setLinkedin($this->linkedin)
            ->setGithub($this->github);

        if ($this->photoPath) {
            $speaker->setPhoto($this->photoPath);
        }

        return $speaker;
    }
}
