class CourseFormManager {
    constructor() {
        this.modules = []; // Array to store module data
        this.selectors = {
            modulesContainer: '#modulesContainer',
            moduleTemplate: '#moduleTemplate',
            contentTemplate: '#contentTemplate',
            addModuleBtn: '#addModuleBtn',
            courseForm: '#courseForm',
            resetForm: '#resetForm'
        };
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.addModule(); // Initialize first module
    }

    bindEvents() {
        $(this.selectors.addModuleBtn).on('click', () => this.addModule());
        $(document).on('click', '.remove-module', (e) => this.removeModule(e));
        $(document).on('click', '.add-content', (e) => this.addContent(e));
        $(document).on('click', '.remove-content', (e) => this.removeContent(e));
        $(document).on('change', '.content-type', (e) => this.handleContentTypeChange(e));
        $(this.selectors.courseForm).on('submit', (e) => this.handleFormSubmit(e));
        $(this.selectors.resetForm).on('click', () => this.resetForm());
        
    }

    addModule() {
        const moduleIndex = this.modules.length;
        const template = $(this.selectors.moduleTemplate).html();
        const $module = $(template);
        
        // Set data attributes
        $module.attr('data-module-index', moduleIndex);
        
        $(this.selectors.modulesContainer).append($module);
        
        // Initialize module in array
        this.modules.push({
            element: $module,
            contents: []
        });
        
        this.updateModuleNumbers();
        this.addContentToModule(moduleIndex);
    }

    removeModule(event) {
        if (this.modules.length > 1) {
            const $module = $(event.target).closest('.module-card');
            const moduleIndex = parseInt($module.attr('data-module-index'));
            
            // Remove from array
            this.modules.splice(moduleIndex, 1);
            
            // Remove from DOM
            $module.remove();
            
            // Reindex all modules
            this.reindexModules();
        } else {
            alert('At least one module is required.');
        }
    }

    addContent(event) {
        const $module = $(event.target).closest('.module-card');
        const moduleIndex = parseInt($module.attr('data-module-index'));
        this.addContentToModule(moduleIndex);
    }

    addContentToModule(moduleIndex) {
        const module = this.modules[moduleIndex];
        const contentIndex = module.contents.length;
        const template = $(this.selectors.contentTemplate).html();
        const $content = $(template);
        
        // Set data attributes
        $content.attr('data-content-index', contentIndex);
        
        module.element.find('.contents-container').append($content);
        
        // Add to array
        module.contents.push({
            element: $content
        });
        
        this.updateContentNumbers(moduleIndex);
    }

    removeContent(event) {
        const $content = $(event.target).closest('.content-item');
        const $module = $content.closest('.module-card');
        const moduleIndex = parseInt($module.attr('data-module-index'));
        const module = this.modules[moduleIndex];
        
        if (module.contents.length > 1) {
            const contentIndex = parseInt($content.attr('data-content-index'));
            
            // Remove from array
            module.contents.splice(contentIndex, 1);
            
            // Remove from DOM
            $content.remove();
            
            // Reindex contents in this module
            this.reindexModuleContents(moduleIndex);
        } else {
            alert('At least one content item is required per module.');
        }
    }

    reindexModules() {
        $(`${this.selectors.modulesContainer} .module-card`).each((index, element) => {
            const $module = $(element);
            const oldIndex = parseInt($module.attr('data-module-index'));
            
            // Update data attribute
            $module.attr('data-module-index', index);
            
            // Update array reference
            if (index !== oldIndex) {
                this.modules[index] = this.modules[oldIndex];
            }
            
            // Update display numbers and input names
            this.updateModuleDisplay(index);
        });
        
        // Trim array to current length
        this.modules = this.modules.slice(0, $(`${this.selectors.modulesContainer} .module-card`).length);
    }

    reindexModuleContents(moduleIndex) {
        const module = this.modules[moduleIndex];
        
        module.element.find('.content-item').each((index, element) => {
            const $content = $(element);
            const oldIndex = parseInt($content.attr('data-content-index'));
            
            // Update data attribute
            $content.attr('data-content-index', index);
            
            // Update array reference
            if (index !== oldIndex) {
                module.contents[index] = module.contents[oldIndex];
            }
            
            // Update display numbers and input names
            this.updateContentDisplay(moduleIndex, index, $content);
        });
        
        // Trim array to current length
        module.contents = module.contents.slice(0, module.element.find('.content-item').length);
    }

