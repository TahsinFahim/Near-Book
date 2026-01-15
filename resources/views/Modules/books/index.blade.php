@extends('layouts.app')
@section('title', 'Nearbooks | Books')

@section('content')

<div id="main-content" class="transition-all duration-300">
    
    <x-data-table
        table-id="book-table"
        title="Book Management"
        ajax-route="{{ route('books.data') }}"
        add-button-text="Add Book"
        add-button-action="openAddModal(bookCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'title' => 'Title'],
            ['data' => 'slug', 'title' => 'Slug'],
            ['data' => 'author', 'title' => 'Author'],
            ['data' => 'price', 'title' => 'Price'],
            ['data' => 'stock', 'title' => 'Stock'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
        :filters="[
           [
    'name' => 'author_id',
    'label' => 'Author',
    'options' => collect([['value' => '', 'label' => 'All']])
        ->merge($authors->map(fn($a) => ['value' => $a->id, 'label' => $a->name]))
        ->toArray(),
    'default' => ''
],
['name' => 'filter', 'label' => 'Filter', 'options' => [
            ['value' => '', 'label' => 'All'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'latest', 'label' => 'Latest'],
            ['value' => 'oldest', 'label' => 'Oldest'],
        ], 'default' => ''],
        ]" />
</div>

@endsection

@push('scripts')
<script>
    const bookCrud = {
        title: 'Add Book',
        editTitle: 'Edit Book',
        url: "{{ url('books') }}",
        table: '#book-table',
        fields: [{
                name: 'title',
                label: 'Title',
                type: 'text',
                required: true
            },
            {
                name: 'slug',
                label: 'Slug',
                type: 'text',
                required: true
            },
            {
    name: 'author_id',
    label: 'Author',
    type: 'select',
    required: true,
    placeholder: 'Select an Author',
    options: @json($authors->map(fn($author) => [
        'value' => $author->id,
        'label' => $author->name
    ]))
},
{
    name: 'category_id',
    label: 'Category',
    type: 'select',
    required: true,
    placeholder: 'Select Category',
    options: @json($categories->map(fn($category) => [
        'value' => $category->id,
        'label' => $category->name
    ]))
},


{
    name: 'sub_category_id',
    label: 'Sub Category',
    type: 'select',
    required: true,
    options: [] // initially empty
},


            {
                name: 'isbn',
                label: 'ISBN',
                type: 'text'
            },
            {
                name: 'price',
                label: 'Price',
                type: 'number',
                step: '0.01'
            },
            {
                name: 'stock',
                label: 'Stock',
                type: 'number'
            },
            {
                name: 'cover_image',
                label: 'Cover Image URL',
                type: 'file'
            },
            {
                name: 'short_description',
                label: 'Short Description',
                type: 'textarea'
            },
            {
                name: 'description',
                label: 'Description',
                type: 'textarea'
            },
            {
                name: 'publication_date',
                label: 'Publication Date',
                type: 'date'
            },
            {
                name: 'publisher',
                label: 'Publisher',
                type: 'text'
            },
            {
                name: 'is_active',
                label: 'Status',
                type: 'select',
                options: [{
                        value: 1,
                        label: 'Active'
                    },
                    {
                        value: 0,
                        label: 'Inactive'
                    }
                ]
            },
            {
                name: 'meta_title',
                label: 'Meta Title',
                type: 'text'
            },
            {
                name: 'meta_description',
                label: 'Meta Description',
                type: 'text'
            },
        ]
    };
</script>

<script>
    function loadSubCategories(categoryId, selectedId = null) {
        const subCategorySelect = $('#field_sub_category_id');

        subCategorySelect.html('<option value="">Loading...</option>');

        if (!categoryId) {
            subCategorySelect.html('<option value="">Select Category First</option>');
            return;
        }

        $.ajax({
            url: `/categories/${categoryId}/sub-categories`,
            type: 'GET',
            success: function (res) {
                let options = '<option value="">Select Sub Category</option>';

                res.forEach(item => {
                    const selected = selectedId == item.id ? 'selected' : '';
                    options += `<option value="${item.id}" ${selected}>${item.name}</option>`;
                });

                subCategorySelect.html(options);
            },
            error: function () {
                subCategorySelect.html('<option value="">Failed to load</option>');
            }
        });
    }

    // Category change
    $(document).on('change', '#field_category_id', function () {
        loadSubCategories($(this).val());
    });

    // 🔥 Page load (Edit mode support)
    $(document).ready(function () {
        const categoryId = $('#field_category_id').val();

        if (categoryId && selectedSubCategoryId) {
            loadSubCategories(categoryId, selectedSubCategoryId);
        }
    });
</script>



@endpush