@extends('layouts.app')
@section('title', 'Nearbooks | Site Logo')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="site-logo-table"
        title="Site Logo Management"
        ajax-route="{{ route('site-logo.data') }}"
        add-button-text="Add Logo"
        add-button-action="openAddModal(siteLogoCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'logo', 'title' => 'Logo', 'orderable' => false, 'searchable' => false],
            ['data' => 'alt_text', 'title' => 'Alt Text'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const siteLogoCrud = {
    title: 'Add Site Logo',
    editTitle: 'Edit Site Logo',
    url: "{{ url('site-logo') }}",
    table: '#site-logo-table',
    fields: [
        {
            name: 'logo_path',
            label: 'Logo Image',
            type: 'file',
            
        },
        {
            name: 'alt_text',
            label: 'Alt Text',
            type: 'text'
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
