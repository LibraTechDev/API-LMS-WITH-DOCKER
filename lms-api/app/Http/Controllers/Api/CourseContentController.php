<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Http\Controllers\Controller;

class CourseContentController extends Controller
{
    public function index($course_id)
    {
        $courses = CourseContent::where('course_id', $course_id)->get();

        return response()->json([
            'code' => 200,
            'message' => 'Daftar Course Content Berhasil Diambil',
            'data' => $courses,
        ], 200);
    }

    public function show($course_id, $content_id)
    {
        $content = CourseContent::where('course_id', $course_id)->findOrFail($content_id);

        return response()->json([
            'code' => 200,
            'message' => 'Detail Course Content Berhasil Diambil',
            'data' => $content,
        ], 200);
    }

}