@extends('layouts.admin')


@section('title', 'Ticket Setting')

@php
  $breadcrumbItems = [
    ['label' => 'Users', 'url' => route('admin.user.index')],
    ['label' => 'Settings']
  ];
@endphp
@section('content')
 @include('includes.notification')
<h1 class="mb-4">Ticket Settings</h1>
<button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#exampleModalForm">
                Tambah Ticket
              </button>
            
          <!-- Form Modal -->
          <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalFormTitle">Tambah Ticket</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.ticket.settings.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="total_tickets" class="form-label">Total Tiket</label>
                            <input type="number" class="form-control" id="total_tickets" name="total_tickets" required>
                        </div>

                        <div class="mb-3">
                            <label for="use_grouping" class="form-label">Gunakan Grup?</label>
                            <select class="form-select" id="use_grouping" name="use_grouping" onchange="toggleGroupSection()" required>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div id="group_section" style="display: none;">
                            <div class="mb-3">
                                <label for="group_count" class="form-label">Jumlah Grup</label>
                                <input type="number" class="form-control" id="group_count" name="group_count" min="1" onchange="generateGroupInputs()">
                            </div>

                            <div id="group_inputs"></div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                    <script>
function toggleGroupSection() {
    const val = document.getElementById('use_grouping').value;
    const section = document.getElementById('group_section');
    section.style.display = val == "1" ? 'block' : 'none';
    document.getElementById('group_inputs').innerHTML = '';
    document.getElementById('group_count').value = '';
}

function generateGroupInputs() {
    const count = parseInt(document.getElementById('group_count').value);
    const container = document.getElementById('group_inputs');
    container.innerHTML = '';

    for (let i = 0; i < count; i++) {
        container.innerHTML += `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Grup ${i + 1}</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Grup</label>
                        <input type="text" class="form-control" name="groups[${i}][group_name]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Kursi</label>
                        <input type="number" class="form-control" name="groups[${i}][quota]" min="1" required>
                    </div>
                </div>
            </div>
        `;
    }
}
</script>
                </div>
               
              </div>
            </div>
          </div>
    
    @foreach ($settings as $setting)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Setting ID: {{ $setting->id }}</strong>
                <span class="badge bg-{{ $setting->use_grouping ? 'success' : 'secondary' }}">
                    {{ $setting->use_grouping ? 'Gunakan Grup' : 'Tanpa Grup' }}
                </span>
            </div>

            <div class="card-body">
                <p><strong>Total Tiket:</strong> {{ $setting->total_tickets }}</p>
                @if ($setting->use_grouping)
                    <p><strong>Jumlah Grup:</strong> {{ $setting->groups->count() }}</p>
                   

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Group Name</th>
                                    <th>Group Code</th>
                                    <th>Quota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($setting->groups as $index => $group)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $group->group_name }}</td>
                                        <td><code>{{ $group->group_code }}</code></td>
                                        <td>{{ $group->quota }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-center">
                                         <p><strong>Total :</strong> </p>
                                    </td>
                                    <td >
                                        {{ $setting->groups->sum('quota') }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Tidak menggunakan pembagian grup.</p>
                @endif
            </div>
            <form action="{{ route('admin.ticket.settings.delete', $setting->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>

        </div>
    @endforeach

    
@endsection
