<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'feature_video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400', // 100MB max
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.contents' => 'required|array|min:1',
            'modules.*.contents.*.type' => 'required|in:text,video,image,link',
            'modules.*.contents.*.content' => 'required|string',
            'modules.*.contents.*.file' => 'nullable|file|mimes:mp4,avi,mov,wmv,jpg,jpeg,png,gif|max:102400',
        ];
    }

    public function messages()
    {
        return [
            'modules.required' => 'At least one module is required.',
            'modules.*.contents.required' => 'Each module must have at least one content item.',
            'modules.*.contents.*.type.in' => 'Content type must be text, video, image, or link.',
        ];
    }
}