<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample course
        $course = Course::create([
            'title' => 'Introduction to Web Development',
            'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript.',
            'category' => 'Programming'
        ]);

        // Create modules for the course
        $modules = [
            [
                'title' => 'HTML Basics',
                'description' => 'Learn the structure of web pages',
                'contents' => [
                    [
                        'type' => Content::TYPE_TEXT,
                        'content' => 'Introduction to HTML tags and elements'
                    ],
                    [
                        'type' => Content::TYPE_LINK,
                        'content' => 'https://developer.mozilla.org/en-US/docs/Web/HTML'
                    ]
                ]
            ],
            [
                'title' => 'CSS Styling',
                'description' => 'Learn how to style web pages',
                'contents' => [
                    [
                        'type' => Content::TYPE_TEXT,
                        'content' => 'Understanding CSS selectors and properties'
                    ],
                    [
                        'type' => Content::TYPE_LINK,
                        'content' => 'https://developer.mozilla.org/en-US/docs/Web/CSS'
                    ]
                ]
            ]
        ];

        foreach ($modules as $moduleIndex => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'],
                'order' => $moduleIndex
            ]);

            foreach ($moduleData['contents'] as $contentIndex => $contentData) {
                $module->contents()->create([
                    'type' => $contentData['type'],
                    'content' => $contentData['content'],
                    'order' => $contentIndex
                ]);
            }
        }
    }
}