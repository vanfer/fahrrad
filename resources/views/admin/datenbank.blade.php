<div class="col-md-6">
    <div class="panel panel-default pull-left fahrer-panel">
        <div class="panel-heading">
            <h3 class="panel-title">Fahrer</h3>
        </div>
        <div class="panel-body ">
            @foreach($fahrer as $f)
                <div class="col-md-4">
                    <div class="well well-lg clearfix text-center">
                        {{$f->name}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="clear"></div>
</div>