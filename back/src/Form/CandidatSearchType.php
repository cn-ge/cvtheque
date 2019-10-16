<?php

namespace App\Form;

use App\Entity\CandidatSearch;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  

        $builder
            ->add('cp', TextType::class, [
                    'required'=>false,
                    'label'=>false,
                    'attr'=> [
                        'placeholder'=>'département 44'
                    ]
            ])
            ->add('nom', TextType::class, [
                    'required'=>false,
                    'label'=>false,
                    'attr'=> [
                        'placeholder'=>'nom recherché'
                    ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CandidatSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix() {
        return '';
    }
}
