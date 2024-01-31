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
            {{-- <div class="form-group row">
                <div class="col-9">
                    <button type="submit" class="btn btn-primary" id="pinjamBukuBtn" data-bs-toggle="modal"
                        data-bs-target="#pinjamBukuModal">Pinjam Buku</button>
                </div>

            </div> --}}
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="font-weight-bold text-primary">KOLEKSI BUKU</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="primary_table">
                        <thead class="thead-light">
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">No
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">Nama Buku
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">Author
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">Deskripsi
                                </th>
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">Aksi
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

    {{-- Detail Modal Buku --}}
    <div class="modal fade" id="detailBuku" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/koleksi" method="POST" id="pinjamBukuForm" name="pinjamBukuForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Nama Buku</label>
                                    <div class="col-9">
                                        <input style="width: 100%;" class="form-control" id="nama_buku" name="nama_buku"
                                            type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Author</label>
                                    <div class="col-9">
                                        <input style="width: 100%;" class="form-control" id="author" name="author"
                                            type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Deskripsi</label>
                                    <div class="col-9">
                                        <input style="width: 100%;" class="form-control" id="deskripsi" name="deskripsi"
                                            type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <input type="hidden" class="form-control" id="user_id" name="user_id" required>
                    <input type="hidden" class="form-control" id="user_id" name="buku_id" required>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="pinjamBukuBtn" class="btn btn-primary">Pinjam</button>
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
                    ajax: "/xt/koleksi",
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
                            data: 'deskripsi',
                            name: 'deskripsi'
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

                $('body').on('click', '.pinjamBuku', function() {
                    var id = $(this).data('id');
                    $.get("/xt/koleksi/" + id, function(data) {
                        $('#detailBuku').modal('show');
                        $('#id').val(data.id);
                        $('#nama_buku').val(data.nama_buku);
                        $('#author').val(data.author);
                        $('#deskripsi').val(data.deskripsi);
                    })
                });

                $('#pinjamBukuForm').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "/xt/koleksi",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            if (data.status === 201) {
                                $("#detailBuku").modal('hide');
                                $("#errors").removeClass('d-none');
                                $("#errors").text(data.message);
                                $("#pinjamBukuBtn").html('Simpan');
                                $("#pinjamBukuBtn").attr("disabled", false);
                                $("#logoutBtn").html('Simpan');
                                $("#logoutBtn").attr("disabled", false);
                            } else {
                                $("#editBukuModal").modal('hide');
                                $("#success").removeClass('d-none');
                                $("#success").text(data.success);
                                var oTable = $('#primary_table').dataTable();
                                oTable.fnDraw(false);
                                $("#pinjamBukuBtn").html('Simpan');
                                $("#pinjamBukuBtn").attr("disabled", false);
                                $("#logoutBtn").html('Simpan');
                                $("#logoutBtn").attr("disabled", false);
                            }
                        }
                    });
                });

            });


            // var spinner =
            //     '<div style="height:20px; width: 20px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>  Please Wait'
            // $(document).on("submit", 'form', function() {
            //     $('#simpanBukuBtn').html(spinner);
            //     $('#simpanBukuBtn').attr('disabled', 'disabled');
            //     $('#editBukuBtn').html(spinner);
            //     $('#editBukuBtn').attr('disabled', 'disabled');
            // });
        </script>
    @endpush
@endsection
