<div class="sidebar">
    <div class="sidebar-background"></div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">

                    <div class="avatar-sm float-left mr-2">
                        @if ($profile->profile_picture === null)
                        <img src="{{ asset('/template/img/boy.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        @else
                        <img src="{{asset('/images/profile_picture/'.$profile->profile_picture)}}" alt="..." class="avatar-img rounded-circle">
                        @endif
                    </div>

                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }}
                            <span class="user-level">{{$user_position->position_name}}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="/profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                            <a class="link-collapse text-dark" href="{{route('logout')}}" data-toggle="modal" data-target="#logoutModal">Logout
                            </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a href="/home">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
@if (Auth::user()->position->position_name == "Administrator" || Auth::user()->position->position_name == "HR")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#employee">
                    <i class="fa-solid fa-users"></i>
                        <p>Pegawai</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="employee">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/karyawan">
                                    <span class="sub-item">Lihat Semua Pegawai</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
@endif
@if (Auth::user()->position->position_name == "Administrator")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#position">
                    <i class="fa-solid fa-user-tie"></i>
                        <p>Jabatan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="position">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/position">
                                    <span class="sub-item">Lihat Jabatan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#division">
                    <i class="fa-solid fa-users-rectangle"></i>
                        <p>Proyek</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="division">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/proyek">
                                    <span class="sub-item">Lihat Proyek yang ada</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
@endif
@if (Auth::user()->position->position_name == "Administrator")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#salary">
                    <i class="fa-solid fa-money-bill-wave"></i>
                        <p>Keuangan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="salary">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/gajilemburharian">
                                    <span class="sub-item">Data Gaji dan Lemburan Harian</span>
                                </a>
                            </li>
                            <li>
                                <a href="/kasbon">
                                    <span class="sub-item">Kasbon Karyawan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
@endif
@if (Auth::user()->position->position_name == "Administrator" || Auth::user()->position->position_name == "HR")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#schedule">
                    <i class="fa-regular fa-calendar-days"></i>
                        <p>Rekap Kehadiran</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="schedule">
                        <ul class="nav nav-collapse">
                            <li>
                                {{-- <a href="/jadwal">
                                    <span class="sub-item">Shift Karyawan</span>
                                </a>
                            </li>
                            <li>
                                <a href="/libur">
                                    <span class="sub-item">Tambahkan Libur</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="/rekap">
                                    <span class="sub-item">Rekap Gaji Karyawan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
@endif
@if (Auth::user()->position->position_name == "Administrator" || Auth::user()->position->position_name == "Karyawan")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#attendance">
                    <i class="fa-regular fa-calendar"></i>
                        <p>Absensi</p>
                        <span class="caret"></span>
                    </a>
@endif
                    <div class="collapse" id="attendance">
                        <ul class="nav nav-collapse">
@if (Auth::user()->position->position_name == "Administrator")
                            <li>
                                <a href="/absensi">
                                    <span class="sub-item">Daftar Hadir</span>
                                </a>
                            </li>
                            <li>
                                <a href="/kehadiran">
                                    <span class="sub-item">Check Kehadiran Karyawan</span>
                                </a>
                            </li>
@endif
@if (Auth::user()->position->position_name == "Karyawan")
                            <li>
                                <a href="/absenkaryawan">
                                    <span class="sub-item">Isi Daftar Hadir</span>
                                </a>
                            </li>
                            <li>
                                <a href="/absenkaryawan/report">
                                    <span class="sub-item">Riwayat Daftar Hadir</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="/xkehadiran">
                                    <span class="sub-item">Daftar tidak hadir</span>
                                </a>
                            </li> --}}
@endif
                        </ul>
                    </div>
                </li>
@if (Auth::user()->position->position_name == "Administrator" || Auth::user()->position->position_name == "HR")
                <li class="nav-item">
                    <a data-toggle="collapse" href="#tagihan">
                    <i class="fa-regular fa-credit-card-alt"></i>
                        <p>Tagihan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tagihan">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/tagihan">
                                    <span class="sub-item">Tagihan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
@endif
            </ul>
        </div>
    </div>
</div>
