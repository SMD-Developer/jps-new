<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title"><i class="fa fa-cogs"></i> @lang('app.assign_permissions')</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        {!! Form::model($role, ['url' => 'settings/assignPermission', 'class'=>"ajax-submit"]) !!}
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('name', trans('app.role')) !!}
                    {!! Form::hidden('role_id', $role->uuid) !!}
                    <p>{{$role->name}}</p>
                </div>
                <div class="form-group col-sm-6">
                    {!! Form::text('search',null,['class'=>'form-control form-control-sm', 'placeholder'=>'Search permissions','id'=>'searchInput','onkeyup'=>"searchPermissions()"]) !!}
                </div>
            </div>

            <div class="form-group">
                <table class="table dataTable" id="permissionTable">
                    <tr>
                        <th>{{trans('app.name')}}</th>
                        <th>{{trans('app.description')}}</th>
                        <th>{!! Form::checkbox('select-all-permissions', 1, count($permissions) == $role->permissions->count() ,['class'=>'big-checkbox select-all-permissions']) !!}</th>
                    </tr>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->description}}</td>
                            <td>{!! Form::checkbox('permissions[]', $permission->uuid, $role->permissions->contains('name', $permission->name) ? true : null,['class'=>'big-checkbox chkbx-permission']) !!} </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="modal-footer justify-content-between col-sm-12 modal-footer--sticky bg-light">
            {!! Form::button('<i class="fa fa-times"></i> '.trans('app.close'),['class' => 'btn btn-sm btn-danger float-left','data-dismiss'=>'modal']); !!}
            {!! Form::button('<i class="fa fa-save"></i> '.trans('app.save'),['class' => 'btn btn-sm btn-success float-right mr-2','type'=>'submit']); !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>