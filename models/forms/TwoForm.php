<?php

namespace app\models\forms;

use app\models\Links;


class TwoForm extends Links
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
        $lines = explode(PHP_EOL, $this->links);
        $items = [];
        foreach ($lines as $line) {
            $n = explode("\t", $line);

            $items[] = [
                'url' => $n[0],
                'key' => $n[1],
                'link' => $n[2],
            ];
        }

        return $items;
    }

}