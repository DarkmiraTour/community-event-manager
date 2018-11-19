<?php declare(strict_types=1);

namespace App\Form;

use App\Dto\TalkRequest;
use App\Entity\Speaker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TalkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'description',
                TextareaType::class,
                ['required' => true]
            )
            ->add(
                'speaker',
                EntityType::class,
                [
                    'class' => Speaker::class,
                    'choice_label' => 'name'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TalkRequest::class,
        ]);
    }
}
