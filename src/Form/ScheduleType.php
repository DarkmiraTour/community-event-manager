<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\ScheduleRequest;
use App\Service\Event\EventServiceInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ScheduleType extends AbstractType
{
    private $eventService;

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', ChoiceType::class, [
                'required' => true,
                'choices' => $this->getValidDaysForSelectecEvent(),
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduleRequest::class,
        ]);
    }

    private function getValidDaysForSelectecEvent(): array
    {
        $event = $this->eventService->getSelectedEvent();
        $period = new \DatePeriod(
            $event->getStartAt(),
            new \DateInterval('P1D'),
            $event->getEndAt()
        );
        $availableDays = [];
        foreach ($period as $oneDay) {
            $availableDays[$oneDay->format('Y-m-d')] = $oneDay;
        }
        $availableDays[$event->getEndAt()->format('Y-m-d')] = $event->getEndAt();

        return $availableDays;
    }
}
