@extends('layouts.app')

@section('title', 'Create Course - Course Builder')

@section('content')
    <div class="page-header">
        <h1>Create New Course</h1>
        <p>Build your course structure with modules and content</p>
    </div>

    <div class="content-section">
        <form id="courseForm" class="course-form" enctype="multipart/form-data"  data-url="{{ route('courses.store') }}">
            @csrf
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Basic Information
                </h3>
                <div class="form-row">
                    <div class="form-group ">
                        <label for="courseTitle" class="form-label">Course Title *</label>
                        <input type="text" id="courseTitle" name="title" class="form-input" placeholder="Enter course title" >
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="courseCategory" class="form-label">Category *</label>
                        <select id="courseCategory" class="form-select" name="category">
                            <option value="">Select Category</option>
                            <option value="web-dev">Web Development</option>
                            <option value="design">UI/UX Design</option>
                            <option value="data-science">Data Science</option>
                            <option value="business">Business</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                </div>
                
                <div class="form-group">
                    <label for="courseDescription" class="form-label">Course Description *</label>
                    <textarea id="courseDescription" class="form-textarea" rows="4" placeholder="Describe what students will learn in this course..." name="description"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

         
           <!-- Feature Video -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-video"></i>
                    Feature Video
                </h3>
                <div class="file-upload-area" id="featureVideoUpload">
                    <div class="upload-placeholder">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h4 class="text-wrap-anywhere">Upload Feature Video</h4>
                        <p>Drag & drop your video file here or click to browse</p>
                        <p class="upload-hint">Supported formats: MP4, AVI, MOV, WMV (Max: 100MB)</p>
                    </div>
                    <input type="file" id="feature_video" accept="video/*" name="feature_video" class="file-input">
                </div>
                <div class="invalid-feedback" id="feature_video_error"></div>
            </div>

            <!-- Course Modules -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-folder"></i>
                        Course Modules
                    </h3>
                    <button type="button" class="btn btn-primary" id="addModuleBtn">
                        <i class="fas fa-plus"></i> Add Module
                    </button>
                </div>
                
                <div id="modulesContainer" class="modules-container">
                    <!-- Modules will be added here dynamically -->
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" id="resetForm" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Create Course</button>
            </div>
        </form>
    </div>

    <!-- Module Template -->
    <template id="moduleTemplate">
        <div class="module-card" data-module-index="0">
            <div class="module-header">
                <div class="module-title">
                    <i class="fas fa-folder"></i>
                    <span>Module <span class="module-number">1</span></span>
                </div>
                <div class="module-actions ">
                    <button type="button" class="btn-collapse" data-toggle="collapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm remove-module">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="module-body collapse show">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Module Title *</label>
                        <input type="text" class="form-input module-title-input"  name="modules[0][title]">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-input module-description-input" name="modules[0][description]">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                
                <div class="contents-section">
                    <div class="contents-header">
                        <h5>Module Contents</h5>
                        <button type="button" class="btn btn-outline btn-sm add-content">
                            <i class="fas fa-plus"></i> Add Content
                        </button>
                    </div>
                    
                    <div class="contents-container">
                        <!-- Contents will be added here -->
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Content Template -->
    <template id="contentTemplate">
        <div class="content-item" data-content-index="0">
            <div class="content-header">
                <div class="content-title">
                    <i class="fas fa-file"></i>
                    <span>Content <span class="content-number">1</span></span>
                </div>
                <div class="content-actions">
                    <button type="button" class="btn-collapse" data-toggle="collapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm remove-content">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="content-body int_collapse collapse show">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Content Type *</label>
                        <select class="form-select content-type" name="modules[0][contents][0][type]">
                            <option value="">Select Type</option>
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                            <option value="link">Link</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content *</label>
                        <input type="text" class="form-input content-value" name="modules[0][contents][0][content]" placeholder="Enter content..." >
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                
                <div class="file-upload-container" style="display: none;">
                    <label class="form-label">Upload File</label>
                    <input type="file" class="form-input content-file" name="modules[0][contents][0][file]" accept="video/*,image/*">
                    <p class="form-hint">For video and image content types</p>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </template>


@endsection

@push('scripts') 
    <script src="{{ asset('js/course-form-manager.js') }}"></script>
    <script>
        // Initialize the class when document is ready
        $(document).ready(function() {
            window.courseFormManager = new CourseFormManager();
        });
    </script>
@endpush

