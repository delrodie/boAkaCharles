<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le titre de la publication'
                ],
                'required' => true
            ])
            //->add('resume')
            ->add('contenu', TextareaType::class, array(
                'attr' => array(
                    'class' => 'contenu',
                    'placeholder'   => 'Redigez la biographie',
                    'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                )
            ))
            ->add('tags', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'data-role' => 'tagsinput',
                    'placeholder' => 'Entrez les mots clés'
                )
            ))
            ->add('statut', CheckboxType::class, array(
                'required' => false
            ))
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('rubrique', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
