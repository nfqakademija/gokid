<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class IndexSearchOffer extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Gyvenamoji vieta',
                'class' => 'place-input',
            ],
        ])->add('ageFrom', IntegerType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Vaiko amžius',
                'class' => 'age-input'
            ],
        ])->add('male', CheckboxType::class, [
            'label' => false,
            'attr' => [
                'class' => 'gender-checkbox',
            ]
        ])->add('female', CheckboxType::class, [
            'label' => false,
            'attr' => [
                'class' => 'gender-checkbox',
            ]
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Offer'
        ]);
    }
}
