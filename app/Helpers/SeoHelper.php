<?php


namespace App\Helpers;

use App\Models\SeoDescription;

class SeoHelper
{
    static function parseSeoFromBody($body)
    {
        $result = [];
        foreach ($body as $index => $value) {
            if (strpos($index, 'seo') !== false) {
                $result['seo'][$index] = $value;
            } else {
                $result['body'][$index] = $value;
            }
        }
        return $result;
    }

    static function saveSeo($seo)
    {
        $seoObject = SeoDescription::where(['type' => $seo['type'], 'item_id' => $seo['item_id']])->first();
        if(is_null($seoObject)){
            SeoDescription::create($seo);
        } else {
            $seoObject->update($seo);
        }
    }
}
