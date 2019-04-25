<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\OrganisationCsvUpload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class OrganisationCsvUploadRequest
{
    /**
     * @var UploadedFile
     * @Assert\NotBlank(message="Please upload a valid csv")
     * @Assert\File(
     *     maxSize = "8M",
     *     maxSizeMessage="The csv is too big to be uploaded, the maximum size is 8M",
     *     mimeTypes={"text/csv", "text/plain"},
     *     mimeTypesMessage = "Please upload a valid csv"
     * )
     */
    public $name;

    public static function createFromEntity(OrganisationCsvUpload $organisationCsvUpload): OrganisationCsvUploadRequest
    {
        return new OrganisationCsvUploadRequest(
            $organisationCsvUpload->getName()
        );
    }
}
