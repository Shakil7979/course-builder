@extends('layouts.app')

@section('title', $course->title . ' - Course Builder')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>{{ $course->title }}</h3>
              
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5>Description</h5>
                        <p>{{ $course->description }}</p>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6>Course Details</h6>
                                <p><strong>Category:</strong> {{ $course->category }}</p>
                                <p><strong>Total Modules:</strong> {{ $course->modules->count() }}</p>
                                <p><strong>Total Contents:</strong> {{ $course->modules->sum(function($module) { return $module->contents->count(); }) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($course->feature_video_path)
                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Feature Video</h5>
                        <video controls width="100%" class="rounded">
                            <source src="{{ $course->feature_video_url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                @endif

                <div class="modules-section">
                    <h4>Course Modules</h4>
                    @foreach($course->modules as $module)
                    <div class="card module-card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Module {{ $loop->iteration }}: {{ $module->title }}</h5>
                            @if($module->description)
                            <p class="mb-0 text-muted">{{ $module->description }}</p>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6>Contents:</h6>
                            <div class="contents-container">
                                @foreach($module->contents as $content)
                                <div class="content-item card mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span class="badge bg-primary">{{ ucfirst($content->type) }}</span>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="mb-1">{{ $content->content }}</p>
                                                @if($content->file_path)
                                                <small class="text-muted">File: {{ $content->file_original_name }}</small>
                                                @endif
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <small class="text-muted">#{{ $loop->iteration }}</small>
                                            </div>
                                        </div>
                                        @if($content->file_url && in_array($content->type, ['video', 'image']))
                                        <div class="mt-2">
                                            @if($content->type === 'video')
                                            <video controls width="100%" class="rounded">
                                                <source src="{{ $content->file_url }}" type="video/mp4">
                                            </video>
                                            @elseif($content->type === 'image')
                                            <img src="{{ $content->file_url }}" alt="Content Image" class="img-fluid rounded" style="max-height: 200px;">
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection