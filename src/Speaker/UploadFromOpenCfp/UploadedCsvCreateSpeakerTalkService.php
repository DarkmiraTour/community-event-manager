<?php

declare(strict_types=1);

namespace App\Speaker\UploadFromOpenCfp;

use App\Speaker\Speaker;
use App\Speaker\SpeakerRepositoryInterface;
use App\Talk\Talk;
use App\Talk\Create\TalkFactory;
use App\Talk\TalkRepositoryInterface;
use SplFileObject;
use Symfony\Component\Process\Exception\LogicException;

final class UploadedCsvCreateSpeakerTalkService
{
    private const CSV_DELIMITER = ',';
    private const DEFAULT_SPEAKER_TITLE = 'Mr/Ms';
    private const DEFAULT_SPEAKER_BIOGRAPHY = 'To be completed...';
    private const DEFAULT_SPEAKER_PHOTO_PATH = '';
    private const TALK_TITLE = 'title';
    private const TALK_DESCRIPTION = 'description';
    private const SPEAKER_FIRST_NAME = 'first_name';
    private const SPEAKER_LAST_NAME = 'last_name';
    private const SPEAKER_EMAIL = 'email';

    private $talkTitleColumnNumber;
    private $talkDescriptionColumnNumber;
    private $emailExportTalkTitleColumnNumber;
    private $speakerFirstNameColumnNumber;
    private $speakerLastNameColumnNumber;
    private $speakerEmailColumnNumber;
    private $speakerRepository;
    private $talkRepository;
    private $talkFactory;
    /**
     * @var Speaker[]
     */
    private $addedSpeakersList = [];
    /**
     * @var Talk[]
     */
    private $addedTalksList = [];

    public function __construct(
        SpeakerRepositoryInterface $speakerRepository,
        TalkRepositoryInterface $talkRepository,
        TalkFactory $talkFactory
    ) {
        $this->speakerRepository = $speakerRepository;
        $this->talkRepository = $talkRepository;
        $this->talkFactory = $talkFactory;
    }

    public function createWithContent(SplFileObject $emailExportCsvFile, SplFileObject $talkExportCsvFile): void
    {
        if (false === $emailExportCsvFile->isReadable()
            || false === $talkExportCsvFile->isReadable()) {
            throw new LogicException('The email export file or talk export file is empty or is not a file.');
        }

        $this->associateEmailExportColumns($emailExportCsvFile->fgetcsv(self::CSV_DELIMITER));
        $this->associateTalkExportColumns($talkExportCsvFile->fgetcsv(self::CSV_DELIMITER));

        $talkList = [];
        while (!empty($talkLine = array_filter($talkExportCsvFile->fgetcsv(self::CSV_DELIMITER)))) {
            $talkList[] = $this->associateTalkData($talkLine);
        }

        while (!empty($emailLine = array_filter($emailExportCsvFile->fgetcsv(self::CSV_DELIMITER)))) {
            $talkTitle = $this->getEmailExportTalkTitleFromCsvLine($emailLine);
            if ($speaker = $this->setSpeakerWithData($emailLine)) {
                $talk = $this->setTalkWithSpeakerAndData(
                    $talkList,
                    $talkTitle,
                    $speaker);
                if (null !== $talk) {
                    $this->addedTalksList[] = $talk;
                }
                $this->addedSpeakersList[] = $speaker;
            }
        }
    }

    /**
     * @return Speaker[]
     */
    public function getAddedSpeakers(): array
    {
        return $this->addedSpeakersList;
    }

    /**
     * @return Talk[]
     */
    public function getAddedTalks(): array
    {
        return $this->addedTalksList;
    }

    public function saveAddedSpeakers(): void
    {
        foreach ($this->getAddedSpeakers() as $speaker) {
            $this->speakerRepository->save($speaker);
        }
    }

    public function saveAddedTalks(): void
    {
        foreach ($this->getAddedTalks() as $speaker) {
            $this->talkRepository->save($speaker);
        }
    }

