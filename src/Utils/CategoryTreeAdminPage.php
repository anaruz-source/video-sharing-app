<?php

namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeAdminPage extends CategoryTreeAbstract
{
    public function getCategoryList(array $categories): string
    {
        $this->html_string .= '<ul class="fa-ul text-left">';

        foreach ($categories as $cat) {
            $url_edit = $this->urlgen->generate('edit_category', ['category' => $this->slugger->slugify($cat['name']), 'id' => $cat['id']]);
            $url_delete = $this->urlgen->generate('delete_category', ['category' => $this->slugger->slugify($cat['name']), 'id' => $cat['id']]);
            $this->html_string .= ' <li><i class="fa-li fa fa-arrow-right"></i> '.$cat['name'].' &lt;<a onclick="return confirm(\'Are you sure?\');" href="'.$url_edit.'">edit</a>|<a onclick="return confirm(\'Are you sure?\');" href="'.$url_delete.'">delete</a>&gt;';

            if (!empty($cat['children'])) {
                $this->getCategoryList($cat['children']);
            }
            $this->html_string .= '</li>';
        }

        return  $this->html_string .= '</ul>';
    }
}
