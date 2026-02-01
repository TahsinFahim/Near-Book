@extends('layouts.app')
@section('title', 'Nearbooks | Contact Info')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="contact-info-table"
        title="Contact Info Management"
        ajax-route="{{ route('contact-info.data') }}"
        add-button-text="Add Contact Info"
        add-button-action="openAddModal(contactInfoCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'phone', 'title' => 'Phone'],
            ['data' => 'whatsapp', 'title' => 'WhatsApp'],
            ['data' => 'email', 'title' => 'Email'],
            ['data' => 'facebook', 'title' => 'Facebook'],
            ['data' => 'instagram', 'title' => 'Instagram'],
            ['data' => 'twitter', 'title' => 'Twitter'],
            ['data' => 'linkedin', 'title' => 'LinkedIn'],
            ['data' => 'youtube', 'title' => 'YouTube'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const contactInfoCrud = {
    title: 'Add Contact Info',
    editTitle: 'Edit Contact Info',
    url: "{{ url('contact-info') }}",
    table: '#contact-info-table',
    fields: [
        { name: 'phone', label: 'Phone', type: 'text' },
        { name: 'whatsapp', label: 'WhatsApp', type: 'text' },
        { name: 'email', label: 'Email', type: 'email' },
        { name: 'facebook', label: 'Facebook', type: 'text' },
        { name: 'instagram', label: 'Instagram', type: 'text' },
        { name: 'twitter', label: 'Twitter', type: 'text' },
        { name: 'linkedin', label: 'LinkedIn', type: 'text' },
        { name: 'youtube', label: 'YouTube', type: 'text' },
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
