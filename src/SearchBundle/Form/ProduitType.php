<?php

namespace SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $depots = $options['depots'];

        foreach ($depots as $depot){
            $choices[$depot->getType()] = $depot;
        }

        $builder
            ->add('name', TextType::class)
            ->add('photo', TextType::class)
            ->add('depot', ChoiceType::class, array( 'choices' => $choices));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SearchBundle\Entity\Produit',
            'depots'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'searchbundle_produit';
    }

}
