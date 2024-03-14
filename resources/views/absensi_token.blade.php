@extends('layout.token_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>
    <div class="d-flex align-items-center justify-content-center">
        {!! QrCode::size(256)->generate($data->token) !!}
        <canvas id="canvas"></canvas>
    </div>



@stop

@push('custom-script')
    <script type="module">
        axios({
            method: "get",
            url: "http://192.168.1.34/api/v1/absensi-token",
            headers: {
                Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjU4ZDNhNy02ZDI0LTRhNTEtYjAxMC0zZDQ1Y2I0NzkyMDMiLCJqdGkiOiJlNTViMDFhODY0OTEyODgwZGUzMTI0ODhmODZmYjlkYzhkYjY2NzFlZWQ4ZjczODI1M2ZlNmU0YzRlNmFlZDNkZTFiNTY1Njc3NzE5ZGRhMCIsImlhdCI6MTcxMDM4OTk2Ny41MzY3OTgwMDAzMzU2OTMzNTkzNzUsIm5iZiI6MTcxMDM4OTk2Ny41MzY3OTk5MDc2ODQzMjYxNzE4NzUsImV4cCI6MTc0MTkyNTk2Ny41Mjk0OTkwNTM5NTUwNzgxMjUsInN1YiI6IjkiLCJzY29wZXMiOltdfQ.MTEqX4PM6U_pYsZaopdQGj_6Fsrl3W80VCiakWmig-arOGz0lMhcXYGaEQ-uxHMZc6M2fSpuwl0WX4WPQySZNU8qhwPL5qBuJl57wAeWQQ8CcAy8jErpVMLxnZ1YHG2-d67PmHW3oqZer1R8OIGW_S7Uw4UntPC2TkNqZ56biHKXsKsui1xCCoi-BGFSTz6oU88VfCv6y2FsxXOTtgLRbfsywfe4wn7pUNKa1PqT_seyJc-mUKni9p5Teb-3uppBl2MrALEnCsHv5Xib47nv3H-dAfdLK-_KHaqmwzK8iI-FVyTshR7UltiO5gJww0JYpVRGHVKykJjb29r3zRS76webrm_mRGq0Yq9-yM0q4dfbEN6oq0i4NY4r44ajDR0x9LeksZIySk2zA4kxMQvuE5l51ticgm7WnqsuocWhrBEnynjGc8CXE2zxZlsJD3Jxsl_sKUP-O-IKbZpbZe93-YrvybD6UzaevyonN11E2kRWq-U6vWogLGjPzspg0rB4OWIsCgJ1IwBZSbmKzoGHmsNdUQcFM3jwu9ngq4Yw0CEmq5NilLvobVXotwcg_nrP7DCkJTNzz804N9Wk9AZSpIy9uAJ0tgsRwjcu9CUxQkuH1yoYswZOuM-NRsBKdEsBlWT7D09zG85Bg8uk8NGRVbwj00z-idIDdoVClc8KQLo`,
            },
        }).then((response) => {
            console.log(response.data);
        });
        QRCode.toCanvas(document.getElementById('canvas'), 'sample text', function(error) {
            if (error) console.error(error)
            console.log('success!');
        })
    </script>
@endpush
