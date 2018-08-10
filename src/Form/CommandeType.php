<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 10/08/2018
 * Time: 23:31
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Votre Email']
            ])
            ->add('date_visit', DateType::class, [
                'label' => 'Date de visite :',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd/M/y',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('nb_tickets', IntegerType::class)
            ->add('createdAt', DateType::class, [
                'attr' => [
                    'label' => 'date de commande']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Commande',
        ));
    }
}
