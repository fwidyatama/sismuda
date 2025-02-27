<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">SISMUDA </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      @if (Auth::user()->id_role == 1)
        <li class="nav-item @if ($activePage == 'user') active @endif" >
          <a class="nav-link" href="{{route('user.showofficerlist')}}">
            <i class="fas fa-users"></i>
            <span>Karyawan</span></a>
        </li>
        <li class="nav-item @if ($activePage == 'bus') active @endif" >
          <a class="nav-link" href="{{route('bus.showbuslist')}}">
            <i class="fas fa-bus-alt"></i>
            <span>Bus</span></a>
        </li>
       
        <li class="nav-item @if ($activePage == 'workshop') active @endif" >
          <a class="nav-link" href="{{route('workshop.showworkshop')}}">
            <i class="fas fa-sticky-note"></i>
            <span>Surat Tugas</span></a>
        </li>
        <li class="nav-item @if ($activePage == 'order') active @endif" >
          <a class="nav-link" href="{{route('order.showlist')}}">
            <i class="fas fa-users-cog"></i>
            <span>Pengajuan Sparepart</span></a>
        </li>
        <li class="nav-item @if ($activePage == 'permits') active @endif" >
          <a class="nav-link" href="{{route('permits.showlist')}}">
            <i class="fas fa-bus"></i>
            <span>Keluar Kendaraan</span></a>
        </li>
        <li class="nav-item @if ($activePage == 'buscheck') active @endif" >
          <a class="nav-link" href="{{route('buscheck.show')}}">
            <i class="fas fa-sticky-note"></i>
            <span>Pengecekan Bus</span></a>
        </li>
      
      
      
      
      @elseif (Auth::user()->id_role == 2)
      <li class="nav-item @if ($activePage == 'workshop') active @endif" >
        <a class="nav-link" href="{{route('workshop.historyworkshop')}}">
          <i class="fas fa-users"></i>
          <span>Surat Tugas</span></a>
      </li>
      <li class="nav-item @if ($activePage == 'buspermit') active @endif" >
        <a class="nav-link" href="{{route('permits.request')}}">
          <i class="fas fa-users"></i>
          <span>Kendaraan</span></a>
      </li>
      <li class="nav-item @if ($activePage == 'sparepartorder') active @endif" >
        <a class="nav-link" href="{{route('order.addorder')}}">
          <i class="fas fa-users"></i>
          <span>Pengajuan Sparepart</span></a>
      </li>


      @elseif(Auth::user()->id_role==3)
      <li class="nav-item @if ($activePage == 'sparepart') active @endif" >
        <a class="nav-link" href="{{route('sparepart.showsparepartlist')}}">
          <i class="fas fa-tools"></i>
          <span>Sparepart</span></a>
      </li>
      <li class="nav-item @if ($activePage == 'mutation') active @endif" >
        <a class="nav-link" href="{{route('mutation.show')}}">
          <i class="fas fa-tools"></i>
          <span>Mutasi Sparepart</span></a>
      </li>
      <li class="nav-item @if ($activePage == 'sparepartverif') active @endif" >
        <a class="nav-link" href="{{route('sparepart.accepted')}}">
          <i class="fas fa-tools"></i>
          <span>Sparepart Terverifikasi</span></a>
      </li>
      @elseif(Auth::user()->id_role==4)
      <li class="nav-item @if ($activePage == 'buscheck') active @endif" >
        <a class="nav-link" href="{{route('buscheck.requestcheck')}}">
          <i class="fas fa-bus"></i>
          <span>Pengecekan Bus</span></a>
      </li>

      
      @endif
   


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
         
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="mr-2">
                  <i class=" fas fa-user"></i>
                  </div>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                {{-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> --}}
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('profile',Auth::user()->id)}}">
                  Profil
                </a>
               
                <div class="dropdown-divider"></div>
             
                <button class="dropdown-item ">
                
                  <form action="{{route("logout")}}" method="POST">
                      @csrf
                      <button class="dropdown-item" style="cursor:pointer">Log out</button>
                    </form>
              </button>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
         
          <!-- Content Row -->
         @yield('content')
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Sismuda</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
   <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>


  <script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  
  @stack('scripts')
</body>

</html>
