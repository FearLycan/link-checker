<?php

namespace app\models\forms;

use app\models\Links;


class OneForm extends Links
{
    public function rules()
    {
        return [
            [['links'], 'required'],
            [['links'], 'string'],
        ];
    }

    public function extractLinks()
    {
        $links = explode(PHP_EOL, $this->links);

        return $links;
    }

}