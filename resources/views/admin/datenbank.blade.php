<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Fahrer</h3>
            <div class="row col-md-12 ">
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-plus"></span>
                        Fahrer hinzufügen
                    </button>
                    <button type="button" class="btn btn-default">Hilfe</button>
                </div>
                <div class="input-group col-md-4 pull-right">
                    <input type="text" class="form-control" placeholder="Suche nach...">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                </div>
            </div>
            <span class="clearfix"></span>
        </div>
        <div class="panel-body ">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gewicht</th>
                    <th>Größe</th>
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                </tr>
                @foreach($fahrer as $f)
                    <tr>
                        <td>{{$f->name}}</td>
                        <td>{{$f->email}}</td>
                        <td>{{$f->gewicht}}</td>
                        <td>{{$f->groesse}}</td>
                        <td>
                            <button class="btn btn-default">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-default">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="clear"></div>
</div>