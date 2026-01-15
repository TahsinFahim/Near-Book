<div id="crudModal"
    class="hidden fixed inset-0 z-50 flex items-start md:items-center justify-center bg-gray-400/60 backdrop-blur-sm transition-all duration-300 ease-out"
    onclick="closeCrudModal()">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl p-8 relative transform transition-all duration-300 ease-out translate-y-[-20px] opacity-0 max-h-[90vh] overflow-y-auto"
        id="crudModalContent"
        onclick="event.stopPropagation()">

        <!-- Close Button -->
        <button type="button"
            class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200"
            onclick="closeCrudModal()">
            <i class="fas fa-times text-lg"></i>
        </button>

        <!-- Modal Header -->
        <div class="mb-8">
            <h2 id="crudModalTitle" class="text-2xl font-bold text-gray-800 mb-2"></h2>
            <div class="h-1 w-12 bg-gradient-to-r from-[#003366] to-[#0066cc] rounded-full"></div>
        </div>

        <!-- Form -->
        <form id="crudForm" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="record_id">

            <div id="crudFields" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                <button type="button"
                    onclick="closeCrudModal()"
                    class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    Cancel
                </button>
                <button type="submit"
                    id="crudSubmitBtn"
                    class="px-5 py-2.5 text-white bg-gradient-to-r from-[#003366] to-[#0066cc] hover:from-[#002244] hover:to-[#0055aa] rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let crudConfig = {
    method: 'POST',
    url: '',
    table: '',
    editId: null,
    isSpecialUrl: false,
    specialUrl: '',
    fields: []
};

function openAddModal(config) {
    crudConfig = {
        ...config,
        method: 'POST',
        editId: null
    };

    $('#crudForm')[0].reset();
    $('#record_id').val('');
    $('#crudModalTitle').text(config.title || 'Add New Record');
    $('#crudSubmitBtn').text('Add');

    renderCrudFields(config.fields);

    $('#crudModal').removeClass('hidden');
    setTimeout(() => {
        $('#crudModalContent').removeClass('translate-y-[-20px] opacity-0').addClass('translate-y-0 opacity-100');
    }, 10);
}

function openEditModal(config, data) {
    crudConfig = {
        ...config,
        method: 'PUT',
        editId: data.id
    };

    $('#crudModalTitle').text(config.editTitle || 'Edit Record');
    $('#crudSubmitBtn').text('Update');

    renderCrudFields(config.fields, data);

    if (data.category_id) {
        $('#field_category_id').val(data.category_id);

        loadSubCategories(
            data.category_id,
            data.sub_category_id // <-- this selects sub-category
        );
    }

    $('#crudModal').removeClass('hidden');
    setTimeout(() => {
        $('#crudModalContent')
            .removeClass('translate-y-[-20px] opacity-0')
            .addClass('translate-y-0 opacity-100');
    }, 10);
}


function closeCrudModal() {
    $('#crudModalContent').removeClass('translate-y-0 opacity-100').addClass('translate-y-[-20px] opacity-0');
    setTimeout(() => {
        $('#crudModal').addClass('hidden');
    }, 300);
}

