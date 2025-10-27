@extends('layouts.app')

@section('title', 'All Courses - Course Builder')

@section('content')

    {{-- page header  --}}
    <div class="page-header">
        <h1>Dashboard Overview</h1>
        <p>Welcome back! Here's what's happening with your courses.</p>
    </div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalCourses }}</h3>
            <p>Total Courses</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-folder"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalModules }}</h3>
            <p>Total Modules</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalContents }}</h3>
            <p>Total Contents</p>
        </div>
    </div>
</div>



   
@endsection