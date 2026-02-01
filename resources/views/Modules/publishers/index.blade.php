@extends('layouts.app')
@section('title', 'Nearbooks | Publishers')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="publisher-table"
        title="Publisher Management"
        ajax-route="{{ route('publishers.data') }}"
        add-button-text="Add Publisher"
        add-button-action="openAddModal(publisherCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'slug', 'title' => 'Slug'],
            ['data' => 'email', 'title' => 'Email'],
            ['data' => 'phone', 'title' => 'Phone'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const publisherCrud = {
    title: 'Add Publisher',
    editTitle: 'Edit Publisher',
    url: "{{ url('publishers') }}",
    table: '#publisher-table',
    fields: [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'slug', label: 'Slug', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'email' },
        { name: 'phone', label: 'Phone', type: 'text' },
        { name: 'address', label: 'Address', type: 'textarea' },
        { name: 'website', label: 'Website', type: 'text' },
        {
                name: 'logo',
                label: 'logo Image ',
                type: 'file'
            },
        { name: 'description', label: 'Description', type: 'textarea' },
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
