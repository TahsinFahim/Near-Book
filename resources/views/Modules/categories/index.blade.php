@extends('layouts.app')
@section('title', 'Categories')

@section('content')

<x-data-table
    table-id="category-table"
    title="Category Management"
    ajax-route="{{ route('categories.data') }}"
    add-button-text="Add Category"
    add-button-action="openAddModal(categoryCrud)"
    :columns="[
        ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'title' => 'Name'],
        ['data' => 'slug', 'title' => 'Slug'],
        ['data' => 'description', 'title' => 'Description'],
        ['data' => 'serial', 'title' => 'Serial'],
        ['data' => 'is_homepage', 'title' => 'Homepage', 'orderable' => false, 'searchable' => false],
        ['data' => 'homepage_serial', 'title' => 'Homepage Serial'],
        ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
        ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
    ]"
/>

@endsection

@push('scripts')
<script>
    const categoryCrud = {
        title: 'Add Category',
        editTitle: 'Edit Category',
        url: "{{ url('/categories') }}",
        table: '#category-table',
        fields: [
            {
                name: 'name',
                label: 'Name',
                type: 'text',
                required: true
            },
            {
                name: 'slug',
                label: 'Slug',
                type: 'text'
            },
            {
                name: 'description',
                label: 'Description',
                type: 'textarea'
            },
            {
                name: 'serial',
                label: 'Serial',
                type: 'number',
                required: true,
                default: 0
            },
            {
                name: 'is_homepage',
                label: 'Show on Homepage',
                type: 'select',
                options: [
                    { value: 1, label: 'Yes' },
                    { value: 0, label: 'No' }
                ],
                default: 0
            },
            {
                name: 'homepage_serial',
                label: 'Homepage Serial',
                type: 'number',
                required: false,
                default: null
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
