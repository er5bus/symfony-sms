<?php

namespace SMS\SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use SMS\SchoolBundle\Entity\PricingFeature;
use SMS\SchoolBundle\Entity\Pricing;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use SMS\SchoolBundle\Entity\Translations\PricingFeatureTranslation;

class PricingFeatureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('pricing' , EntityType::class , array(
                  'class' => Pricing::class,
                  'property' => 'pricingName',
                  'label' => 'pricingfeature.field.pricing',
                  'placeholder' => 'pricingfeature.field.pricing')
              )
              ->add('state' ,CheckboxType::class , array(
                  'label' => 'pricingfeature.field.state')
              )

              ->add('text', 'sms_translatable_field', array(
                  'field'          => 'text',
                  'label' => 'feature.field.text',
                  'property_path'  => 'translations',
                  'widget'         => TextareaType::class,
                  'personal_translation' => PricingFeatureTranslation::class,
              ))
              ->add('save', SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PricingFeature::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sms_schoolbundle_pricingfeature';
    }


}
