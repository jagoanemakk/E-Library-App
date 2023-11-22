@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- <div class="alert alert-success alert-dismissible fade show d-none" id="success" role="alert">
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
            @endif --}}
            <div class="form-group row">
                <div class="col-9">
                    <button type="submit" class="btn btn-primary" id="pinjamBukuBtn" data-bs-toggle="modal"
                        data-bs-target="#pinjamBukuModal">Pinjam Buku</button>
                </div>

            </div>
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
                                    aria-label="Name: activate to sort column descending" style="width: 150.5px;">Status
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
    <div class="modal fade" id="pinjamBukuModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/koleksi" method="POST" id="pinjamBukuForm" name="pinjamBukuForm">
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
                                        <select style="width: 100%;" class="js-example-basic-single" id="nama_buku"
                                            name="nama_buku">
                                            @foreach ($data as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama_buku }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Tgl Pinjam</label>
                                    <div class="col-9">
                                        <input style="width: 100%;" class="datepicker begin" id="tanggal_pinjam"
                                            type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input-small" class="col-3 col-form-label">Tgl Kembali</label>
                                    <div class="col-9">
                                        <input style="width: 100%;" class="datepicker end" id="tanggal_pinjam"
                                            type="text" />
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
                            data: 'status_buku',
                            name: 'status_buku'
                        },
                    ],
                    order: [
                        [0, 'asc']
                    ]
                });

                $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });

                $("#tanggal_pinjam").datepicker({
                    dateFormat: 'dd/mm/yy'
                }).on("changeDate", function(e) {
                    alert("Working");
                });


                // $("#tanggal_pinjam").datepicker({
                //     autoHide: true,
                //     zIndex: 2048,
                //     startDate: '-0d',
                //     format: 'dd/mm/yyyy',
                // });

                // $('body').on('click', '#pinjamBukuBtn', function() {
                //     $('#pinjamBukuModal').modal('show');
                //     $(".datepicker.begin").datepicker({
                //         onSelect: function(dateText, inst) {
                //             alert('ok');
                //             // Resolve the current date
                //             // var begin = new Date(this);
                //             // var d = begin.getDate();
                //             // var m = begin.getMonth();
                //             // var y = begin.getFullYear();
                //             // // Update your target date
                //             // $(".datepicker.end").datepicker('setDate', new Date(y, m,
                //             //     d + 2));
                //             // $(".datepicker.end").datepicker("option", "onSelect", begin);

                //         },
                //         autoHide: true,
                //         zIndex: 2048,
                //         minDate: '+2d',
                //         maxDate: '+2y',
                //     });

                //     $(".datepicker.end").datepicker({
                //         minDate: '+4d',
                //         maxDate: '+2y',
                //         autoHide: true,
                //         zIndex: 2048,
                //     });
                // });

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