    updateModuleNumbers() {
        this.modules.forEach((module, index) => {
            this.updateModuleDisplay(index);
        });
    }

    updateModuleDisplay(moduleIndex) {
        const module = this.modules[moduleIndex];
        const $module = module.element;
        
        // Update display number
        $module.find('.module-number').text(moduleIndex + 1);
        
        // Update module input names
        $module.find('.module-title-input').attr('name', `modules[${moduleIndex}][title]`);
        $module.find('.module-description-input').attr('name', `modules[${moduleIndex}][description]`);
        
        // Update all content input names in this module
        this.updateContentNumbers(moduleIndex);
    }

    updateContentNumbers(moduleIndex) {
        const module = this.modules[moduleIndex];
        
        module.contents.forEach((content, contentIndex) => {
            this.updateContentDisplay(moduleIndex, contentIndex, content.element);
        });
    }

    updateContentDisplay(moduleIndex, contentIndex, $content) {
        // Update display number
        $content.find('.content-number').text(contentIndex + 1);
        
        // Update input names with correct indexes
        $content.find('.content-type').attr('name', `modules[${moduleIndex}][contents][${contentIndex}][type]`);
        $content.find('.content-value').attr('name', `modules[${moduleIndex}][contents][${contentIndex}][content]`);
        $content.find('.content-file').attr('name', `modules[${moduleIndex}][contents][${contentIndex}][file]`);
    }

    handleContentTypeChange(event) {
        const $content = $(event.target).closest('.content-item');
        const fileContainer = $content.find('.file-upload-container');
        const type = $(event.target).val();
        
        if (type === 'video' || type === 'image') {
            fileContainer.show();
            const fileInput = $content.find('.content-file');
            fileInput.attr('accept', type === 'video' ? 'video/*' : 'image/*');
        } else {
            fileContainer.hide();
        }
    }


    handleFormSubmit(event) {
        event.preventDefault();
        this.submitForm();
    }

    submitForm() {
        const formData = new FormData($(this.selectors.courseForm)[0]);
        
        $('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...');

        $.ajax({
            url: $(this.selectors.courseForm).data('url'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: (response) => {
                this.showAlert('success', response.message);
                this.resetSubmitButton();
            },
            error: (xhr) => {
                this.resetSubmitButton();
                
                if (xhr.status === 422) {
                    // this.handleValidationErrors(xhr.responseJSON.errors);
                    this.showErrorPopup(xhr.responseJSON.errors)
                } else {
                    this.showAlert('danger', 'An error occurred while creating the course. Please try again.');
                }
            }
        });
    }



    resetSubmitButton() {
        $('button[type="submit"]').prop('disabled', false).text('Create Course');
    }

    showErrorPopup(errors) {
        let errorMessages = [];
        
        // Collect all error messages
        $.each(errors, (field, messages) => {
            errorMessages = errorMessages.concat(messages);
        });
        
        // Create alert message
        const errorHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Please fix the following errors:</h5>
                <ul class="mb-0">
                    ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                </ul>
                
            </div>
        `;
        
        // Remove existing alerts
        $('.alert-danger').remove();
        
        // Prepend to form
        $(this.selectors.courseForm).prepend(errorHTML);
        
        // Scroll to top
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    }


   
    clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }

    resetForm() {
        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
            $(this.selectors.modulesContainer).empty();
            this.modules = [];
            this.addModule();
            $(this.selectors.courseForm)[0].reset();
            this.clearValidationErrors();
        }
    }

    showAlert(type, message) {
        const alert = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`);
        
        $(this.selectors.courseForm).prepend(alert);
        
        setTimeout(() => {
            alert.alert('close');
        }, 5000);
    }

    // Utility method to get module data
    getModuleData() {
        return this.modules.map((module, moduleIndex) => {
            return {
                index: moduleIndex,
                title: module.element.find('.module-title-input').val(),
                description: module.element.find('.module-description-input').val(),
                contents: module.contents.map((content, contentIndex) => {
                    return {
                        index: contentIndex,
                        type: content.element.find('.content-type').val(),
                        content: content.element.find('.content-value').val(),
                        file: content.element.find('.content-file')[0]?.files[0]
                    };
                })
            };
        });
    }
}
