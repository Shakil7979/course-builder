<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function create()
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Create course
                $courseData = $request->only(['title', 'description', 'category']);
                
                if ($request->hasFile('feature_video')) {
                    $video = $request->file('feature_video');
                    $path = $video->store('videos', 'public');
                    $courseData['feature_video_path'] = $path;
                    $courseData['feature_video_original_name'] = $video->getClientOriginalName();
                }

                $course = Course::create($courseData);

                // Create modules and contents
                foreach ($request->modules as $moduleIndex => $moduleData) {
                    $module = $course->modules()->create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'] ?? null,
                        'order' => $moduleIndex
                    ]);

                    foreach ($moduleData['contents'] as $contentIndex => $contentData) {
                        $content = [
                            'type' => $contentData['type'],
                            'content' => $contentData['content'],
                            'order' => $contentIndex
                        ];

                        if (isset($contentData['file']) && $contentData['file']->isValid()) {
                            $file = $contentData['file'];
                            $path = $file->store('content-files', 'public');
                            $content['file_path'] = $path;
                            $content['file_original_name'] = $file->getClientOriginalName();
                        }

                        $module->contents()->create($content);
                    }
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Course created successfully!',
                'redirect_url' => url('/')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Course $course)
    {
        $course->load(['modules.contents']);
        return view('courses.show', compact('course'));
    }

    public function index()
    {
        $courses = Course::with('modules')->latest()->get();
        return view('courses.index', compact('courses'));
    }
}