<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\ScheduleRequest;
use App\Service\Event\EventServiceInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
            ->add('day', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Callback([
                        'callback' => [$this, 'checkIsEventDateExist'],
                    ]),
                    ],
                ]);
    }

    public function checkIsEventDateExist($data, ExecutionContextInterface $context): void
    {
        if (!$this->eventService->checkIsEventDateExist($data)) {
            $context->buildViolation('this date is not part of the event')
                ->atPath('day')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduleRequest::class,
        ]);
    }
}
