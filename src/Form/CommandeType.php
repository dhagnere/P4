<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 10/08/2018
 * Time: 23:31
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                    'label'=>'Veuillez renseigner l\'email où nous vous enverrons votre (vos) billet(s) :'
            ])
            ->add('date_visit', DateType::class, [
                'label' => 'Date de visite souhaitée (jours de fermetures Mardi, Samedi et Dimanches) :',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd/M/y',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('nb_tickets', IntegerType::class , [
                'label'=>'Nombre de tickets désiré :'
            ])
            ->add('halfday', ChoiceType::class, array(
                'label'=>'Durée de la visite (Journée - 16 Euro , Demi journée : 8 Euro) :',
                'choices' =>array(
                    'Journée complète'=>false,
                    'Demi-journée'=>true,
                )))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Commande',
        ));
    }
}
