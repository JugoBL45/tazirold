@extends('layout.main')

@section('title', 'Santri')
@section('subtitle', 'Daftar Santri')

@section('kont')
    <div class="card">
        <div class="card-header bd-secondary">
            <h3 class="card-title">Daftar Santri</h3>
            <button class="btn btn-success float-right animated-btn" data-toggle="modal" data-target="#addSantriModal" id="createSantriBtn">Tambah Santri</button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="santriTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Wali Santri</th>
                        <th>No Wali</th>
                        <th>Foto</th>
                        <th width="115px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($santris as $santri)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $santri->nis }}</td>
                            <td>{{ $santri->nama }}</td>
                            <td>{{ $santri->kelas->nama_kelas }}</td>
                            <td>{{ $santri->alamat }}</td>
                            <td>{{ $santri->walisantri }}</td>
                            <td>{{ $santri->no_wali }}</td>
                            <td><img src="{{ url('images/' . $santri->foto) }}" alt="{{ $santri->nama }}" width="50"></td>
                            <td>
                                <a href="{{ route('santri.profil', $santri->id_santri) }}" class="btn btn-info animated-btn viewSantriBtn">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->role == 1)
                                <button class="btn btn-warning animated-btn editSantriBtn" data-id="{{ $santri->id_santri }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                                <form action="{{ route('santri.destroy', $santri->id_santri) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger animated-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Santri Modal -->
    <div class="modal fade" id="addSantriModal" tabindex="-1" role="dialog" aria-labelledby="addSantriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSantriModalLabel">Tambah Santri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="santriForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="walisantri">Wali Santri</label>
                            <input type="text" class="form-control" id="walisantri" name="walisantri" required>
                        </div>
                        <div class="form-group">
                            <label for="no_wali">No Wali</label>
                            <input type="text" class="form-control" id="no_wali" name="no_wali" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-success animated-btn" id="saveSantriBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Santri Modal -->
    <div class="modal fade" id="editSantriModal" tabindex="-1" role="dialog" aria-labelledby="editSantriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSantriModalLabel">Edit Santri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editSantriForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="santri_id" name="santri_id">
                        <div class="form-group">
                            <label for="edit_nis">NIS</label>
                            <input type="text" class="form-control" id="edit_nis" name="nis" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kelas_id">Kelas</label>
                            <select class="form-control" id="edit_kelas_id" name="kelas_id" required>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_alamat">Alamat</label>
                            <textarea class="form-control" id="edit_alamat" name="alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_walisantri">Wali Santri</label>
                            <input type="text" class="form-control" id="edit_walisantri" name="walisantri" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_no_wali">No Wali</label>
                            <input type="text" class="form-control" id="edit_no_wali" name="no_wali" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_foto">Foto</label>
                            <input type="file" class="form-control" id="edit_foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-success animated-btn" id="updateSantriBtn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     
@endsection

@push('js')
   <!-- Select2 -->
   <script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>
   <!-- DataTables (if used) -->
   <script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
   <!-- Animasi -->
   <style>
       .animated-btn {
           transition: transform 0.2s, background-color 0.2s;
       }
       .animated-btn:hover {
           transform: scale(1.1);
           background-color: #28a745 !important;
       }
   </style>
   <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#santriTable').DataTable();

            // Initialize modal for create
            $('#createSantriBtn').on('click', function() {
                $('#addSantriModal').modal('show');
                $('#addSantriModalLabel').text('Tambah Santri');
                $('#santriForm').trigger('reset');
                $('#santri_id').val('');
                $('#santriForm').find('[name="_method"]').remove(); // Remove the _method input for POST
            });

            // Initialize modal for edit
            $('.editSantriBtn').on('click', function() {
                var id = $(this).data('id');
                $.get('{{ route('santri.index') }}/' + id + '/edit', function(data) {
                    $('#editSantriModal').modal('show');
                    $('#editSantriModalLabel').text('Edit Santri');
                    $('#editSantriForm').attr('action', '{{ route('santri.index') }}/' + id);
                    $('#editSantriForm').find('[name="_method"]').remove(); // Remove existing _method input if any
                    $('#editSantriForm').prepend('<input type="hidden" name="_method" value="PUT">'); // Add _method input for PUT
                    $('#santri_id').val(data.id_santri);
                    $('#edit_nis').val(data.nis);
                    $('#edit_nama').val(data.nama);
                    $('#edit_kelas_id').val(data.kelas_id);
                    $('#edit_alamat').val(data.alamat);
                    $('#edit_walisantri').val(data.walisantri);
                    $('#edit_no_wali').val(data.no_wali);
                });
            });

            // Handle form submission for add
            $('#santriForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('santri.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addSantriModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Handle form submission for edit
            $('#editSantriForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#santri_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '{{ route('santri.index') }}/' + id,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#editSantriModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Handle view button click
            $('.viewSantriBtn').on('click', function() {
                var id = $(this).data('id');
                $.get('{{ route('santri.show', '') }}/' + id, function(data) {
                    $('#viewSantriModal').modal('show');
                    $('#view_nis').text(data.nis);
                    $('#view_nama').text(data.nama);
                    $('#view_kelas').text(data.kelas.nama_kelas);
                    $('#view_alamat').text(data.alamat);
                    $('#view_walisantri').text(data.walisantri);
                    $('#view_no_wali').text(data.no_wali);
                    $('#view_foto').attr('src', '{{ url('images') }}/' + data.foto);
                });
            });
       
        });
       
        
    </script>
@endpush