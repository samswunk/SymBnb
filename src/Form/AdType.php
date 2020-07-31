<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre',"Entrez un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration('Adresse web',"Adresse web (automatique)", false))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Image',"Entrez l'adresse d'une image"))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction',"Entrez une déscription globale"))
            ->add('content', TextareaType::class, $this->getConfiguration('Contenu',"indiquez le contenu souhaité"))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Nbre de chambres',"Nombre de chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit',"indiquez le prix souhaité"))
            ->add('images', CollectionType::class,
                    [
                        'entry_type'    => ImageType::class,
                        'entry_options' => ['label' => false],
                        'allow_add' => true,
                    ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
