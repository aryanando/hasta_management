@extends('karu.layout.layout')

@section('content')
    {{-- @dd($user_data) --}}
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Shift Karyawan</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <hr />
    <div class="row">
        <div class="col col-12 col-sm-12 col-lg-8 p-2">
            <div class="bg-white p-2 rounded">
                <div class="row">
                    <h3>Shift Unit</h3>
                </div>
                <hr />
                <div class="row">
                    <table id="shiftTable">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Warna</th>
                                <th>Beda Hari</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shift as $shiftData)
                                @if ($shiftData->unit_id == $user_data->unit['0']->id AND $shiftData->deleted_at == NULL)
                                    <tr>
                                        <td>{{ $shiftData->shift_name }}</td>
                                        <td>{{ $shiftData->check_in }}</td>
                                        <td>{{ $shiftData->check_out }}</td>
                                        <td><div class="rounded" style="background-color:{{ $shiftData->color }}; height:20px; width:30px"></div></td>
                                        <td>{{ $shiftData->next_day == 0 ? 'Tidak' : 'Ya' }}</td>
                                        <td>
                                            <button onclick="document.location.href='{{ route('delete_shift', $shiftData->id) }}';" class="btn btn-danger btn-sm rounded" type="button" data-toggle="tooltip"
                                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="col col-12 col-sm-12 col-lg-4 p-2">
            <div class="bg-white p-2 rounded">
                <div class="row">
                    <h3>Buat Shift Baru</h3>
                </div>
                <hr />
                <form action="{{ url('/karu/save-shift') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-12 col-sm-12">
                            <div class="mb-3">
                                <label for="shiftName">
                                    Shift
                                </label>
                                <input class="form-control" id="shiftName" type="text" name="name"
                                    placeholder="Pagi/Siang/Sore/Middle" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="shiftTimeStart">
                                    Jam Masuk
                                </label>
                                <input class="form-control" id="shiftTimeStart" type="time" name="check-in" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="shiftTimeEnd">
                                    Jam Pulang
                                </label>
                                <input class="form-control" id="shiftTimeEnd" type="time" name="check-out" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="shiftNextDay">
                                    Next Day
                                </label>
                                <div class="form-check">
                                    <input type='hidden' value='0' name='next-day'>
                                    <input class="form-check-input" id="shiftNextDay" type="checkbox" value="1"
                                        name="next-day">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="color">
                                    Pilih Warna
                                </label>
                                <input class="form-control" type="color" name="color">
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row justify-content-center px-3">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#shiftTable', {
            responsive: true
        });
    </script>
@endpush
