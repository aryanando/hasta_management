@extends('karu.layout.layout')

@section('content')
    @php
        $d = cal_days_in_month(CAL_GREGORIAN, $month, 2024);
    @endphp

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Jadwal Karyawan</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <select class="form-select form-select-sm col-3 mb-3" aria-label=".form-select-sm example" id="selectBox"
        onchange="changeFunc();">
        <option value="1" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
        <option value="2" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
        <option value="3" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
        <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
        <option value="5" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
        <option value="6" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
        <option value="7" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
        <option value="8" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
        <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
        <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
        <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
        <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
    </select>
    <div class="overflow-auto">
        <table class="table">
            <thead>
                <tr>
                    <th style="min-width: 200px">Nama</th>
                    @for ($i = 0; $i < $d; $i++)
                        <th class="text-center" scope="col">{{ $i + 1 }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @php
                    function isColorLightOrDark($color)
                    {
                        $red = hexdec(substr($color, 1, 2));
                        $green = hexdec(substr($color, 3, 2));
                        $blue = hexdec(substr($color, 5, 2));
                        $result = ($red * 299 + $green * 587 + $blue * 114) / 1000;
                        if (intval($result) > 128) {
                            $lightdark = 'text-dark';
                        } else {
                            $lightdark = 'text-light';
                        }
                        return $lightdark;
                    }
                @endphp
                @foreach ($unit->unit_member as $member)
                    <tr>
                        <td style="font-size: 12px">
                            <small>
                                {{ $member->name }}
                            </small>
                        </td>
                        @for ($i = 0; $i < $d; $i++)
                            <td style="font-size: 12px">
                                <button type="button" id="{{ $member->id }}-{{ $i + 1 }}" onclick=""
                                    class="box border rounded"
                                    style="background-color: {{ isset($shift_user[$member->id][$i + 1]) ? $shift_user[$member->id][$i + 1]->shift_color : 'grey' }}"
                                    {{ isset($shift_user[$member->id][$i + 1]) ? 'data-lastshiftid='.$shift_user[$member->id][$i + 1]->shift_id : '' }}
                                >
                                    <small
                                        class="{{ isset($shift_user[$member->id][$i + 1]) ? (isColorLightOrDark($shift_user[$member->id][$i + 1]->shift_color)) : 'text-light' }}">
                                        {{ isset($shift_user[$member->id][$i + 1]) ? $shift_user[$member->id][$i + 1]->shift_name : 'Off' }}
                                    </small>
                                </button>
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('custom-style')
    <style>
        .headcol {
            position: absolute;
            width: 5em;
            left: 0;
            top: auto;
            border-top-width: 1px;
            /*only relevant for first row*/
            margin-top: -1px;
            /*compensate for top border*/
        }

        .fullscreen {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            height: 100%;
            width: 100%;
            /* background-color: black; */
            z-index: 99;
            /* opacity: 0.2; */
        }
    </style>
@endpush

@push('custom-script')
    <script>
        const box = document.getElementsByClassName('box');
        for (var i = 0; i < box.length; i++) {
            box[i].addEventListener('click', function(event) {
                console.log(`Horizontal: ${event.clientX}, Vertical: ${event.clientY}`);
                var horizontalLoc = event.clientX
                var shiftOptionSelect = '';
                var userID = (this.id).substring(0, 3);
                var startDate = (this.id).substring(4);
                var month = {{ $month }};

                if (this.children[0].innerText == "Off") {
                    @foreach ($shift as $shiftData)
                        @if ($shiftData->unit_id == $user_data->unit['0']->id)
                            shiftOptionSelect = shiftOptionSelect + `<div class="row">
                                    <button type="button" onclick="storeShiftUser(${userID},` + {{ $shiftData->id }} +
                                `,'2024-${month}-${startDate}','2024-${month}-${startDate}', '${this.id}')" class="border rounded" style="background-color: ` +
                                '{{ $shiftData->color }}' + `">
                                        <small class="` +
                                lightOrDark('{{ $shiftData->color }}') + `">` +
                                '{{ $shiftData->shift_name }}' + `</small>
                                    </button>
                                </div>`
                        @endif
                    @endforeach
                }else{
                    @foreach ($shift as $shiftData)
                        @if ($shiftData->unit_id == $user_data->unit['0']->id)
                            shiftOptionSelect = shiftOptionSelect + `<div class="row">
                                    <button type="button" onclick="storeShiftUser(${userID}, ${this.dataset.lastshiftid},'2024-${month}-${startDate}','2024-${month}-${startDate}', '${this.id}', ` + {{ $shiftData->id }} +
                                ` )" class="border rounded" style="background-color: ` +
                                '{{ $shiftData->color }}' + `">
                                        <small class="` +
                                lightOrDark('{{ $shiftData->color }}') + `">` +
                                '{{ $shiftData->shift_name }}' + `</small>
                                    </button>
                                </div>`
                        @endif
                    @endforeach
                }
                $('html').append(
                    `
                    <div class="fullscreen" id="fullscreen"></div>
                    <div id="buttonShiftSelect" style="position:absolute;z-index:100;top:${event.clientY}px;left:${horizontalLoc}px">
                        ` + shiftOptionSelect +
                    `</div>`
                );
                const fullScrren = document.getElementById('fullscreen');
                const buttonShiftSelect = document.getElementById('buttonShiftSelect');;
                fullScrren.addEventListener('click', remove, false);

                function remove() {
                    this.parentNode.removeChild(this);
                    buttonShiftSelect.parentNode.removeChild(buttonShiftSelect);
                }

                function removeButton() {
                    this.parentNode.removeChild(this);
                    buttonShiftSelect.parentNode.removeChild(buttonShiftSelect);
                }
            });
        }

        function storeShiftUser(userID, shiftID, startDate, endDate, dateID, lastShiftId = 'NULL') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post("{{ url('karu/jadwal') }}", {
                    user_id: userID,
                    shift_id: shiftID,
                    valid_date_start: startDate,
                    valid_date_end: endDate,
                    last_shift_id: lastShiftId
                },
                function(data, status, response) {
                    console.log("Data: " + data + "\nStatus: " + status);
                    data1 = JSON.parse(data)
                    if (data1.success == true) {
                        remove();
                        $(`#${dateID}`).css("background-color", `${data1.data.shift_data.color}`);
                        $(`#${dateID}`).children('small').removeClass('text-light');
                        $(`#${dateID}`).children('small').addClass(lightOrDark(`${data1.data.shift_data.color}`));
                        $(`#${dateID}`).children('small').html(`${data1.data.shift_data.shift_name}`);
                    } else {
                        alert("Gagal!!! Tolong Hubungi Admin");
                        remove();
                    }
                },
            );

            const fullScrren = document.getElementById('fullscreen');
            const buttonShiftSelect = document.getElementById('buttonShiftSelect');;

            function remove() {
                fullScrren.parentNode.removeChild(fullScrren);
                buttonShiftSelect.parentNode.removeChild(buttonShiftSelect);
            }
        }

        function changeFunc() {
            var selectBox = document.getElementById("selectBox");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            window.location.href = "{{ url('karu/jadwal') }}/" + selectedValue;
            console.log(selectedValue);
        }

        function lightOrDark(color) {
            // Check the format of the color, HEX or RGB?
            if (color.match(/^rgb/)) {
                // If HEX --> store the red, green, blue values in separate variables
                color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);
                r = color[1];
                g = color[2];
                b = color[3];
            } else {
                // If RGB --> Convert it to HEX: http://gist.github.com/983661
                color = +("0x" + color.slice(1).replace(
                    color.length < 5 && /./g, '$&$&'
                ));
                r = color >> 16;
                g = color >> 8 & 255;
                b = color & 255;
            }
            // HSP equation from http://alienryderflex.com/hsp.html
            hsp = Math.sqrt(
                0.299 * (r * r) +
                0.587 * (g * g) +
                0.114 * (b * b)
            );
            // Using the HSP value, determine whether the color is light or dark
            if (hsp > 127.5) {
                return 'text-dark';
            } else {
                return 'text-light';
            }
        }
    </script>
@endpush
