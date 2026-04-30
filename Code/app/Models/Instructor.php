<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable=['id', 'instructor_name', 'instructor_name_ja', 'instructor_slug', 'instructor_pic', 'instructor_designation', 'instructor_designation_ja', 'instructor_desc', 'instructor_desc_ja', 'status'];

    public static function getInstructorBySlug($slug) {

        $currentLocale = App::getLocale();

        if($currentLocale == "ja") {
            return Instructor::select('id', 'instructor_name_ja as instructor_name', 'instructor_slug', 'instructor_pic', 'instructor_designation_ja as instructor_designation', 'instructor_desc_ja as instructor_desc')->where('instructor_slug', $slug)->first();
        }
        else {
            return Instructor::select('id', 'instructor_name', 'instructor_slug', 'instructor_pic', 'instructor_designation', 'instructor_desc')->where('instructor_slug', $slug)->first();
        }
    }

    public static function getAllInstructor() {
        $currentLocale = App::getLocale();

        if($currentLocale == "ja") {
            return Instructor::select('id', 'instructor_name_ja as instructor_name', 'instructor_slug', 'instructor_pic', 'instructor_designation_ja as instructor_designation', 'instructor_desc_ja as instructor_desc')->where('status', "A")->get();
        }
        else {
            return Instructor::select('id', 'instructor_name', 'instructor_slug', 'instructor_pic', 'instructor_designation', 'instructor_desc')->where('status', "A")->get();
        }
    }

}
