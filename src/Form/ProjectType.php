<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'prospect' => "prospect",
                    'devis envoyé' => "devis envoyé",
                    'devis accepté' => "devis accepté",
                    'démarré' => "démarré",
                    'terminé' => "terminé",
                    'annulé' => "annulé",
                ],
            ])
            ->add('price')
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
