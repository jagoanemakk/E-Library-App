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
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="font-weight-bold text-primary">Manajemen Buku</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="/manajemen-buku" method="post" id="inputBukuForm">
                                @csrf
                                <div class="form-group row">
                                    <input type="hidden" id="user_id" name="user_id" required>
                                    <label for="example-text-input-small" class="col-3 col-form-label">Nama Buku</label>
                                    <div class="col-9">
                                        <input class="form-control @error('nama_buku') is-invalid @enderror" type="text"
                                            id="nama_buku" name="nama_buku" placeholder="Masukkan nama buku..."
                                            required="" value="{{ old('nama_buku') }}">
                                        @error('nama_buku')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Author</label>
                                    <div class="col-9">
                                        <input class="form-control @error('author') is-invalid @enderror" type="text"
                                            id="author" name="author" placeholder="Masukkan nama author..."
                                            required="" value="{{ old('author') }}">
                                        @error('author')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3"></div>
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            id="simpanBukuBtn">Simpan</button>
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
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">Nama Buku
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 158.5px;">Author
                                </th>
                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 158.5px;">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editBukuModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/manajemen-buku" method="POST" id="editBukuForm" name="editBukuForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Nama Buku</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="edit_nama_buku" name="nama_buku"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Author</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="edit_author" name="author"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <input type="hidden" class="form-control" id="user_id" name="user_id" required>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="editBukuBtn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                    ajax: "/dx/manajemen-buku",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama_buku',
                            name: 'nama_buku'
                        },
                        {
                            data: 'author',
                            name: 'author'
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

                $('body').on('click', '.editBukuPost', function() {
                    var id = $(this).data('id');
                    $.get("/dx/manajemen-buku" + '/' + id, function(data) {
                        $('#editBukuModal').modal('show');
                        $('#id').val(data.id);
                        $('#edit_nama_buku').val(data.nama_buku);
                        $('#edit_author').val(data.author);
                    })
                });

                $('#editBukuForm').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "/dx/manajemen-buku",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            if (data.status === 201) {
                                $("#editBukuModal").modal('hide');
                                $("#errors").removeClass('d-none');
                                $("#errors").text(data.message);
                                $("#editBukuBtn").html('Simpan');
                                $("#editBukuBtn").attr("disabled", false);
                            } else {
                                $("#editBukuModal").modal('hide');
                                $("#success").removeClass('d-none');
                                $("#success").text(data.success);
                                var oTable = $('#primary_table').dataTable();
                                oTable.fnDraw(false);
                                $("#simpanBukuBtn").html('Simpan');
                                $("#simpanBukuBtn").attr("disabled", false);
                                $("#editBukuBtn").html('Simpan');
                                $("#editBukuBtn").attr("disabled", false);
                                $("#logoutBtn").html('Simpan');
                                $("#logoutBtn").attr("disabled", false);
                            }
                        },
                        error: function(data) {
                            alert('error');
                            console.log(data);
                        }
                    });
                });

                $(document).on('click', '.deleteBukuPost', function(e) {
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
                                        url: "/dx/manajemen-buku" + '/' + id,
                                    })
                                    .done(function(response) {
                                        swal.fire('Data berhasil dihapus!', response.message,
                                            response.status);
                                        // readProducts();
                                        var oTable = $('#primary_table').dataTable();
                                        oTable.fnDraw(false);
                                        $("#simpanBukuBtn").html('Simpan');
                                        $("#simpanBukuBtn").attr("disabled", false);
                                    })
                                    .fail(function() {
                                        swal.fire('Oops...', 'Ada yang salah nih !',
                                            'error');
                                    });
                            });
                        },

                    });

                }

            });

            var spinner =
                '<div style="height:20px; width: 20px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>  Please Wait'
            $(document).on("submit", 'form', function() {
                $('#simpanBukuBtn').html(spinner);
                $('#simpanBukuBtn').attr('disabled', 'disabled');
                $('#editBukuBtn').html(spinner);
                $('#editBukuBtn').attr('disabled', 'disabled');
            });
        </script>
    @endpush
@endsection
