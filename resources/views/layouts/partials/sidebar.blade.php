<div class="sidebar-inner mx-3">
    <ul class="nav flex-column mt-4">
        <li class="nav-item {{ request()->routeIs('sendportal.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.dashboard') }}">
                <i class="fa-fw fas fa-home mr-2"></i><span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*campaigns*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.campaigns.index') }}">
                <i class="fa-fw fas fa-envelope mr-2"></i><span>{{ __('Campaigns') }}</span>
            </a>
        </li>
        @if (\Cornatul\Marketing\Base\Facades\Helper::isPro())
        <li class="nav-item {{ request()->is('*automations*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.automations.index') }}">
                <i class="fa-fw fas fa-sync-alt mr-2"></i><span>{{ __('Automations') }}</span>
            </a>
        </li>
        @endif
        <li class="nav-item {{ request()->is('*templates*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.templates.index') }}">
                <i class="fa-fw fas fa-file-alt mr-2"></i><span>{{ __('Templates') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*subscribers*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.subscribers.index') }}">
                <i class="fa-fw fas fa-user mr-2"></i><span>{{ __('Subscribers') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*messages*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.messages.index') }}">
                <i class="fa-fw fas fa-paper-plane mr-2"></i><span>{{ __('Messages') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*email-services*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketing.email_services.index') }}">
                <i class="fa-fw fas fa-envelope mr-2"></i><span>{{ __('Email Services') }}</span>
            </a>
        </li>

        {!! \Cornatul\Marketing\Base\Facades\Sendportal::sidebarHtmlContent() !!}

    </ul>
</div>