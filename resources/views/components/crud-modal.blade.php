<div id="crudModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    onclick="closeCrudModal()">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative"
        onclick="event.stopPropagation()">

        <!-- Close -->
        <button type="button"
            class="absolute top-3 right-3 text-gray-500"
            onclick="closeCrudModal()">
            <i class="fas fa-times"></i>
        </button>

        <h2 id="crudModalTitle" class="text-xl font-semibold mb-4"></h2>

        <form id="crudForm">
            @csrf
            <input type="hidden" id="record_id">

            <div id="crudFields"></div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                    onclick="closeCrudModal()"
                    class="px-4 py-2 bg-gray-300 rounded">
                    Cancel
                </button>
                <button type="submit"
                    id="crudSubmitBtn"
                    class="px-4 py-2 bg-[#003366] text-white rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    /**
     * GLOBAL CRUD CONFIG
     */
    let crudConfig = {
        method: 'POST',
        url: '',
        table: '',
        editId: null,
        fields: []
    };

    /**
     * OPEN ADD MODAL
     */
    function openAddModal(config) {
        crudConfig = {
            ...config,
            method: 'POST',
            editId: null
        };

        $('#crudForm')[0].reset();
        $('#record_id').val('');
        $('#crudModalTitle').text(config.title || 'Add');
        $('#crudSubmitBtn').text('Add');

        renderCrudFields(config.fields);
        $('#crudModal').removeClass('hidden');
    }

    /**
     * OPEN EDIT MODAL
     */
    function openEditModal(config, data) {
        crudConfig = {
            ...config,
            method: 'PUT',
            editId: data.id
        };

        $('#crudModalTitle').text(config.editTitle || 'Edit');
        $('#crudSubmitBtn').text('Update');

        renderCrudFields(config.fields, data);
        $('#crudModal').removeClass('hidden');
    }

    /**
     * CLOSE MODAL
     */
    function closeCrudModal() {
        $('#crudModal').addClass('hidden');
    }

    /**
     * RENDER DYNAMIC FIELDS
     */
    function renderCrudFields(fields, data = {}) {
        let html = '';

        fields.forEach(field => {
            let value = data[field.name] ?? '';

            if (field.type === 'select') {
                html += `
                    <div class="mb-4">
                        <label class="block mb-1">${field.label}</label>
                        <select name="${field.name}"
                            class="w-full px-3 py-2 border rounded">
                            ${field.options.map(opt =>
                                `<option value="${opt.value}" ${opt.value == value ? 'selected' : ''}>
                                    ${opt.label}
                                </option>`
                            ).join('')}
                        </select>
                    </div>
                `;
            } else {
                html += `
                    <div class="mb-4">
                        <label class="block mb-1">${field.label}</label>
                        <input
                            type="${field.type}"
                            name="${field.name}"
                            value="${value}"
                            class="w-full px-3 py-2 border rounded"
                            ${field.required ? 'required' : ''}
                        >
                    </div>
                `;
            }
        });

        $('#crudFields').html(html);
    }

    /**
     * SUBMIT FORM (AJAX)
     */
    $(document).on('submit', '#crudForm', function (e) {
        e.preventDefault();

        let url = crudConfig.method === 'POST'
            ? crudConfig.url
            : `${crudConfig.url}/${crudConfig.editId}`;

        $.ajax({
            url: url,
            type: crudConfig.method,
            data: $(this).serialize(),
            success: function (res) {
                closeCrudModal();

                if (crudConfig.table) {
                    $(crudConfig.table).DataTable().ajax.reload(null, false);
                }

                showToast(res.message || 'Saved successfully');
            },
            error: function () {
                showError('Operation failed');
            }
        });
    });
</script>
