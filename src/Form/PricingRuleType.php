<?php

namespace App\Form;

use App\Entity\PricingRule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Enum\PlEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PricingRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('amount')
            ->add('type')
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'choices' => PlEnum::getAvailableTypes(),
                'choice_label' => function($choice) {
                    return PlEnum::getTypeName($choice);
                },
            ))
//            ->add('created_at')
//            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PricingRule::class,
        ]);
    }
}
