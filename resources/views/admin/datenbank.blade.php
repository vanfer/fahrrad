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
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Los!</button>
                    </span>
                </div>
            </div>
            <span class="clearfix"></span>
        </div>
        <div class="panel-body ">
            <form action="{{ url("fahrer") }}" method="PUT">
                <table class="table table-striped table-bordered table-hover" id="userTable">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gewicht</th>
                        <th>Größe</th>
                        <th></th>
                    </tr>
                    @foreach($fahrer as $f)
                        <tr draggable="true" id="{{$f->id}}">
                            <th id="th_fahrer_id">
                                <fieldset>
                                    <input type="radio" name="radio_fahrer_id" class="radio-fahrer-id" value="{{$f->id}}">
                                </fieldset>
                            </th>
                            <td id="name">{{$f->name}}</td>
                            <td id="email">{{$f->email}}</td>
                            <td id="gewicht">{{$f->gewicht}}</td>
                            <td id="groesse">{{$f->groesse}}</td>
                            <th>
                                <div class="btn btn-default btnDelete">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>