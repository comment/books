<?php
namespace App\v1\Traits;

trait BuildTree
{
    public function buildTree(array $elements, $parent_id = 0): array
    {
        $branch = array();

        foreach ($elements as $element) {
            if($element['parent_id'] == $parent_id) {
                $parent = $this->buildTree($elements, $element['id']);
                if($parent) {
                    $element['parent'] = $parent;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
