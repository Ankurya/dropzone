<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>How to Upload Files with Drag 'n' Drop and Image preview in Laravel 8 using dropzone</title>


    {{-- dropbox CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #9C27B0;
            color: white;
            text-align: center;
        }

        body {
            background-color: #EDF7EF
        }

        .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            margin-left: 45%;
        }

    </style>
</head>

<body>
    <div class="row mb-3">
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <h2>Laravel 8 File Upload </h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

        </div>
        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data" class="dropzone"
            id="dropzone">
            @csrf
            <div class="dz-message needsclick">

                <h3>Drag and Drop files here or click to upload.</h3>
                <i class="fas fa-box-open fa-5x pull-r"></i>
                <br>
            </div>
        </form>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <a class="btn btn-success" href="{{ route('files.index') }}" title="return to index"> <i
                        class="fas fa-backward fa-2x"></i>
                </a>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-responsive-lg thead-dark text-center">
        <thead class="thead-dark ">
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>File Name</th>
                <th>File Size</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($files as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td><img src="{{ url('/storage') }}/{{ $project->filename }}" width="100"></td>
                    <td><a href="{{ route('files.show', ['file' => $project->id]) }}" target="_blank">{{ $project->filename }}</td>
                    <td>{{ $project->filesize }}</td>
                    <td>
                        <form action="{{ route('files.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                <i class="fas fa-trash fa-lg text-danger"></i>

                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        Dropzone.options.dropzone = {
            maxFilesize: 12,
            resizeQuality: 1.0,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
            removedfile: function(file) {
                var name = file.upload.filename;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url('files.store') }}',
                    data: {
                        filename: name
                    },
                    success: function(data) {
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                return false;
            }
        };
    </script>
    {{-- <script>
         $('.preview_img').click(function() {
            let data = "{{ url('/storage') }}/{{ $project->filename }}";
            var w = window.open(data);
            let file = new Image();
            file.src = data;
            setTimeout(function() {
                w.document.write(file.outerHTML);
            }, 0);

        });
    </script> --}}
</body>

</html>
