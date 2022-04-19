{!! Form::open(['url' => route('notification-send-to-all'), 'class'=> 'ajax', 'method' => 'post', 'id' => 'notification-send-to-all']) !!}
<div class="row">
    {{ csrf_field() }}
    <div class="col-md-6 form-group mb-3">
        <label for="name">Title <span class="required">*</span></label>
        {!! Form::text('title', '', ['class'=>'form-control form-control-rounded', 'id' => 'title']) !!}
        <div class="form-error title"></div>
    </div>

    <div class="col-md-12 form-group mb-3">
        <label for="description">Description <span class="required">*</span></label>
        {!! Form::textarea('description', '', ['class'=>'form-control form-control-rounded', 'id' => 'description', 'rows'=>5]) !!}
        <div class="form-error description"></div>
    </div>

    <div class="col-md-6 form-group mb-3">
        <label for="logo" class="col-md-12">Image</label>
        {!! Form::file('image_url', ['class'=>'inputfile', 'id' => 'image_url',  'data-preview-file-type' => 'text']) !!}
        <label for="image_url" class="inputfilelabel"><strong>Choose a file</strong></label>
        <div class="form-error image_url"></div>
        <div id="target" class="mt-4">
            @if(isset($item))
                @if($item['image_url'])
                    <img class="office-logo rounded img-thumbnail" src="{{ asset('public/'.$item->image_url) }}" alt="">
                @endif
            @endif
        </div>
    </div>


    <div class="col-md-12">
        <button type="submit" class="btn btn-primary submit">Send</button>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    // var input   = $('.inputfile')[0];
    let label = $('.inputfilelabel')[0];
    labelVal = label.innerHTML;

    $('input[type=file]').on('change', function (e) {
        let file = e.target.files[0];
        let filename = file.name;
        if (filename) {
            let reader = new FileReader();
            reader.onload = function (e2) {
                $('#target').html('<img class="office-logo rounded img-thumbnail" src="' + e2.target.result + '" alt="">');
            };
            reader.readAsDataURL(file);
            label.innerHTML = filename;
        } else {
            label.innerHTML = labelVal;
        }
    });
</script>
