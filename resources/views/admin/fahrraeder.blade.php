<div class="col-md-6">
    @foreach ($fahrraeder as $fahrrad)
        @if ($fahrrad->getFahrerID()== null)
            @include("admin.fahrrad-inaktiv")
        @else
            @include("admin.fahrrad-aktiv")
        @endif
    @endforeach
    @include("admin.fahrer-anmelden")
</div>