    /**
     * This function will set parameters to the column number if found or at false if the column is not found.
     *
     * @param array $columnHeader
     */
    private function associateEmailExportColumns(array $columnHeader): void
    {
        $this->emailExportTalkTitleColumnNumber = array_search(self::TALK_TITLE, $columnHeader, true);
        $this->speakerFirstNameColumnNumber = array_search(self::SPEAKER_FIRST_NAME, $columnHeader, true);
        $this->speakerLastNameColumnNumber = array_search(self::SPEAKER_LAST_NAME, $columnHeader, true);
        $this->speakerEmailColumnNumber = array_search(self::SPEAKER_EMAIL, $columnHeader, true);
    }

    /**
     * This function will set parameters to the column number if found or at false if the column is not found.
     *
     * @param array $columnHeader
     */
    private function associateTalkExportColumns(array $columnHeader): void
    {
        $this->talkTitleColumnNumber = array_search(self::TALK_TITLE, $columnHeader, true);
        $this->talkDescriptionColumnNumber = array_search(self::TALK_DESCRIPTION, $columnHeader, true);
    }

    private function associateTalkData(array $talkCsvLine): array
    {
        return [
            self::TALK_TITLE => $this->getTalkTitleFromCsvLine($talkCsvLine),
            self::TALK_DESCRIPTION => $this->getTalkDescriptionFromCsvLine($talkCsvLine),
        ];
    }

    private function getEmailExportTalkTitleFromCsvLine(array $csvLine): ?string
    {
        if (false !== $this->emailExportTalkTitleColumnNumber) {
            return $csvLine[$this->emailExportTalkTitleColumnNumber];
        }

        return null;
    }

    private function getTalkTitleFromCsvLine(array $csvLine): ?string
    {
        if (false !== $this->talkTitleColumnNumber) {
            return $csvLine[$this->talkTitleColumnNumber];
        }

        return null;
    }

    private function getTalkDescriptionFromCsvLine(array $csvLine): ?string
    {
        if (false !== $this->talkDescriptionColumnNumber) {
            return $csvLine[$this->talkDescriptionColumnNumber];
        }

        return null;
    }

    private function getSpeakerNameFromCsvLine(array $csvLine): ?string
    {
        if (false !== $this->speakerFirstNameColumnNumber) {
            $name[] = $csvLine[$this->speakerFirstNameColumnNumber];
        }

        if (false !== $this->speakerLastNameColumnNumber) {
            $name[] = $csvLine[$this->speakerLastNameColumnNumber];
        }

        if (isset($name)) {
            return implode(' ', $name);
        }

        return null;
    }

    private function getSpeakerEmailFromCsvLine(array $csvLine): ?string
    {
        if (false !== $this->speakerEmailColumnNumber) {
            return $csvLine[$this->speakerEmailColumnNumber];
        }

        return null;
    }

    private function setSpeakerWithData(array $csvLine): ?Speaker
    {
        $speakerName = $this->getSpeakerNameFromCsvLine($csvLine);
        $speakerEmail = $this->getSpeakerEmailFromCsvLine($csvLine);

        if (null !== $speakerName && null !== $speakerEmail) {
            return $this->speakerRepository->createWith(
                $speakerName,
                $speakerEmail,
                self::DEFAULT_SPEAKER_TITLE,
                self::DEFAULT_SPEAKER_BIOGRAPHY,
                self::DEFAULT_SPEAKER_PHOTO_PATH
            );
        }

        return null;
    }

    private function findTalkKeyWithTitle(array $talkList, string $title): ?int
    {
        foreach ($talkList as $key => $talk) {
            if ($talk[self::TALK_TITLE] === $title) {
                return $key;
            }
        }

        return null;
    }

    private function setTalkWithSpeakerAndData(array $talkList, string $talkTitle, Speaker $speaker): ?Talk
    {
        $key = $this->findTalkKeyWithTitle($talkList, $talkTitle);
        if (null !== $key) {
            if (null !== $talkList[$key][self::TALK_DESCRIPTION]) {
                return $this->talkFactory->createWith($talkTitle, $talkList[$key][self::TALK_DESCRIPTION], $speaker);
            }
        }

        return null;
    }
}
