<div class="mainnav__profile mt-3 d-flex3">
    <div class="mt-2 d-mn-max"></div>
    <div class="mininav-toggle text-center py-2">
        <img class="mainnav__avatar img-md rounded-circle border" src="{{ asset('assets/dashboard/images/img-avatar.png') }}" alt="Avatar">
    </div>
    <div class="mininav-content collapse d-mn-max">
        <div class="d-grid">
            <button class="d-block btn shadow-none p-2" data-bs-toggle="collapse" data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
                <span class="dropdown-toggle d-flex justify-content-center align-items-center">
                    <h6 class="mb-0 me-3">
                        {{ Auth::user()->u_nama }}
                    </h6>
                </span>
                <small class="text-muted">
                    {{ Auth::user()->role->r_nama }}
                </small>
            </button>
            <div id="usernav" class="nav flex-column collapse">
                <a href="{{ route('user.profile',Crypt::encrypt(auth()->user()->u_id))}}" class="nav-link">
                    <i class="mdi mdi-account-circle align-middle fs-5 me-2"></i>
                    <span class="ms-1">Profil</span>
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="u_id" value="{{ Crypt::encrypt(auth()->user()->u_id) }}">
                    </form>
                    <i class="mdi mdi-logout align-middle fs-5 me-2"></i>
                    <span class="ms-1">Logout</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="mainnav__categoriy py-3">
    <h6 class="mainnav__caption mt-0 px-3 fw-bold">Navigation</h6>
    <ul class="mainnav__menu nav flex-column">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard']) }}">
                <i class="ri-home-4-fill fs-5 me-2"></i>
                <span class="nav-label mininav-content ms-1">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->can('View Complaint'))
            <li class="nav-item">
                <a href="{{ route('complaint.index') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/complaint*']) }}">
                    <i class="ri-clipboard-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Pengaduan</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('View Discussion'))
            <li class="nav-item">
                <a href="{{ route('discussion.index') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/discussion*']) }}">
                    <i class="ri-question-answer-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Tanya Jawab</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('View Complaint'))
            <li class="nav-item">
                <a href="{{ route('inbox.index') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/inbox*']) }}">
                    <i class="ri-mail-open-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Pengaduan via Email</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('report.index') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/report*']) }}">
                <i class="ri-article-fill fs-5 me-2"></i>
                <span class="nav-label mininav-content ms-1">Rekapitulasi</span>
            </a>
        </li> 
        @if (Auth::user()->can('View User') || Auth::user()->can('View Role') || Auth::user()->can('View Privilege'))
            <li class="nav-item has-sub">
                <a href="#" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/user*', 'dashboard/role*', 'dashboard/privilege*']) }}">
                    <i class="ri-user-3-fill fs-5 me-2"></i>
                    <span class="nav-label ms-1">Manajemen Akses</span>
                </a>
                <ul class="mininav-content nav collapse">
                    @if (Auth::user()->can('View User'))
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ GlobalHelper::setActive(['dashboard/user*']) }}">
                                Data Master User
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->can('View Role'))
                        <li class="nav-item">
                            <a href="{{ route('role.index') }}" class="nav-link {{ GlobalHelper::setActive(['dashboard/role*']) }}">
                                Data Master Role
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->can('View Privilege'))
                        <li class="nav-item">
                            <a href="{{ route('privilege.index') }}" class="nav-link {{ GlobalHelper::setActive(['dashboard/privilege*']) }}">
                                Data Master Privilege
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (Auth::user()->can('View Status'))
            <li class="nav-item">
                <a href="{{ route('status.index') }}" class="mininav-toggle nav-link collapsed {{ GlobalHelper::setActive(['dashboard/status*']) }}">
                    <i class="ri-flag-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Data Master Status</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('View CMS'))
            <li class="nav-item">
                <a href="{{ route('cms.index') }}" class="mininav-toggle nav-link collapsed">
                    <i class="ri-profile-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Content Management System</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('View Setting'))
            <li class="nav-item">
                <a href="{{ route('setting.index') }}" class="mininav-toggle nav-link collapsed">
                    <i class="ri-settings-4-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Pengaturan</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('View Log'))
            <li class="nav-item">
                <a href="{{ route('log.index') }}" class="mininav-toggle nav-link collapsed">
                    <i class="ri-chat-history-fill fs-5 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Log Aktivitas</span>
                </a>
            </li>
        @endif
    </ul>
</div>