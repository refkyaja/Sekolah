<?php

namespace App\Helpers;

class TextHelper
{
    /**
     * Highlight text in search results
     */
    public static function highlight($text, $search)
    {
        if (empty($text) || empty($search)) {
            return e($text);
        }
        
        $search = preg_quote(e($search), '/');
        return preg_replace(
            "/($search)/i", 
            '<span class="bg-yellow-200 px-1 py-0.5 rounded text-yellow-900 font-medium">$1</span>', 
            e($text)
        );
    }
}