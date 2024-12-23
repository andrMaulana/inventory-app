<li class="nav-item">
    <a class="nav-link {{ Route::is('apps.dashboard') ? 'text-cyan' : '' }}"
        href="{{ route('apps.dashboard') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-tabler"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 9l3 3l-3 3"></path>
                <line x1="13" y1="15" x2="16" y2="15"></line>
                <rect x="4" y="4" width="16" height="16" rx="4"></rect>
            </svg>
        </span>
        <span class="nav-link-title">
            Dashboard
        </span>
    </a>
</li>
