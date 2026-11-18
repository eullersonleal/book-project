<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class LivroType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
                'empty_data' => '',
                'attr' => ['maxlength' => 40],
            ])
            ->add('editora', TextType::class, [
                'label' => 'Editora',
                'empty_data' => '',
                'attr' => ['maxlength' => 40],
            ])
            ->add('edicao', IntegerType::class, [
                'label' => 'Edição',
                'empty_data' => '0',
                'invalid_message' => 'Informe uma edição inteira.',
                'attr' => [
                    'min' => 1,
                    'max' => 2147483647,
                ],
            ])
            ->add('anoPublicacao', TextType::class, [
                'label' => 'Ano de publicação',
                'empty_data' => '',
                'attr' => [
                    'maxlength' => 4,
                    'inputmode' => 'numeric',
                ],
            ])
            ->add('valor', MoneyType::class, [
                'label' => 'Valor',
                'currency' => 'BRL',
                'input' => 'string',
                'scale' => 2,
                'grouping' => true,
                'invalid_message' => 'Informe um valor válido.',
            ])
            ->add('autores', EntityType::class, [
                'label' => 'Autores',
                'class' => Autor::class,
                'choice_label' => 'nome',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'required' => false,
            ])
            ->add('assuntos', EntityType::class, [
                'label' => 'Assuntos',
                'class' => Assunto::class,
                'choice_label' => 'descricao',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livro::class,
        ]);
    }
}