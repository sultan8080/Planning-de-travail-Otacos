<?php

namespace App\Form;

use App\Entity\Planning;
use App\Entity\Shift;
use App\Entity\ShiftType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('day')
            ->add('start_time', null, [
                'widget' => 'single_text',
            ])
            ->add('end_time', null, [
                'widget' => 'single_text',
            ])
            ->add('shiftType', EntityType::class, [
                'class' => self::class,
                'choice_label' => 'id',
            ])
            ->add('planning', EntityType::class, [
                'class' => Planning::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,
        ]);
    }
}
