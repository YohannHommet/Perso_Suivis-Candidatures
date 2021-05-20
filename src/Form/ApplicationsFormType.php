<?php

namespace App\Form;

use App\Entity\Applications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_entreprise', TextType::class, [
                'label' => 'Entreprise'
            ])
            ->add('localisation_entreprise', TextType::class, [
                'label' => 'Localisation'
            ])
            ->add('poste_recherche', TextType::class, [
                'label' => 'Poste recherché'
            ])
            ->add('nature_candidature', TextType::class, [
                'label' => 'Nature Candidature'
            ])
            ->add('date_candidature', DateTimeType::class, [
                'label' => 'Date Candidature',
                'widget' => 'single_text',
            ])
            ->add('lien_candidature', UrlType::class, [
                'label' => "Lien de l'annonce"
            ])
            ->add('email_contact', EmailType::class, [
                'label' => 'email du contact',
                'required' => false
            ])
            ->add('technos', TextType::class, [
                'label' => 'technos'
            ])
            ->add('remarques', TextType::class, [
                'label' => 'remarques',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applications::class,
        ]);
    }
}