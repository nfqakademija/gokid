<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 4/13/16
 * Time: 1:45 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body', TextType::class, [
            'label' => false,
        ])->add('name', TextType::class, [
                'label' => false,
            ])->add('rate', IntegerType::class,[
                'label' => false,
            ])/*->add('rate1', CheckboxType::class, [
            'label' => false,
            'required'  => false,
        ])->add('rate2', CheckboxType::class, [
                'label' => false,
                'required'  => false,
            ])->add('rate3', CheckboxType::class, [
                'label' => false,
                'required'  => false,
            ])->add('rate4', CheckboxType::class, [
                'label' => false,
                'required'  => false,
            ])->add('rate5', CheckboxType::class, [
                'label' => false,
                'required'  => false,
            ])*/->add('title', TextType::class, [
            'label' => false,
        ])->add('email', EmailType::class, [
            'label' => false,
            ])->add('submit', 'submit', array('label'=>'Įvertinti'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Comment'

        ]);
    }
}
