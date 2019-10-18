<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('civilite', ChoiceType::class, [
                'choices' => $this->getCiviliteChoices()
            ])
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('cp')
            ->add('adresse_1')
            ->add('adresse_2')
            ->add('ville')
            ->add('poste_recherche')
            ->add('date_naissance', DateTimeType::class, [
                'attr' => [
                    'placeholder' => '20/01/2000'
                ],
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'input'  => 'datetime'
            ])
            ->add('statut')
            ->add('mobilite')
            ->add('mobilite_zone')
            ->add('notes')
            ->add('nom')
            ->add('prenom')
       ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getCiviliteChoices() {
        $choices = [];
        foreach(User::CIVILITE as $key=>$value) {
            $choices[$value] = $key;
        }
        return $choices;
    }
}
