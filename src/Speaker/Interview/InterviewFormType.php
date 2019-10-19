<?php

declare(strict_types=1);

namespace App\Speaker\Interview;

use App\Entity\InterviewQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InterviewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = $this->addQuestionType(1, $builder);
        $builder = $this->addQuestionType(2, $builder);
        $builder = $this->addQuestionType(3, $builder);
        $builder = $this->addQuestionType(4, $builder);
        $this->addQuestionType(5, $builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InterviewRequest::class,
        ]);
    }

    private function addQuestionType(int $questionNumber, FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder
            ->add(
                "preFilledQuestion{$questionNumber}", EntityType::class, [
                    'class' => InterviewQuestion::class,
                    'required' => false,
                    'label' => "Question {$questionNumber} (from list)",
                    'choice_label' => 'question',
                ]
            )
            ->add(
                "customQuestion{$questionNumber}", TextType::class, [
                    'required' => false,
                    'label' => "Question {$questionNumber} (custom)",
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'If filled, the question list is ignored',
                    ],
                ]
            );
    }
}
