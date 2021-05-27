<?php
namespace App\Form;

use App\Entity\Observer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ObserverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,
                [
                    "constraints" => [
                        new NotNull()
                    ]
                ]    
            )
            ->add('password', PasswordType::class,
                [
                    "constraints" => [
                        new NotNull()
                    ]
                ] 
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observer::class,
        ]);
    }
}