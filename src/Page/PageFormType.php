<?php

declare(strict_types=1);

namespace App\Page;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PageFormType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('background', FileType::class)
            ->add('content', TextareaType::class)
            ->setDataMapper($this)
        ;
    }

    public function mapDataToForms($data, $forms): void
    {
        if (null !== $data) {
            $forms = iterator_to_array($forms);
            $forms['title']->setData($data->title ?? null);
            $forms['content']->setData($data->content ?? null);
            $forms['background']->setData($data->background ?? null);
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $forms = iterator_to_array($forms);
        if (null !== $data) {
            $data->title = $forms['title']->getData();
            $data->content = $forms['content']->getData();
            $data->background = $forms['background']->getData();

            return;
        }

        $data = new PageRequest();
        $data->title = $forms['title']->getData();
        $data->content = $forms['content']->getData();
        $data->background = $forms['background']->getData();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageRequest::class,
            'empty_data' => null,
        ]);
    }
}
