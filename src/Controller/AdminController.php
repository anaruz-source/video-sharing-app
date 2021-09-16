<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Utils\CategoryTreeAdminPage;
use App\Utils\CategoryTreeOptionList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/categories", name="categories", methods={"POST", "GET"})
     */
    public function categories(CategoryTreeAdminPage $categories, Request $request): Response
    {
        $categories->getCategoryList($categories->buildTree());

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $is_invalid = '';

        if ($this->saveCategory($form, $request, $category)) {
            return $this->redirectToRoute('categories');
        } elseif ($request->isMethod('post')) {
            $is_invalid = 'is-invalid';
        }

        return $this->render('admin/categories.html.twig', ['categories' => $categories->html_string, 'form' => $form->createView(), 'is_invalid' => $is_invalid]);
    }

    /**
     * @Route("/category/edit/{id}", name="edit_category", methods={"GET","POST"})
     */
    public function edit_category(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $is_invalid = '';

        if ($this->saveCategory($form, $request, $category)) {
            return $this->redirectToRoute('categories');
        } elseif ($request->isMethod('post')) {
            $is_invalid = 'is-invalid';
        }

        return $this->render('admin/edit_category.html.twig', [
                                                               'category' => $category,
                                                               'form' => $form->createView(),
                                                               'is_invalid' => $is_invalid,
                                                            ]);
    }

    /**
     * @Route("/category/delete/{id}", name="delete_category")
     */
    public function delete_category(Category $category): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/videos", name="videos")
     */
    public function videos(): Response
    {
        return $this->render('admin/videos.html.twig');
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function upload(): Response
    {
        return $this->render('admin/upload_video.html.twig');
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }

    public function getAllCategories(CategoryTreeOptionList $categories, $category = null)
    {
        $categoryTree = $categories->buildTree();
        $subCategories = $categories->getCategoryList($categoryTree);

        return $this->render('admin/_all_categories.html.twig', ['categories' => $subCategories, 'edited' => $category]);
    }

    private function saveCategory($form, $request, $category)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repo = $this->getDoctrine()->getRepository(Category::class);

            $manager = $this->getDoctrine()->getManager();
            $name = $request->request->get('category')['name'];
            $parent = $repo->find($request->request->get('category')['parent']);
            $category->setName($name);

            $category->setParent($parent);
            \dump($category);
            $manager->persist($category);
            $manager->flush();

            //return $this->redirectToRoute('categories');
            return true;
        }

        return false;
    }
}
