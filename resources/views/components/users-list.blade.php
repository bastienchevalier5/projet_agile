<div class="table-container flex justify-center">
    <table class="table table-light table-bordered table-hover table-responsive w-25 m-5">
        @foreach ($users as $user)
            <tr>
                @if (Auth::id() != $user->id)
                    <td><a href="{{route('user.show',$user->id)}}">{{ $user->name }}</a></td>
                @endif
            </tr>
        @endforeach
    </table>
</div>
