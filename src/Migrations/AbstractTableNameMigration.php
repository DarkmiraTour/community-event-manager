<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\Migrations\AbstractMigration;

abstract class AbstractTableNameMigration extends AbstractMigration
{
    protected const SPONSORSHIP_BENEFIT = 'sponsorship_benefit';
    protected const SPONSORSHIP_LEVEL = 'sponsorship_level';
    protected const SPONSORSHIP_LEVEL_BENEFIT = 'sponsorship_level_benefit';
    protected const SPECIAL_BENEFIT = 'special_benefit';
    protected const SPEAKER = 'speaker';
    protected const TALK = 'talk';
    protected const ORGANIZATION = 'organisation';
    protected const PAGE = 'page';
    protected const USER = 'app_user';
    protected const SLOT_TYPE = 'slot_type';
    protected const SPACE_TYPE = 'space_type';
    protected const SCHEDULE = 'schedule';
    protected const SPACE = 'space';
    protected const SLOT = 'slot';
    protected const INTERVIEW_QUESTION = 'interview_question';
    protected const EVENT = 'events';
    protected const EVENTS_SPEAKERS = 'speaker_event';
    protected const EVENTS_ORGANIZATIONS = 'organisation_event';
}
