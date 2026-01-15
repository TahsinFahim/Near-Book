<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ===================== -->
    <!-- DataTables CSS -->
    <!-- ===================== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- ===================== -->
    <!-- jQuery (must load first) -->
    <!-- ===================== -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- ===================== -->
    <!-- DataTables core -->
    <!-- ===================== -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- ===================== -->
    <!-- Export Dependencies -->
    <!-- ===================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- ===================== -->
    <!-- DataTables Buttons -->
    <!-- ===================== -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <!-- ColVis Button for DataTables -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastify CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        :root {
            --sidebar-width: 16rem;
            --sidebar-collapsed-width: 5rem;
            --transition-speed: 300ms;
        }

        .sidebar-transition {
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* DataTable fixes */
        table.dataTable {
            width: 100% !important;
        }

        .dataTables_wrapper {
            padding-top: 1rem;
        }

        .dataTables_processing {
            z-index: 50;
        }

        /* Remove default caret/arrow from "Show X entries" */
        .dataTables_length select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: none;
            padding-right: 0.5rem;
        }

        /* Align DataTable elements using flex */
        .dataTables_wrapper .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        /* Optional: style buttons consistently */
        .dt-button {
            background-color: #003366 !important;
            color: #fff !important;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            margin-left: 0.25rem;
            border: none;
        }

        .dt-button i {
            margin-right: 0.25rem;
        }

        :root {
            --sidebar-width: 16rem;
            --sidebar-collapsed-width: 5rem;
            --transition-speed: 300ms;
        }

        .sidebar-transition {
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
        }

        .submenu-enter {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }

        .submenu-enter-active {
            max-height: 500px;
            opacity: 1;
            transition: max-height var(--transition-speed) ease,
                opacity var(--transition-speed) ease;
        }

        .sidebar-collapsed .menu-text,
        .sidebar-collapsed .submenu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-collapsed .expand-icon {
            display: none;
        }

        .rotate-90 {
            transform: rotate(90deg);
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>

    @stack('styles')
</head>


<body class="font-sans antialiased bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Include Sidebar Partial -->
        @include('layouts.partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Toggle -->
                        <button id="mobileMenuToggle"
                            class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>

                        <!-- Page Title -->
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('title', 'Dashboard')
                        </h2>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <input type="text"
                                placeholder="Search..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>

                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notificationsBtn"
                                class="p-2 rounded-full hover:bg-gray-100 relative">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div id="notificationsDropdown"
                                class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-40">
                                <div class="p-4 border-b">
                                    <h3 class="font-semibold text-gray-800">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Notification items -->
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative">
                            <button id="userMenuBtn"
                                class="flex items-center gap-3 p-1 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center">
                                    <span class="font-bold text-white text-sm">A</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-gray-800">Admin User</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs hidden md:block"></i>
                            </button>

                            <!-- User Dropdown -->
                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-40">
                                <div class="py-2">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-3"></i>Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-3"></i>Settings
                                    </a>
                                    <div class="border-t my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-3"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <!-- Breadcrumb -->
                <div class="px-6 pt-4">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            
                            @hasSection('breadcrumbs')
                            @yield('breadcrumbs')
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="p-6">
                    <!-- Page Alerts -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-red-700">There were errors with your submission:</p>
                                <ul class="mt-2 list-disc list-inside text-red-600">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Dynamic Content -->
                    @yield('content')
                </div>
            </main>
@include('components.crud-modal')
@include('components.delete')

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="px-6">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600">
                            © {{ date('Y') }} {{ config('app.name', 'Admin Panel') }}. All rights reserved.
                        </div>
                        <div class="flex items-center gap-4 mt-2 md:mt-0">
                            <a href="#" class="text-sm text-gray-600 hover:text-blue-600">Privacy Policy</a>
                            <a href="#" class="text-sm text-gray-600 hover:text-blue-600">Terms of Service</a>
                            <a href="#" class="text-sm text-gray-600 hover:text-blue-600">Help Center</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Mobile Overlay -->
        <div id="sidebarOverlay"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"
            onclick="closeSidebarMobile()"></div>
    </div>

    <!-- Sidebar Script -->
    <script>
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        }
    </script>

    <script>
        // Initialize sidebar on load
        document.addEventListener('DOMContentLoaded', function() {
            initSidebar();
            initDropdowns();
            initMobileMenu();
        });

        // Initialize dropdowns
        function initDropdowns() {
            // Notifications dropdown
            const notificationsBtn = document.getElementById('notificationsBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');

            if (notificationsBtn) {
                notificationsBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('hidden');
                });
            }

            // User dropdown
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');

            if (userMenuBtn) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                notificationsDropdown?.classList.add('hidden');
                userDropdown?.classList.add('hidden');
            });
        }

        // Initialize mobile menu
        function initMobileMenu() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    openSidebarMobile();
                });
            }
        }

        // Global functions for sidebar
        window.toggleSidebar = function() {
            if (typeof toggleSidebarMain === 'function') {
                toggleSidebarMain();
            }
        };

        window.openSidebarMobile = function() {
            if (typeof openSidebarMobileMain === 'function') {
                openSidebarMobileMain();
            }
        };

        window.closeSidebarMobile = function() {
            if (typeof closeSidebarMobileMain === 'function') {
                closeSidebarMobileMain();
            }
        };

        window.toggleSubmenu = function(id) {
            if (typeof toggleSubmenuMain === 'function') {
                toggleSubmenuMain(id);
            }
        };
    </script>

    <script>
    function showToast(message, type = 'success') {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            close: true,
            stopOnFocus: true,
            style: {
                background: type === 'success'
                    ? "#16a34a"   // green
                    : "#dc2626",  // red
            }
        }).showToast();
    }
</script>

<script src="{{ asset('js/crud-modal.js') }}"></script>

@stack('scripts')

</body>

</html>