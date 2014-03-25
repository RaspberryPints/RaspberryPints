
        {{ Form::hidden('id') }}
        <table>
            <tr>
                <td>
                    {{ Form::label('beerId', Lang::get('common.beer'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::select('beerId', $beerList) }}
                    {{ $errors->first('beerId', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>

            		{{ Form::label('kegId', Lang::get('common.keg'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::select('kegId', $kegList) }}
                    {{ $errors->first('kegId', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('ogAct', Lang::get('common.actualOG'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('ogAct', Input::old('ogAct')) }}
                    {{ $errors->first('ogAct', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('fgAct', Lang::get('common.actualFG'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('fgAct', Input::old('fgAct')) }}
                    {{ $errors->first('fgAct', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('srmAct', Lang::get('common.actualSRM'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('srmAct', Input::old('srmAct')) }}
                    {{ $errors->first('srmAct', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('ibuAct', Lang::get('common.actualIBU'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('ibuAct', Input::old('ibuAct')) }}
                    {{ $errors->first('ibuAct', Lang::get('html.errorMessage')) }}
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    {{ link_to_action('BatchController@index', Lang::get('common.cancel'), null, array( 'class' => 'btnalt')); }}
                    {{ Form::submit(Lang::get('common.save'), array( 'class' => 'btn')) }}
                </td>
            </tr>
        </table>

