<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Fahrer</h3>
            <button type="button" class="btn btn-info btn-xs pull-right ">
                <span class="glyphicon glyphicon-question-sign"></span>
            </button>
            <span class="clearfix"></span>
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