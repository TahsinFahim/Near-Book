@extends('layouts.app')
@section('title', 'Nearbooks | Authors')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="author-table"
        title="Author Management"
        ajax-route="{{ route('authors.data') }}"
        add-button-text="Add Author"
        add-button-action="openAddModal(authorCrud)"
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
const authorCrud = {
    title: 'Add Author',
    editTitle: 'Edit Author',
    url: "{{ url('authors') }}",
    table: '#author-table',
    fields: [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'slug', label: 'Slug', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'email' },
        { name: 'phone', label: 'Phone', type: 'text' },
        { name: 'nationality', label: 'Nationality', type: 'text' },
        { name: 'date_of_birth', label: 'Date of Birth', type: 'date' },
        { name: 'photo', label: 'Photo URL', type: 'text' },
        { name: 'short_bio', label: 'Short Bio', type: 'textarea' },
        { name: 'biography', label: 'Biography', type: 'textarea' },
        {
            name: 'is_active',
            label: 'Status',
            type: 'select',
            options: [
                { value: 1, label: 'Active' },
                { value: 0, label: 'Inactive' }
            ]
        },
        { name: 'meta_title', label: 'Meta Title', type: 'text' },
        { name: 'meta_description', label: 'Meta Description', type: 'text' },
    ]
};
</script>
@endpush
