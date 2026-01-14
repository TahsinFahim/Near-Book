@extends('layouts.app')
@section('title', 'Nearbooks | Sub Menus')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="sub-menu-table"
        title="Sub Menu Management"
        ajax-route="{{ route('submenus.data', $id) }}"
        add-button-text="Add Sub Menu"
        add-button-action="openAddModal(menuCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'url', 'title' => 'URL'],
            ['data' => 'order_by', 'title' => 'Order'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection


@push('scripts')
<script>
const menuCrud = {
    title: 'Add Sub Menu',
    editTitle: 'Edit Sub Menu',
    url: "{{ url('submenus') }}",
    isSpecialUrl: true,
    specialUrl: "{{ url('submenus') }}", 
    table: '#sub-menu-table',
    fields: [
        { 
            name: 'menu_id', 
            label: 'Menu ID', 
            type: 'hidden', 
            required: true, 
            value: {{ $id }}  // Set default value to $id from route parameter
        },
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'url', label: 'URL', type: 'text' },
        { name: 'order_by', label: 'Order', type: 'number' },
        {
            name: 'status',
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
