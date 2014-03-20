
        {{ Form::hidden('id') }}
        <table>
            <tr>
                <td>
                    {{ Form::label('label', Lang::get('common.label'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('label', Input::old('label')) }}
                    {{ $errors->first('label', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>

            		{{ Form::label('kegTypeId', Lang::get('common.type')) }}
                </td>
                <td>
                    {{ Form::select('kegTypeId', $kegTypeList) }}
                    {{ $errors->first('kegTypeId', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('make', Lang::get('common.make')) }}
                </td>
                <td>
                    {{ Form::textarea('make', Input::old('make')) }}
                    {{ $errors->first('make', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('model', Lang::get('common.model')) }}
                </td>
                <td>
                    {{ Form::text('model', Input::old('model')) }}
                    {{ $errors->first('model', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('serial', Lang::get('common.serialNumber')) }}
                </td>
                <td>
                    {{ Form::text('serial', Input::old('serial')) }}
                    {{ $errors->first('serial', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('stampedOwner', Lang::get('common.stampedOwner')) }}
                </td>
                <td>
                    {{ Form::text('stampedOwner', Input::old('stampedOwner')) }}
                    {{ $errors->first('stampedOwner', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('stampedLoc', Lang::get('common.location')) }}
                </td>
                <td>
                    {{ Form::text('stampedLoc', Input::old('stampedLoc')) }}
                    {{ $errors->first('stampedLoc', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('weight', Lang::get('common.emptyWeight')) }}
                </td>
                <td>
                    {{ Form::text('weight', Input::old('weight')) }}
                    {{ $errors->first('weight', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('notes', Lang::get('common.notes')) }}
                </td>
                <td>
                    {{ Form::textarea('notes', Input::old('notes')) }}
                    {{ $errors->first('notes', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('kegStatusCode', Lang::get('common.status')) }}
                </td>
                <td>
                    {{ Form::select('kegStatusCode', $kegStatusList) }}
                    {{ $errors->first('kegStatusCode', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {{ link_to_action('KegController@index', Lang::get('common.cancel'), null, array( 'class' => 'btnalt')); }}
                    {{ Form::submit(Lang::get('common.save'), array( 'class' => 'btn')) }}
                </td>
            </tr>
        </table>

