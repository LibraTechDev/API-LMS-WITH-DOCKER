<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\CourseMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->paginate(10);
        return response()->json([
            'code' => 200,
            'message' => 'Daftar Course Berhasil Diambil',
            'data' => $courses,
        ]);
    }

    public function myCourses(Request $request)
    {
        $courses_member = CourseMember::with(['course', 'user'])
            ->where('user_id', $request->user()->id)
            ->get();

        if (!$courses_member) {
            return response()->json(['message' => 'Course not found'], 404);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Course Berhasil Diambil',
                'data' => $courses_member
            ]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'url' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|image',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $course = new Course($validated);
        $course->teacher_id = $request->user()->id;

        if ($request->hasFile('image')) {
            $course->image = $request->file('image')->store('courses');
        }

        $course->save();

        return response()->json([
            'code' => 201,
            'message' => 'Course Berhasil Dibuat',
            'data' => $course,
        ], 201);
    }

    public function update(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);

        if ($course->teacher_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $course->fill($validated);

        if ($request->hasFile('image')) {
            $course->image = $request->file('image')->store('courses');
        }

        $course->save();

        return response()->json([
            'code' => 201,
            'message' => 'Laporan Berhasil Diupdate',
            'data' => $course,
        ], 201);
    }

    public function show($course_id)
    {
        $course = Course::with('teacher')->findOrFail($course_id);
        return response()->json([
            'code' => 201,
            'message' => 'Course Berhasil Diambil',
            'data' => $course,
        ], 200);
    }

    public function enroll(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);

        $existingEnrollment = CourseMember::where('course_id', $course_id)
        ->where('user_id', Auth::id())
        ->first();

     if ($existingEnrollment) {
         return response()->json([
             'code' => 400,
             'message' => 'You are already enrolled in this course.',
         ], 400);
     }
        if ($course->isFull()) {
            return response()->json([
                'code' => 400,
                'message' => 'The course is already full.',
            ], 400);
        }

        $courseMember = new CourseMember([
            'course_id' => $course->id,
            'user_id' => $request->user()->id,
            'roles' => 'std',
        ]);
        $courseMember->save();

        return response()->json([
            'code' => 201,
            'message' => 'Berhasil Mendaftar Course',
            'data' => $course,
        ], 201);
    }

    public function getAnalytics($courseId)
    {
        $course = Course::findOrFail($courseId);

        $memberCount = $course->members()->count();
        $contentCount = $course->contents()->count();
        $commentCount = $course->comments()->count();
        $feedbackCount = $course->feedbacks()->count();

        return response()->json([
            'code' => 200,
            'message' => 'Course analytics retrieved successfully.',
            'data' => [
                'member_count' => $memberCount,
                'content_count' => $contentCount,
                'comment_count' => $commentCount,
                'feedback_count' => $feedbackCount,
            ],
        ]);
    }
}