<div class="table-container flex justify-center">
    <table class="table table-light table-bordered table-hover table-responsive w-25 m-5">
        @foreach ($absences as $absence)
            <tr>
                <td><a href="{{route('absence.show',$absence->id)}}">{{ $absence->motif->Libelle.' demandé par '.$absence->user->name }}</a></td>
            </tr>
        @endforeach
    </table>
</div>
