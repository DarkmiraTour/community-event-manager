<?php

declare(strict_types=1);

namespace App\Speaker\UploadFromOpenCfp;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UploadSpeakerFromCsvFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'emailExportCsvFile',
                FileType::class,
                [
                    'label' => 'email Export from OpenCFP',
                    'required' => true,
                ]
            )
            ->add(
                'talkExportCsvFile',
                FileType::class,
                [
                    'label' => 'talk Export from OpenCFP',
                    'required' => true,
                ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpeakerTalkCsvUploadRequest::class,
        ]);
    }
}
