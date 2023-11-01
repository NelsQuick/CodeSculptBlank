<?php

// Déclaration de l'espace de noms (namespace) du formulaire
namespace App\Form;

// Import des classes nécessaires de Symfony
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Post;

// Définition de la classe PostType, qui étend AbstractType
class PostType extends AbstractType
{
    // Méthode pour construire le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout d'un champ 'content' au formulaire de type TextareaType
        $builder
            ->add('content', TextareaType::class, [
                'label' => false,  // Masque l'étiquette du champ
                'attr' => [  // Attributs HTML pour personnaliser l'apparence du champ
                    'class' => 'content-input',  // Classe CSS pour le champ
                    'placeholder' => 'Quoi de neuf ?',  // Placeholder (aide visuelle pour l'utilisateur)
                ]
            ]);
    }

    // Méthode pour configurer les options du formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        // Définit les options par défaut, notamment la classe associée au formulaire (Post::class)
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
