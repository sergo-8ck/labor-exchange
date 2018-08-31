<ul class="nav nav-tabs mb-3">
    @can ('manage-vacancies')
    <li class="nav-item"><a class="nav-link{{ $page === '' ? ' active' : '' }}" href="{{ route('admin.home') }}">Dashboard</a></li>
    @endcan
    @can ('manage-vacancies')
        <li class="nav-item"><a class="nav-link{{ $page === 'vacancies' ? ' active' : '' }}" href="{{ route('admin.vacancies.index') }}">Vacancies</a></li>
    @endcan
    @can ('manage-users')
        <li class="nav-item"><a class="nav-link{{ $page === 'users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
    @endcan
</ul>