<?php

namespace App\Form;

use App\Entity\AbsenceType;
use App\Entity\PlanningEntry;
use App\Entity\Shift;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_absent')
            ->add('comment')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('shift', EntityType::class, [
                'class' => Shift::class,
                'choice_label' => 'id',
            ])
            ->add('absenceType', EntityType::class, [
                'class' => AbsenceType::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanningEntry::class,
        ]);
    }
}
