<?php

namespace App\Form;

use App\Entity\Applications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => 'Entreprise *',
                'attr' => [
                    'placeholder' => 'Nom Entreprise *',
                ],
            ])
            ->add('localisation_entreprise', TextType::class, [
                'label' => 'Localisation *',
                'attr' => [
                    'placeholder' => 'Localisation *',
                ],
            ])
            ->add('poste_recherche', TextType::class, [
                'label' => 'Poste recherché *',
                'attr' => [
                    'placeholder' => 'Poste recherché *',
                ],
            ])
            ->add('nature_candidature', ChoiceType::class, [
                'label' => 'Nature Candidature *',
                'placeholder' => "-",
                'choices' => [
                    'Spontanée' => 'Spontanée',
                    'Réponse à une offre' => "Réponse à une offre"
                ],
            ])
            ->add('date_candidature', DateType::class, [
                'label' => 'Date Candidature *',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date Candidature *',
                ],
            ])
            ->add('lien_candidature', UrlType::class, [
                'label' => "Lien de l'annonce *",
                'attr' => [
                    'placeholder' => "Lien de l'annonce *",
                ],
            ])
            ->add('email_contact', EmailType::class, [
                'label' => 'Email du contact',
                'required' => false,
            ])
            ->add('technos', TextType::class, [
                'label' => 'Technos *',
                'attr' => [
                    'placeholder' => 'Technos *',
                ],
            ])
            ->add('remarques', TextType::class, [
                'label' => 'Remarques',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applications::class,
            'csrf_protection' => false,
        ]);
    }
}