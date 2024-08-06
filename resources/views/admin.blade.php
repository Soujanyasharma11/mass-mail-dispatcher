{{-- upload csv file --}}

<div class="container-fluid relative animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upload CSV File</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.upload.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">CSV File</label>
                            <input type="file" class="form-control-file" id="csv_file" name="csv_file">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    @error('csv_file')
                        <div class="alert alert-danger">{{ $message }}</div>
                        
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="input-mail">
    <div class="input-group">
       <form action="{{ route('admin.send.mail') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" class="form-control" name="email" placeholder="Email">
            {{-- input file --}}
            <input type="file"  name="attachment" class="form-control-file" id="csv_file">
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

</div>
<hr>
{{-- errors --}}
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}


