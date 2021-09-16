<?php

namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeOptionList extends CategoryTreeAbstract
{
    public $categoryList = [];

    public function getCategoryList(array $categories, int $repeat = 0): array
    {
        foreach ($categories as $cat) {
            $this->categoryList[] = ['name' => str_repeat('-', $repeat).$cat['name'], 'id' => $cat['id']];

            if (!empty($cat['children'])) {
                $repeat = $repeat + 2;

                $this->getCategoryList($cat['children'], $repeat);

                $repeat = $repeat - 2;
            }
        }

        return $this->categoryList;
    }
}
