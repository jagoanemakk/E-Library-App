        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-solid fa-bars"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                    SB Admin
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Interface</div>
            {{-- @dd(Auth::user()->hak_akses) --}}
            @if(Auth::user()->hak_akses == 'Member')
            <li class="nav-item">
                    <a class="nav-link" href="/pinjam-buku">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Pinjam Buku</span></a>
                </li>
            @elseif (Auth::user()->hak_akses == 'Super Admin')
                <!-- Nav Item - Manajemen Buku -->
                <li class="nav-item">
                    <a class="nav-link" href="/manajemen-buku">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Manajemen Buku</span></a>
                </li>

                <!-- Nav Item - Peminjaman -->
                <li class="nav-item">
                    <a class="nav-link" href="/peminjaman">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Peminjaman</span></a>
                </li>

                <!-- Nav Item - Denda -->
                <li class="nav-item">
                    <a class="nav-link" href="tables.html">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Denda</span></a>
                </li>

                <!-- Nav Item - Admin -->
                <li class="nav-item">
                    <a class="nav-link" href="/add-admin">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Admin</span></a>
                </li>
            @else
                <!-- Nav Item - Manajemen Buku -->
                <li class="nav-item">
                    <a class="nav-link" href="/manajemen-buku">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Manajemen Buku</span></a>
                </li>

                <!-- Nav Item - Peminjaman -->
                <li class="nav-item">
                    <a class="nav-link" href="/peminjaman">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Peminjaman</span></a>
                </li>

                <!-- Nav Item - Denda -->
                <li class="nav-item">
                    <a class="nav-link" href="tables.html">
                        <i class="fas fa-solid fa-book"></i>
                        <span>Denda</span></a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
