<?php

namespace App\Utils\AbstractClasses;

use App\Twig\AppExtension;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract
{
    public $html_string = '';
    public $categories;
    protected static $dbcategories;

    public function __construct(EntityManagerInterface $manager, UrlGeneratorInterface $urlgen)
    {
        $this->manager = $manager;
        $this->urlgen = $urlgen;
        $this->categories = $this->getCategories();
        $this->slugger = new AppExtension();
    }

    abstract public function getCategoryList(array $categories);

    public function buildTree(int $parent_id = null): array
    {
        $subCategory = [];

        foreach ($this->categories as $category) {
            if ($category['parent_id'] == $parent_id) {
                $children = $this->buildTree($category['id']);

                if ($children) {
                    $category['children'] = $children;
                }
                $subCategory[] = $category;
            }
        }

        return $subCategory;
    }

    public function getCategories(): array
    {
        if (self::$dbcategories) {
            return self::$dbcategories;
        } else {
            $conn = $this->manager->getConnection();
            $sql = 'SELECT * FROM categories';
            $st = $conn->prepare($sql);
            $st->execute();
            $categories = $st->fetchAll();

            return self::$dbcategories = $categories;
        }
    }
}