function renderCrudFields(fields, data = {}) {
    let html = '';

    fields.forEach(field => {
        let value = data[field.name] ?? field.value ?? '';
        const fieldId = `field_${field.name}`;

        // Skip menu_id for edit
        if (field.name === 'menu_id' && crudConfig.method === 'PUT') return;

        // Hidden
        if (field.type === 'hidden') {
            html += `<input class="hidden" type="hidden" id="${fieldId}" name="${field.name}" value="${value}">`;
            return;
        }

        // Textarea
        if (field.type === 'textarea') {
            html += `
                <div class="col-span-1 md:col-span-2">
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <textarea id="${fieldId}" name="${field.name}" rows="${field.rows || 4}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 focus:outline-none transition-all duration-200 resize-y"
                        ${field.required ? 'required' : ''} ${field.placeholder ? `placeholder="${field.placeholder}"` : ''}>${value}</textarea>
                </div>
            `;
        }
        // Select
        else if (field.type === 'select') {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <select id="${fieldId}" name="${field.name}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" ${field.required ? 'required' : ''}>
                        ${field.placeholder ? `<option value="">${field.placeholder}</option>` : ''}
                        ${field.options.map(opt => `<option value="${opt.value}" ${opt.value == value ? 'selected' : ''}>${opt.label}</option>`).join('')}
                    </select>
                </div>
            `;
        }
        // File
        else if (field.type === 'file') {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="file" id="${fieldId}" name="${field.name}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" accept="${field.accept || 'image/*'}" ${field.required ? 'required' : ''}>
                    ${value ? `<img src="${value}" alt="${field.label}" class="mt-2 h-24 w-24 object-cover rounded-md">` : ''}
                </div>
            `;
        }
        // Date
        else if (field.type === 'date') {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="date" id="${fieldId}" name="${field.name}" value="${value}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" ${field.required ? 'required' : ''}>
                </div>
            `;
        }
        // Email
        else if (field.type === 'email') {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="email" id="${fieldId}" name="${field.name}" value="${value}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" ${field.required ? 'required' : ''} ${field.placeholder ? `placeholder="${field.placeholder}"` : ''}>
                </div>
            `;
        }
        // Number
        else if (field.type === 'number') {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="number" id="${fieldId}" name="${field.name}" value="${value}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                        ${field.min !== undefined ? `min="${field.min}"` : ''}
                        ${field.max !== undefined ? `max="${field.max}"` : ''}
                        ${field.step !== undefined ? `step="${field.step}"` : ''}
                        ${field.required ? 'required' : ''}
                        ${field.placeholder ? `placeholder="${field.placeholder}"` : ''}>
                </div>
            `;
        }
        // Default text
        else {
            html += `
                <div>
                    <label for="${fieldId}" class="block mb-2 font-medium text-gray-700">
                        ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="${field.type}" id="${fieldId}" name="${field.name}" value="${value}" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                        ${field.required ? 'required' : ''}
                        ${field.placeholder ? `placeholder="${field.placeholder}"` : ''}
                        ${field.pattern ? `pattern="${field.pattern}"` : ''}
                        ${field.maxlength ? `maxlength="${field.maxlength}"` : ''}>
                </div>
            `;
        }
    });

    $('#crudFields').html(html);

    // Focus first input
    setTimeout(() => {
        $('#crudFields input:not([type="hidden"]), #crudFields select, #crudFields textarea').first().focus();
    }, 100);
}

// Preview image immediately when selected
$(document).on('change', '#crudFields input[type="file"]', function() {
    const file = this.files[0];
    if(file) {
        const preview = document.createElement('img');
        preview.src = URL.createObjectURL(file);
        preview.className = 'mt-2 h-24 w-24 object-cover rounded-md';

        $(this).siblings('img').remove(); // remove old preview
        $(this).after(preview);
    }
});

// Submit form
$(document).on('submit', '#crudForm', function (e) {
    e.preventDefault();

    const submitBtn = $('#crudSubmitBtn');
    const originalText = submitBtn.text();
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');

    let url = crudConfig.method === 'POST'
        ? crudConfig.url
        : `${crudConfig.url}/${crudConfig.editId}`;

    let formData = new FormData(this);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    if (crudConfig.method === 'PUT') {
        formData.append('_method', 'PUT'); // ✅ this is important
    }

    $.ajax({
        url: url,
        type: 'POST', // Always POST, PUT is handled via _method
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            submitBtn.prop('disabled', false).text(originalText);
            closeCrudModal();

            if (crudConfig.table) {
                $(crudConfig.table).DataTable().ajax.reload(null, false);
            }

            showToast(res.message || 'Operation completed successfully', 'success');
        },
        error: function (xhr) {
            submitBtn.prop('disabled', false).text(originalText);

            const errorMessage = xhr.responseJSON?.message || 'Operation failed. Please try again.';
            showError(errorMessage);

            if (xhr.responseJSON?.errors) {
                Object.keys(xhr.responseJSON.errors).forEach(field => {
                    $(`[name="${field}"]`).addClass('border-red-500');
                });
            }
        }
    });
});

// Remove error style on focus
$(document).on('focus', '#crudFields input, #crudFields select, #crudFields textarea', function() {
    $(this).removeClass('border-red-500');
});

// Close modal on Escape key
$(document).on('keydown', function(e) {
    if (e.key === 'Escape' && !$('#crudModal').hasClass('hidden')) {
        closeCrudModal();
    }
});
</script>
