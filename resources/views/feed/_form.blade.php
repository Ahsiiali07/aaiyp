@if(isset($item))
    {!! Form::open(['url' => route('feed-update', $item['id']), 'class'=> 'ajax', 'method' => 'feeds', 'id' => 'update-feed-form']) !!}
@else
    {!! Form::open(['url' => route('feed-store'), 'class'=> 'ajax', 'method' => 'feeds', 'id' => 'create-feed-form']) !!}
@endif
<div class="row">
    {{ csrf_field() }}
    <div class="col-md-6 form-group mb-3">
        <label for="name">Title <span class="required">*</span></label>
        {!! Form::text('title', $item->title ?? '', ['class'=>'form-control form-control-rounded', 'id' => 'title']) !!}
        <div class="form-error title"></div>
    </div>

    <div class="col-md-6 form-group mb-3">
        <label for="logo" class="col-md-12">Image/Video</label>
        {!! Form::file('video_url', ['class'=>'inputfile', 'id' => 'video_url',  'data-preview-file-type' => 'text']) !!}
        <label for="video_url" class="inputfilelabel"><strong>Choose a file</strong></label>
        <div class="form-error video_url"></div>
        <div id="target" class="mt-4">
            @if(isset($item))
                @if($item['video_url'])
                    <img class="office-logo rounded img-thumbnail" src="{{ asset('public/storage/'.$item->video_url) }}"
                         alt="">
                @endif
            @endif
        </div>
    </div>

    <div class="col-md-6 form-group mb-3">
        <label for="subject">Description <span class="required">*</span></label>
        {!! Form::textarea('description', $item->description ?? '', ['class'=>'form-control form-control-rounded', 'id' => 'description']) !!}
        <div class="form-error description"></div>
    </div>

    <div class="col-md-12">
        {!! Form::hidden('old_video_url', $item->video_url ?? null) !!}
        <button type="submit" class="btn btn-primary submit">Save</button>
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
