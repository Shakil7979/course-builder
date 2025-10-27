@extends('layouts.app')

@section('title', 'All Courses - Course Builder')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>All Courses</h3>
            </div>
            <div class="card-body">
                @if($courses->count() > 0)
                    <div class="row">
                        @foreach($courses as $course)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->title }}</h5>
                                    <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                    <p class="card-text"><strong>Category:</strong> {{ $course->category }}</p>
                                    <p class="card-text"><strong>Modules:</strong> {{ $course->modules->count() }}</p>
                                    <p class="card-text"><small class="text-muted">Created: {{ $course->created_at->format('M d, Y') }}</small></p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <h4>No courses found</h4>
                        <p class="text-muted">Create your first course to get started!</p>
                        <a href="{{ route('courses.create') }}" class="btn btn-primary">Create First Course</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection