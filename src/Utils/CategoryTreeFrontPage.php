<?php

namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract
{
    public function getCategoryList(array $categories): string
    {
        $this->html_string .= '<ul class="mr-5">';

        foreach ($categories as $cat) {
            $url = $this->urlgen->generate('video_list', ['category' => $this->slugger->slugify($cat['name']), 'id' => $cat['id']]);
            $this->html_string .= ' <li><a href="'.$url.'">'.$cat['name'].'</a>';

            if (!empty($cat['children'])) {
                $this->getCategoryList($cat['children']);
            }
            $this->html_string .= '</li>';
        }

        return  $this->html_string .= '</ul>';
    }

    public function getMainParent($id)
    {
        $key = array_search($id, array_column($this->categories, 'id'));

        if ($this->categories[$key]['parent_id'] != null) {
            return $this->getMainParent($this->categories[$key]['parent_id']);
        } else {
            return ['id' => $this->categories[$key]['id'], 'name' => $this->categories[$key]['name']];
        }
    }

    public function getCategoryListAndParent($id): string
    {
        $parentData = $this->getMainParent($id);

        $this->mainParent = $parentData;

        $key = array_search($id, array_column($this->categories, 'id'));
        $this->currentCategory = $this->categories[$key];

        $categories = $this->buildTree($parentData['id']);

        return $this->getCategoryList($categories);
    }
}
