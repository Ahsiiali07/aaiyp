<div class="ajax-listings">
    <div class="table-responsive">
        <table class="display table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th class="text-center">Reason</th>
                <th class="text-center">Detail Reason</th>
                <th class="text-center">User</th>
                <th class="text-center">Post</th>
                <th class="text-center">Created At</th>
                <th class="text-center" style="min-width: 90px">Action</th>
            </tr>
            </thead>
            <tbody>
            @if($items->count())
                @foreach($items as $item)
                    <tr>
                        <td  class="text-center">{{$item['reason']}}</td>
                        <td  class="text-center">{{$item['detailed_reason']}}</td>
                        <td  class="text-center">{{$item['user_id']? $item->user->name : ''}}</td>
                        <td  class="text-center">{{$item['feed_id']? $item->feed->title : ''}}</td>
                        <td class="text-center">{{ $item['created_at'] }}</td>

                        <td class="text-center">
                            <a href="{{route('reported-feed-show',$item->id)}}" class="text-success">
                                <i class="nav-icon i-Eye1 font-weight-bold"></i>
                            </a>

                            <form id="delete-form-{{$item->id}}" method="post" class="delete-form"
                                  action="{{route('reported-feed-delete',$item->id)}}">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="text-danger submit p-0" type="submit">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9" align="center">
                        <strong class="red-text">Record not found</strong>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
    <div class="pagination-container">
        {{ $items->links() }}
    </div>
</div>
