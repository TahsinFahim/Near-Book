@extends('layouts.app')
@section('title', 'Nearbooks | Sub Categories')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="sub-category-table"
        title="Sub Category Management"
        ajax-route="{{ route('sub-categories.data', $id) }}"
        add-button-text="Add Sub Category"
        add-button-action="openAddModal(subCategoryCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'slug', 'title' => 'Slug'],
            ['data' => 'description', 'title' => 'Description'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection


@push('scripts')
<script>
const subCategoryCrud = {
    title: 'Add Sub Category',
    editTitle: 'Edit Sub Category',
    url: "{{ url('sub-categories') }}",
    isSpecialUrl: true,
    specialUrl: "{{ url('sub-categories') }}",
    table: '#sub-category-table',
    fields: [
        { 
            name: 'category_id',
            label: 'Category ID',
            type: 'hidden',
            required: true,
            value: {{ $id }} // parent category id
        },
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'slug', label: 'Slug', type: 'text', required: true },
        { 
            name: 'description',
            label: 'Description',
            type: 'textarea'
        },
        {
            name: 'is_active',
            label: 'Status',
            type: 'select',
            options: [
                { value: 1, label: 'Active' },
                { value: 0, label: 'Inactive' }
            ]
        }
    ]
};
</script>
@endpush
