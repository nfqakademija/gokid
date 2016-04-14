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
                'id' => 'autocomplete',
            ],
        ])->add('age', IntegerType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Vaiko amžius',
                'class' => 'age-input'
            ],
        ])->add('male', CheckboxType::class, [
            'label' => false,
            'attr' => [
                'class' => 'gender-checkbox',
            ],
        ])->add('female', CheckboxType::class, [
            'label' => false,
            'attr' => [
                'class' => 'gender-checkbox',
            ],
        ])->add('latitude', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'hidden',
            ],
        ])->add('longitude', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'hidden',
            ],
        ])->add('distance', TextType::class, [
            'label' => false,
            'data' => '10',
            'attr' => [
                'class' => 'hidden distance-field',
            ],
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\OfferSearch'
        ]);
    }
}
