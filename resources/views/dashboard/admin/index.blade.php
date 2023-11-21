@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible fade show d-none" id="success" role="alert">
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger alert-dismissible fade-show d-none" id="errors" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="font-weight-bold text-primary">Kelola Admin</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="/add-admin" method="post" id="inputAdminForm">
                                @csrf
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Username</label>
                                    <div class="col-9">
                                        <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                            id="nama" name="nama" placeholder="Masukkan Username..." required=""
                                            value="{{ old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Email</label>
                                    <div class="col-9">
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            id="email" name="email" placeholder="Masukkan Email..." required=""
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Password</label>
                                    <div class="col-9">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                                            id="password" name="password" placeholder="Masukkan Password..."
                                            required="">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            id="simpanAdminBtn">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="primary_table">
                        <thead class="thead-light">
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">No
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">Nama
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">Email
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">Hak
                                    Akses
                                </th>
                                <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                    style="width: 158.5px;">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Edit Modal --}}
            <div class="modal fade" id="editAdminModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/add-admin" method="POST" id="editAdminForm" name="editAdminForm">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label for="example-text-input-small"
                                                class="col-3 col-form-label">Username</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="edit_nama" name="nama"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input-small"
                                                class="col-3 col-form-label">Email</label>
                                            <div class="col-9">
                                                <input type="email" class="form-control" id="edit_email"
                                                    name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input-small" class="col-3 col-form-label">Hak
                                                Akses</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="edit_hak_akses"
                                                    name="hak_akses" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="id" name="id" required>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" id="editAdminBtn" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#primary_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/dt/add-admin",
                    columns: [{
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'hak_akses',
                            name: 'hak_akses'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],
                    order: [
                        [0, 'asc']
                    ]
                });

                $('body').on('click', '.editAdminPost', function() {
                    var id = $(this).data('id');
                    $.get("/dt/add-admin" + '/' + id, function(data) {
                        $('#editAdminModal').modal('show');
                        $('#id').val(data.id);
                        $('#edit_nama').val(data.nama);
                        $('#edit_email').val(data.email);
                        $('#edit_hak_akses').val(data.hak_akses);
                    })
                });

                $('#editAdminForm').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "/dt/add-admin",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            if (data.status === 201) {
                                $("#editAdminModal").modal('hide');
                                $("#errors").removeClass('d-none');
                                $("#errors").text(data.message);
                                $("#simpanAdminBtn").html('Simpan');
                                $("#simpanAdminBtn").attr("disabled", false);
                                $("#editAdminBtn").html('Simpan');
                                $("#editAdminBtn").attr("disabled", false);
                                $("#logoutBtn").html('Simpan');
                                $("#logoutBtn").attr("disabled", false);
                            } else {
                                $("#editAdminModal").modal('hide');
                                $("#success").removeClass('d-none');
                                $("#success").text(data.success);
                                var oTable = $('#primary_table').dataTable();
                                oTable.fnDraw(false);
                                $("#simpanAdminBtn").html('Simpan');
                                $("#simpanAdminBtn").attr("disabled", false);
                                $("#editAdminBtn").html('Simpan');
                                $("#editAdminBtn").attr("disabled", false);
                                $("#logoutBtn").html('Simpan');
                                $("#logoutBtn").attr("disabled", false);
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });


                $(document).on('click', '.deleteAdminPost', function(e) {
                    var id = $(this).data('id');
                    SwalDelete(id);
                    e.preventDefault();
                });

                function SwalDelete(id) {
                    Swal.fire({
                        title: 'Apakah anda ingin menghapus data?',
                        type: 'warning',
                        showDenyButton: true,
                        confirmButtonText: "Hapus",
                        denyButtonText: `Batal`,
                        allowOutsideClick: true,

                        preConfirm: function() {
                            return new Promise(function(resolve) {
                                $.ajax({
                                        type: "DELETE",
                                        url: "/dt/add-admin" + '/' + id,
                                    })
                                    .done(function(response) {
                                        Swal.fire('Data berhasil dihapus!', response.message,
                                            response.status);
                                        var oTable = $('#primary_table').dataTable();
                                        oTable.fnDraw(false);
                                        $("#simpanAdminBtn").html('Simpan');
                                        $("#simpanAdminBtn").attr("disabled", false);
                                    })
                                    .fail(function(response) {
                                        Swal.fire('Oops...', 'Ada yang salah nih !',
                                            'error');
                                        // alert(response.error);
                                    });
                            });
                        },

                    });

                }

            });
            var spinner =
                '<div style="height:20px; width: 20px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>  Please Wait'
            $('body').on("submit", 'form', function() {
                $('#simpanAdminBtn').html(spinner);
                $('#simpanAdminBtn').attr('disabled', 'disabled');
                $('#editAdminBtn').html(spinner);
                $('#editAdminBtn').attr('disabled', 'disabled');
                // $('#deleteAdminBtn').html(spinner);
                // $('#deleteAdminBtn').attr('disabled', 'disabled');
            });
        </script>
    @endpush
@endsection
