<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{slug}', name: 'app_category')]
    public function category(string $slug, EntityManagerInterface $em): Response
    {
        $category = $em->getRepository(Category::class)->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        // Fetch brands that have models in this category
        // In basic SQL/PHP we did a JOIN. Here we can do DQL or fetch all brands and filter (inefficient) 
        // OR better: repository method. For now, let's just fetch all brands or use what's available.
        // The implementation in category.php fetched "Brands associated with this category".
        // Since we don't have ManyToMany Category-Brand, we have to go through Models.
        
        $brands = $em->createQuery(
            'SELECT DISTINCT b 
             FROM App\Entity\Brand b
             JOIN b.models m
             WHERE m.category = :category'
        )
        ->setParameter('category', $category)
        ->getResult();

        // Fetch models for this category
        $models = $em->getRepository(Model::class)->findBy(['category' => $category]);

        return $this->render('category.html.twig', [
            'category' => $category,
            'models' => $models,
            'brands' => $brands,
        ]);
    }

    #[Route('/{category_slug}/brand/{brand_slug}', name: 'app_brand')]
    public function brand(string $category_slug, string $brand_slug, EntityManagerInterface $em): Response
    {
        $category = $em->getRepository(Category::class)->findOneBy(['slug' => $category_slug]);
        $brand = $em->getRepository(Brand::class)->findOneBy(['slug' => $brand_slug]);

        if (!$category || !$brand) {
            throw $this->createNotFoundException('Category or Brand not found');
        }

        $models = $em->getRepository(Model::class)->findBy([
            'category' => $category,
            'brand' => $brand,
        ]);

        return $this->render('brand.html.twig', [
            'category' => $category,
            'brand' => $brand,
            'models' => $models,
        ]);
    }

    #[Route('/{category_slug}/model/{model_slug}', name: 'app_model')]
    public function model(string $category_slug, string $model_slug, EntityManagerInterface $em): Response
    {
        // We could just look up by model slug, but validating category is nice
        $model = $em->getRepository(Model::class)->findOneBy(['slug' => $model_slug]);

        if (!$model) {
            throw $this->createNotFoundException('Product not found');
        }

        if ($model->getCategory()->getSlug() !== $category_slug) {
             // Optional: redirect to correct URL or 404
             // For now, accept it or 404
        }

        return $this->render('model.html.twig', [
            'model' => $model,
        ]);
    }
}
