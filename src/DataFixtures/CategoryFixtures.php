<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadMainCategories($manager);
        $this->loadSubcategories($manager, 'Electronics', 1);
        $this->loadSubcategories($manager, 'Computers', 6);
        $this->loadSubcategories($manager, 'Laptops', 9);
        $this->loadSubcategories($manager, 'Books', 2);
        $this->loadSubcategories($manager, 'Movies', 4);
        $this->loadSubcategories($manager, 'Romance', 19);
    }

    private function getMainCategoriesData()
    {
        return  [
            ['Electronics', 1],
            ['Books', 2],
            ['Toys', 3],
            ['Movies', 4],
        ];
    }

    private function getElectronicsData()
    {
        return  [
            ['Cameras', 5],
            ['Computers', 6],
            ['Cell phones', 7],
            ['Power bank', 8],
        ];
    }

    private function getComputersData()
    {
        return  [
            ['Laptops', 9],
            ['Desktops', 10],
        ];
    }

    private function getLaptopsData()
    {
        return [
            ['Apple', 11],
            ['Asus', 12],
            ['Dell', 13],
            ['Lenovo', 14],
            ['HP', 15],
        ];
    }

    private function getBooksData()
    {
        return [
            ['Children\'s Books', 16],
            ['Kindle eBooks', 17],
        ];
    }

    private function getMoviesData()
    {
        return [
            ['Family', 18],
            ['Romance', 19],
        ];
    }

    private function getRomanceData()
    {
        return [
            ['Romantic Comedy', 20],
            ['Romantic Drama', 21],
        ];
    }

    private function loadMainCategories($manager)
    {
        foreach ($this->getMainCategoriesData() as[$name]) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $manager->flush();
    }

    private function loadSubcategories($manager, $category, $parent_id)
    {
        $parent = $manager->getRepository(Category::class)->find($parent_id);
        $methodName = "get{$category}Data";
        foreach ($this->$methodName() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
