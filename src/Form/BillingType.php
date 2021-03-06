<?php

namespace App\Form;

use App\Entity\Billing;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BillingType extends AbstractType
{

    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('billing_number', )
            ->add('entitled')
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'query_builder' => function (ProjectRepository $repo){
                    return $repo->getUserProject($this->security->getUser());
                },
                'choice_label' => 'name',
            ])
            ->add('biling_status', ChoiceType::class, [
                'choices' => [
                    'edited' => 'edited',
                    'sent' => 'sent',
                    'payed' => 'payed'
                ]
            ])
            ->add('creation_date', DateType::class)
            ->add('payment_deadline', DateType::class)
            ->add('payment_method', ChoiceType::class, [
                'choices' => [
                    'check' => 'check',
                    'bank transfer' => 'bank transfer',
                    'paypal' => 'paypal',
                    'other' => 'other'
                ]
            ])
            ->add('time_of_payment', DateType::class)
            ->add('details')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
        ]);
    }
}
