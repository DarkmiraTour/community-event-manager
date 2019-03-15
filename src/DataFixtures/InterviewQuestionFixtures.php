<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\Schedule\InterviewQuestion\InterviewQuestionManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class InterviewQuestionFixtures extends Fixture
{
    public const INTERVIEW_QUESTION_NBR = 10;

    private $interviewQuestionManager;

    public function __construct(InterviewQuestionManagerInterface $interviewQuestionManager)
    {
        $this->interviewQuestionManager = $interviewQuestionManager;
    }

    public function load(ObjectManager $manager): void
    {
        $questions = $this->getExampleQuestions();

        for ($interviewQuestionNbr = 0; $interviewQuestionNbr < self::INTERVIEW_QUESTION_NBR; $interviewQuestionNbr++) {
            $interviewQuestion = $this->interviewQuestionManager->createWith(
                $questions[$interviewQuestionNbr]
            );
            $manager->persist($interviewQuestion);
        }
        $manager->flush();
    }

    private function getExampleQuestions(): array
    {
        return [
            'This is your first talk, what makes you decide to take the leap?',
            'Tell us about yourself. What do you like to do in your spare time, outside of work?',
            'Have you worked on multiple projects and events at once? How do you deal with it?',
            'What criteria do you use for prioritising tasks?',
            'What’s your proudest career achievement to date?',
            'What is your least favourite event genre to work on and why?',
            'How have you dealt with difficult clients or attendees in the past?',
            'What strategies do you use for dealing with event stress?',
            'What sets you apart from other event planners? (i.e. why should we choose you?)',
            'What criteria do you feel is most important when selecting a venue or event location?',
        ];
    }
}
