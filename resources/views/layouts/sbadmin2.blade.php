<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('custom-style') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('custom-style') }}/css/sb-admin-2.css" rel="stylesheet">
    <link href="{{ asset('custom-style') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/custom-style-v2/assets/img/logo.png" rel="icon">

    <style>
        .sidebar {
            background: linear-gradient(45deg, #2d8ffd, #224abe);
        }

        .nav-item .nav-link {
            color: #fff;
            transition: all 0.3s;
        }

        .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .sidebar-brand-icon img {
            background-color: transparent;
            border-radius: 50%;
            padding: 5px;
        }

        .sidebar .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #fff;
        }

        .sidebar-brand-text {
            color: #fff;
            font-weight: bold;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="/custom-style-v2/assets/img/logo.png" width="30" height="30"
                        class="d-inline-block align-top" alt="">
                </div>

                @if (auth()->user()->role == 'admin')
                    <div class="sidebar-brand-text mx-1">Admin</div>
                @elseif (auth()->user()->role == 'pengepul')
                    <div class="sidebar-brand-text mx-1">Pengepul</div>
                @elseif (auth()->user()->role == 'nasabah')
                    <div class="sidebar-brand-text mx-1">Nasabah</div>
                @endif
            </a>

            <hr class="sidebar-divider my-0">


            @if (auth()->user()->role == 'admin')
                <li class="nav-item {{ Route::is('home*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item {{ Route::is('user.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/user">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data User</span></a>
                </li>
                <li class="nav-item {{ Route::is('nasabah.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/nasabah">
                        <i class="fas fa-fw fa-user-friends"></i>
                        <span>Data Nasabah</span></a>
                </li>
                <li class="nav-item {{ Route::is('pengepul.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/pengepul">
                        <i class="fas fa-fw fa-user-tie"></i>
                        <span>Data Pengepul</span></a>
                </li>
                <li class="nav-item {{ Route::is('transaksi.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/transaksi">
                        <i class="fas fa-fw fa-exchange-alt"></i>
                        <span>Data Transaksi</span></a>
                </li>
                <li class="nav-item {{ Route::is('penyetoran.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/penyetoran">
                        <i class="fas fa-fw fa-donate"></i>
                        <span>Penyetoran Sampah</span></a>
                </li>
                <li class="nav-item {{ Route::is('sampah.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/sampah">
                        <i class="fas fa-fw fa-trash"></i>
                        <span>Data Sampah</span></a>
                </li>
                <li class="nav-item {{ Route::is('penjualan.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/penjualan">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span>Penjualan Sampah</span></a>
                </li>
                <li class="nav-item {{ Route::is('penarikan.approval') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('penarikan.approval') }}">
                        <i class="fas fa-fw fa-check-circle"></i>
                        <span>Daftar Penarikan</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('pengepul.topups') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pengepul.topups') }}">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Daftar Top Up</span>
                    </a>
                </li>
            @elseif (auth()->user()->role == 'pengepul')
                <li class="nav-item {{ Route::is('pembelian.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/pembelian">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span>Pembelian Sampah</span></a>
                </li>
                <li class="nav-item {{ Route::is('transaksi.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/transaksi">
                        <i class="fas fa-fw fa-exchange-alt"></i>
                        <span>Data Transaksi</span></a>
                </li>
                <li class="nav-item {{ Route::is('pengepul.topup.form') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ route('pengepul.topup.form', ['id' => auth()->user()->pengepul->id]) }}">
                        <i class="fas fa-fw fa-plus-circle"></i>
                        <span>Top Up Saldo</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('pengepul.riwayatTopup') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ route('pengepul.riwayatTopup', ['id' => auth()->user()->pengepul->id]) }}">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Topup</span>
                    </a>
                </li>
            @elseif (auth()->user()->role == 'nasabah')
                <li class="nav-item {{ Route::is('penyetoran.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/penyetoran">
                        <i class="fas fa-fw fa-donate"></i>
                        <span>Penyetoran Sampah</span></a>
                </li>
                <li class="nav-item {{ Route::is('transaksi.index') ? 'active' : '' }} ">
                    <a class="nav-link" href="/transaksi">
                        <i class="fas fa-fw fa-exchange-alt"></i>
                        <span>Data Transaksi</span></a>
                </li>
                <li class="nav-item {{ Route::is('nasabah.saldo') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('nasabah.saldo', ['id' => auth()->user()->nasabah->id]) }}">
                        <i class="fas fa-fw fa-wallet"></i>
                        <span>Rincian Saldo</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('nasabah.riwayatPenarikan') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ route('nasabah.riwayatPenarikan', ['id' => auth()->user()->nasabah->id]) }}">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Penarikan</span>
                    </a>
                </li>
            @endif


            <hr class="sidebar-divider">



            <div class="sidebar-heading">
                Profil
            </div>

            <li class="nav-item {{ Route::is('profil.*') ? 'active' : '' }} ">
                <a class="nav-link" href="/profil/create">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Profil</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>




        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (auth()->user()->role == 'pengepul')
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Saldo:
                                        {{ number_format(auth()->user()->pengepul->saldo, 0, ',', '.') }}</span>
                                @elseif (auth()->user()->role == 'nasabah')
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Saldo:
                                        {{ number_format(auth()->user()->nasabah->saldo, 0, ',', '.') }}</span>
                                @elseif (auth()->user()->role == 'admin')
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Saldo:
                                        {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</span>
                                @endif
                                <div class="topbar-divider d-none d-sm-block"></div>
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <div class="topbar-divider d-none d-sm-block"></div>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('custom-style/img/undraw_profile.svg') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/profil/create">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>


                </nav>
                <div class="container-fluid">

                    @include('flash::message')

                    @yield('content')

                </div>

            </div>


            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Bank Sampah Suka Bestari</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('custom-style') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('custom-style') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('custom-style') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="{{ asset('custom-style') }}/js/sb-admin-2.min.js"></script>
    <script src="{{ asset('custom-style') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('custom-style') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    @yield('script')
</body>

</html>
