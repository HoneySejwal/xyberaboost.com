<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable=['page_title', 'page_title_ja', 'page_slug', 'page_desc', 'page_desc_ja', 'page_meta', 'page_keywords'];

    public static function getPageBySlug($slug) {

        $currentLocale = App::getLocale();

        if($currentLocale == "ja") {
            return Pages::select('page_title_ja as page_title', 'page_desc_ja as page_desc', 'page_slug', 'page_meta', 'page_keywords')->where('page_slug', $slug)->first();
        }
        else {
            return Pages::where('page_slug', $slug)->first();
        }
    }

}
