<div class="table-container flex justify-center">
    <table class="table table-light table-bordered table-hover table-responsive w-25 m-5">
        @foreach ($motifs as $motif)
            <tr>
                <td><a href="{{route('motif.show',$motif->id)}}">{{ $motif->Libelle }}</a></td>
            </tr>
        @endforeach
    </table>
</div>
