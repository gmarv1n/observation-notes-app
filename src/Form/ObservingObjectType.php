<?php
namespace App\Form;

use App\Entity\ObservingObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ObservingObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object_name', TextType::class,
                [
                    "constraints" => [
                        new NotNull()
                    ]
                ] 
            )
            ->add('object_description', TextType::class,
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
            'data_class' => ObservingObject::class,
        ]);
    }
}