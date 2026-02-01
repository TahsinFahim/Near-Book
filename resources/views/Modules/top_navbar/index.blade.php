@extends('layouts.app')
@section('title', 'Nearbooks | Top Navbar')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="top-navbar-table"
        title="Top Navbar Management"
        ajax-route="{{ route('top-navbar.data') }}"
        add-button-text="Add Navbar Item"
        add-button-action="openAddModal(topNavbarCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'title' => 'Name (Key)'],
            ['data' => 'label', 'title' => 'Label (Visible Text)'],
            ['data' => 'url', 'title' => 'URL'],
            ['data' => 'position', 'title' => 'Position'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const topNavbarCrud = {
    title: 'Add Navbar Item',
    editTitle: 'Edit Navbar Item',
    url: "{{ url('top-navbar') }}",
    table: '#top-navbar-table',
    fields: [
        { name: 'name', label: 'Key (name)', type: 'text', required: true },
        { name: 'label', label: 'Label (visible text)', type: 'text', required: true },
        { name: 'url', label: 'URL', type: 'text', required: true },
        { name: 'position', label: 'Position', type: 'number' },
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
