{{-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar scroll</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            @if (auth()->user()->profil->libelle == 'superadmin')
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('supadmin.user')}}">Home</a>
                </li>
            @else
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('admin.dashboard')}}">Home</a>
            </li>
            @endif

            @if (auth()->user()->profil->libelle == 'superadmin' || auth()->user()->profil->libelle == 'admin')
                @if (auth()->user()->profil->libelle == 'superadmin')
                    <li class="nav-item">
                        <a class="nav-link"  href="{{route('supadmin.profil')}}">Profil</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('user.cour')}}">cour</a>
                </li>
                @if (auth()->user()->profil->libelle == 'admin')
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin.etudiant')}}">etudiant</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin.filiere')}}">filiere</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin.planing')}}">planing</a>
                </li>
            @endif

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Link
            </a>
            <ul class="dropdown-menu">
            @if (auth()->user()->profil->libelle == 'supadimin')
              <li><a class="dropdown-item" href="{{route('supadmin.profil')}}">Profil</a></li>
            @endif
              <li><a class="dropdown-item" href="{{route('user.cour')}}">cour</a></li>
              <li><a class="dropdown-item" href="{{route('admin.filiere')}}">filiere</a></li>
              <li><a class="dropdown-item" href="{{route('admin.planing')}}">planing</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{route('admin.filiere')}}">Something else here</a></li>
              <li><a class="dropdown-item" href="{{route('admin.planing')}}">Something else here</a></li>
            </ul>
          </li>
           <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Link</a>
          </li>
        </ul>
        <div class="text-right">
            <a class="d-flex btn btn-outline-danger justify-content-end" href="{{route('user.logout')}}">Deconnexion</a>
        </div>
      </div>
    </div>
    {{ auth()->user()->profil->libelle }}
    {{ auth()->user()->enseignants_id }}
  </nav> --}}


<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./index.html" class="brand-link"> <!--begin::Brand Image--> <img src="../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-light">AdminLTE 4</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open"> <a href="#" class="nav-link active"> <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->profil->libelle == 'superadmin')
                        <li class="nav-item"> <a href="{{route('supadmin.user')}}" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @elseif (auth()->user()->profil->libelle == 'admin')
                        <li class="nav-item"> <a href="{{route('admin.dashboard')}}" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                        @endif

                    </ul>
                </li>

                @if (auth()->user()->profil->libelle == 'superadmin' || auth()->user()->profil->libelle == 'admin')
                    @if (auth()->user()->profil->libelle == 'superdmin')
                        <li class="nav-item"> <a href="{{route('supadmin.profil')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                                <p>Profil</p>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->profil->libelle == 'superdmin')
                        <li class="nav-item"> <a href="{{route('admin.etudiant')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                                <p>Etudiant</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item"> <a href="{{route('user.cour')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                            <p>Cour</p>
                        </a>
                    </li>
                    <li class="nav-item"> <a href="{{route('admin.filiere')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                            <p>Filiere</p>
                        </a>
                    </li>
                    <li class="nav-item"> <a href="{{route('admin.planing')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                            <p>Planing</p>
                        </a>
                    </li>
                    <li class="nav-item"> <a href="{{route('admin.Bulletin')}}" class="nav-link"> <i class="nav-icon bi bi-palette"></i>
                            <p>Gestion de bulletin</p>
                        </a>
                    </li>
                @endif
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
