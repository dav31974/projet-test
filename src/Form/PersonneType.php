<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('birthAt', DateType::class, [
                'label' => 'Date de naissance',
                'years' => range(1930, date('Y') + 0) // Lists 50 Years Before and After
            ])
            ->add('taille', IntegerType::class, [
                'label' => 'Taille (en cm)'
            ])
            ->add('nbrefreresoeur', IntegerType::class, [
                'label' => 'Nombre de frères et soeurs'
            ])
            ->add('codepostal')
            ->add('infos', TextType::class, [
                'label' => 'Informations supplémentaires (optionnel)',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
