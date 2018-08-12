<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CitationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pensee', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pensée'
                ],
                'required' => true
            ])
            ->add('auteur', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "L'auteur de la pensée"
                ],
                'required' => false
            ])
            ->add('ouvrage', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "L'oeuvre dans laquelle la pensée a été extraite"
                ],
                'required' => false
            ])
            ->add('statut', CheckboxType::class)
            //->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Citation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_citation';
    }


}
