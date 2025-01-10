<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'announcement_date' => 'required|date|after_or_equal:today|date_format:Y-m-d H:i:s'
        ]);

        $announcement = Announcement::create([
            'course_id' => $courseId,
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'announcement_date' => $request->announcement_date,
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'Announcement created successfully.',
            'data' => $announcement,
        ]);
    }

    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $announcements = $course->announcements()->with('teacher')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Announcements retrieved successfully.',
            'data' => $announcements,
        ]);
    }

    public function update(Request $request, $announcementId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'announcement_date' => 'required|date|after_or_equal:today|date_format:Y-m-d H:i:s', // Pengumuman harus pada tanggal hari ini atau di masa depan
        ]);

        $announcement = Announcement::findOrFail($announcementId);

        // Pastikan user yang sedang login adalah seorang teacher dan pengumuman ini dibuat oleh teacher yang sama
        // if ($announcement->teacher_id != Auth::id() || !Auth::user()->hasRole('teacher')) {
        //     return response()->json([
        //         'code' => 403,
        //         'message' => 'Unauthorized: Only the teacher who created the announcement can edit it.',
        //     ], 403);
        // }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_date' => $request->announcement_date,
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Announcement updated successfully.',
            'data' => $announcement,
        ]);
    }

    public function destroy($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        // Pastikan user yang sedang login adalah seorang teacher dan pengumuman ini dibuat oleh teacher yang sama
        // if ($announcement->teacher_id != Auth::id() || !Auth::user()->hasRole('teacher')) {
        //     return response()->json([
        //         'code' => 403,
        //         'message' => 'Unauthorized: Only the teacher who created the announcement can delete it.',
        //     ], 403);
        // }

        $announcement->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Announcement deleted successfully.',
        ]);
    }




}