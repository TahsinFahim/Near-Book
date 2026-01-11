<aside id="sidebar" 
       class=" custom-scrollbar sidebar-transition bg-[#003366] text-gray-200 flex flex-col fixed lg:sticky top-0 left-0 overflow-y-auto overflow-x-hidden h-screen z-50"
       style="width: var(--sidebar-width); min-width: var(--sidebar-width);">
    
    <!-- Logo & Toggle Section -->
    <div class="p-4 border-b border-gray-700/50 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-book text-white text-sm"></i>
            </div>
            <h1 class="text-xl font-bold whitespace-nowrap menu-text transition-all duration-300">
                Nearbooks
            </h1>
        </a>
        
        <!-- Desktop Toggle Button -->
        <button id="sidebarToggle" 
                class="p-2 rounded-lg hover:bg-gray-700/50 transition-colors duration-200 hidden lg:block"
                onclick="toggleSidebar()"
                aria-label="Toggle sidebar">
            <i class="fas fa-chevron-left text-gray-400 transition-transform duration-300"></i>
        </button>
        
        <!-- Mobile Close Button -->
        <button class="p-2 rounded-lg hover:bg-gray-700/50 transition-colors duration-200 lg:hidden"
                onclick="closeSidebarMobile()"
                aria-label="Close sidebar">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    
    <!-- Menu Container -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden py-4 scrollbar-thin">
        <nav class="px-3">
            <ul class="space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $hasSubmenu = $menu->submenus->count() > 0;
                        $isActive = request()->is(ltrim($menu->url, '/').'*');
                        $isSubmenuActive = false;
                        
                        if ($hasSubmenu) {
                            foreach ($menu->submenus as $sub) {
                                if (request()->is(ltrim($sub->url, '/').'*')) {
                                    $isSubmenuActive = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    <li>
                        @if ($hasSubmenu)
                            <!-- Menu with Submenu -->
                            <div class="relative">
                                <button type="button"
                                        onclick="toggleSubmenu('submenu-{{ $menu->id }}')"
                                        class="sidebar-item group w-full px-3 py-3 rounded-lg flex items-center justify-between hover:bg-gray-700/50 {{ $isSubmenuActive ? 'bg-gray-700/30' : '' }} transition-all duration-200"
                                        aria-expanded="{{ $isSubmenuActive ? 'true' : 'false' }}"
                                        aria-controls="submenu-{{ $menu->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center group-hover:bg-gray-600/50 transition-colors duration-200">
                                            <i class="{{ $menu->icon }} text-gray-300 text-sm"></i>
                                        </div>
                                        <span class="menu-text font-medium whitespace-nowrap transition-all duration-300">
                                            {{ $menu->name }}
                                        </span>
                                    </div>
                                    <span class="expand-icon transform transition-transform duration-200 {{ $isSubmenuActive ? 'rotate-90' : '' }}">
                                        <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                                    </span>
                                </button>
                                
                                <!-- Submenu Dropdown -->
                                <div id="submenu-{{ $menu->id }}"
                                     class="ml-10 mt-1 space-y-1 transition-all duration-300 {{ $isSubmenuActive ? '' : 'hidden' }}"
                                     role="region"
                                     aria-label="{{ $menu->name }} submenu">
                                    @foreach ($menu->submenus as $submenu)
                                        @php
                                            $isSubActive = request()->is(ltrim($submenu->url, '/').'*');
                                        @endphp
                                        <a href="{{ url($submenu->url) }}"
                                           class="submenu-item block px-3 py-2.5 rounded-lg text-sm hover:bg-gray-700/50 transition-colors duration-200 {{ $isSubActive ? 'bg-blue-600/20 text-blue-300 border-l-2 border-blue-500' : 'text-gray-400' }}"
                                           aria-current="{{ $isSubActive ? 'page' : 'false' }}">
                                            <span class="submenu-text whitespace-nowrap">
                                                {{ $submenu->name }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Single Menu Item -->
                            <a href="{{ url($menu->url) }}"
                               class="sidebar-item group block px-3 py-3 rounded-lg hover:bg-gray-700/50 {{ $isActive ? 'bg-gray-700/30 border-l-4 border-blue-500' : '' }} transition-all duration-200"
                               aria-current="{{ $isActive ? 'page' : 'false' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center group-hover:bg-gray-600/50 transition-colors duration-200">
                                        <i class="{{ $menu->icon }} text-gray-300 text-sm"></i>
                                    </div>
                                    <span class="menu-text font-medium whitespace-nowrap transition-all duration-300">
                                        {{ $menu->name }}
                                    </span>
                                </div>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    
    <!-- User Profile & Collapse Button -->
    <div class="border-t border-gray-700/50 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center flex-shrink-0">
                <span class="font-bold text-white text-sm">A</span>
            </div>
            <div class="menu-text whitespace-nowrap overflow-hidden transition-all duration-300">
                <p class="font-medium text-sm truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->role ?? 'Administrator' }}</p>
            </div>
            <button onclick="toggleSidebar()" 
                    class="ml-auto p-2 rounded-lg hover:bg-gray-700/50 transition-colors duration-200 hidden lg:block"
                    aria-label="Toggle sidebar">
                <i class="fas fa-chevron-left text-gray-400 transition-transform duration-300"></i>
            </button>
        </div>
    </div>
</aside>

<!-- Sidebar JavaScript -->
<script>
    // State management
    const SIDEBAR_STATE_KEY = 'sidebarCollapsed';
    
    // Initialize sidebar
    function initSidebar() {
        const savedState = localStorage.getItem(SIDEBAR_STATE_KEY);
        const isCollapsed = savedState ? JSON.parse(savedState) : false;
        
        if (isCollapsed) {
            collapseSidebar();
        } else {
            expandSidebar();
        }
        
        // Mobile handling
        if (window.innerWidth < 1024) {
            collapseSidebar();
            document.getElementById('sidebar').classList.add('-translate-x-full');
        }
    }
    
    // Toggle sidebar - main function
    function toggleSidebarMain() {
        const sidebar = document.getElementById('sidebar');
        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        
        if (isCollapsed) {
            expandSidebar();
            localStorage.setItem(SIDEBAR_STATE_KEY, 'false');
        } else {
            collapseSidebar();
            localStorage.setItem(SIDEBAR_STATE_KEY, 'true');
        }
    }
    
    // Expand sidebar
    function expandSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.querySelector('#sidebarToggle i');
        
        sidebar.classList.remove('sidebar-collapsed');
        sidebar.style.width = 'var(--sidebar-width)';
        sidebar.style.minWidth = 'var(--sidebar-width)';
        
        if (toggleIcon) {
            toggleIcon.classList.remove('rotate-180');
        }
        
        // Update all chevron icons
        document.querySelectorAll('#sidebarToggle i').forEach(icon => {
            icon.classList.remove('rotate-180');
        });
    }
    
    // Collapse sidebar
    function collapseSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.querySelector('#sidebarToggle i');
        
        sidebar.classList.add('sidebar-collapsed');
        sidebar.style.width = 'var(--sidebar-collapsed-width)';
        sidebar.style.minWidth = 'var(--sidebar-collapsed-width)';
        
        if (toggleIcon) {
            toggleIcon.classList.add('rotate-180');
        }
        
        // Update all chevron icons
        document.querySelectorAll('#sidebarToggle i').forEach(icon => {
            icon.classList.add('rotate-180');
        });
        
        // Hide all submenus when collapsed
        document.querySelectorAll('[id^="submenu-"]').forEach(submenu => {
            submenu.classList.add('hidden');
            const button = submenu.previousElementSibling;
            if (button) {
                const icon = button.querySelector('.expand-icon i');
                if (icon) icon.classList.remove('rotate-90');
            }
        });
    }
    
    // Toggle submenu
    function toggleSubmenuMain(id) {
        const submenu = document.getElementById(id);
        const button = submenu.previousElementSibling;
        const icon = button.querySelector('.expand-icon i');
        
        if (submenu.classList.contains('hidden')) {
            // Show submenu
            submenu.classList.remove('hidden');
            icon.classList.add('rotate-90');
            
            // Animate height
            submenu.style.maxHeight = '0';
            setTimeout(() => {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
            }, 10);
            
            // Auto-expand sidebar if collapsed
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('sidebar-collapsed')) {
                expandSidebar();
                localStorage.setItem(SIDEBAR_STATE_KEY, 'false');
            }
            
            button.setAttribute('aria-expanded', 'true');
        } else {
            // Hide submenu
            submenu.style.maxHeight = '0';
            icon.classList.remove('rotate-90');
            
            setTimeout(() => {
                submenu.classList.add('hidden');
                submenu.style.maxHeight = '';
            }, 300);
            
            button.setAttribute('aria-expanded', 'false');
        }
    }
    
    // Mobile sidebar functions
    function openSidebarMobileMain() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        
        // Expand sidebar on mobile
        expandSidebar();
    }
    
    function closeSidebarMobileMain() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
    
    // Handle window resize
    function handleResize() {
        if (window.innerWidth < 1024) {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            collapseSidebar();
        } else {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
            initSidebar();
        }
    }
    
    // Initialize sidebar on load
    document.addEventListener('DOMContentLoaded', function() {
        initSidebar();
        
        // Set active submenu heights for animation
        document.querySelectorAll('[id^="submenu-"]:not(.hidden)').forEach(submenu => {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
        });
        
        // Event listeners
        window.addEventListener('resize', handleResize);
    });
</script>