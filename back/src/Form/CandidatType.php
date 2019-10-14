<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')
            ->add('civilite', ChoiceType::class, [
                'choices' => $this->getCiviliteChoices()
            ])
            ->add('cp')
            ->add('adresse_1')
            ->add('adresse_2')
            ->add('ville')
            ->add('poste_vise')
            ->add('date_naissance')
            ->add('titre')
            ->add('mobilite')
            ->add('mobilite_zone')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getCiviliteChoices() {
        $choices = [];
        foreach(Candidat::CIVILITE as $key=>$value) {
            $choices[$value] = $key;
        }
        return $choices;
    }
}
