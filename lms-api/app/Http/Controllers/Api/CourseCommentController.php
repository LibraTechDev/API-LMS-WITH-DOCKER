<?php

namespace App\Http\Controllers\Api;


use App\Models\Comment;
use App\Models\CourseMember;
use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Http\Controllers\Controller;

class  CourseCommentController extends Controller
{
    public function index($content_id)
    {
        $comments = Comment::where('content_id', $content_id)->get();

        return response()->json([
            'code' => 200,
            'message' => 'Daftar Komentar Berhasil Diambil',
            'data' => $comments,
        ]);
    }

    public function store(Request $request, $content_id)
    {
        $validated = $request->validate(['comment' => 'required|string']);

        $content = CourseContent::findOrFail($content_id);

        if (!CourseMember::where('course_id', $content->course_id)->where('user_id', $request->user()->id)->exists()) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }

        $comment = new Comment([
            'content_id' => $content->id,
            'member_id' => CourseMember::where('course_id', $content->course_id)
                ->where('user_id', $request->user()->id)
                ->firstOrFail()
                ->id,
            'comment' => $validated['comment'],
        ]);

        $comment->save();

        return response()->json([
            'code' => 201,
            'message' => 'Komentar Berhasil Ditambahkan',
            'data' => $comment,
        ], 201);
    }

    public function destroy(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        if ($comment->member->user_id !== $request->user()->id) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }

        $comment->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Komentar Berhasil Dihapus',
            'data' => null,
        ]);
    }

}