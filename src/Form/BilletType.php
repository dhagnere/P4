<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 10/08/2018
 * Time: 23:31
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class BilletType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                    'label'=>'Votre Nom :'
            ])
            ->add('surname', TextType::class, [
                'label'=>'Votre Prénom :'
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Votre date de naissance :',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd/M/y',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('country', CountryType::class , [
                'label'=>'Votre pays de résidence :'
            ])
            ->add('discount', CheckboxType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Billet',
        ));
    }
}
