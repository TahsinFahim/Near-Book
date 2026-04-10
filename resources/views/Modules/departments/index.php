@extends('layouts.app')
@section('title', 'Categories')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="department-table"
        title="Department Management"
        ajax-route="{{ route('departments.data') }}"
        add-button-text="Add Department"
        add-button-action="openAddModal(departmentCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'title' => 'Department Name'],
            ['data' => 'code', 'title' => 'Code'],
            ['data' => 'faculty', 'title' => 'Faculty'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const departmentCrud = {
    title: 'Add Department',
    editTitle: 'Edit Department',
    url: "{{ url('departments') }}",
    table: '#department-table',
    fields: [
        {
            name: 'name',
            label: 'Department Name',
            type: 'text',
            required: true
        },
        {
            name: 'code',
            label: 'Department Code',
            type: 'text',
            placeholder: 'e.g. CSE, EEE',
            required: true
        },
        {
            name: 'faculty',
            label: 'Faculty',
            type: 'text',
            placeholder: 'e.g. Engineering'
        },
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
