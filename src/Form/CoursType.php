<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Devise;
use App\Entity\Marche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coursBH_achat')
            ->add('coursBH_vente')
            ->add('coursBCT_achat')
            ->add('coursBCT_vente')
            ->add('date',DateTimeType::class,[
                'input' => 'datetime',
        ])
            ->add('devise', EntityType::class, [
                'class' => Devise::class,
                'choice_label' => 'lib_devise',])
               // ->add('marche', EntityType::class, [
                //    'class' => Marche::class,
                 //   'choice_label' => 'type',])
            
                ->add('submit', SubmitType::class)
                ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
