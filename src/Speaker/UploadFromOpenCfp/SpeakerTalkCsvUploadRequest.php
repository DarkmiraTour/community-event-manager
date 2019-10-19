<?php

declare(strict_types=1);

namespace App\Speaker\UploadFromOpenCfp;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class SpeakerTalkCsvUploadRequest
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
    public $emailExportCsvFile;

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
    public $talkExportCsvFile;
}
