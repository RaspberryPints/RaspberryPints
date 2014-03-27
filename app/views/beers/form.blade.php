
        {{ Form::hidden('id') }}
        <table>
            <tr>
                <td>
                    {{ Form::label('name', Lang::get('common.name'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('name', Input::old('name')) }}
                    {{ $errors->first('name', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>

            		{{ Form::label('beerStyleId', Lang::get('common.beerStyle'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::select('beerStyleId', $beerStyleList) }}
                    {{ $errors->first('beerStyleId', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('notes', Lang::get('common.notes'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::textarea('notes', Input::old('notes')) }}
                    {{ $errors->first('notes', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('ogEst', Lang::get('common.estimatedOG'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('ogEst', Input::old('ogEst')) }}
                    {{ $errors->first('ogEst', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('fgEst', Lang::get('common.estimatedFG'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('fgEst', Input::old('fgEst')) }}
                    {{ $errors->first('fgEst', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('srmEst', Lang::get('common.estimatedSRM'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('srmEst', Input::old('srmEst')) }}
                    {{ $errors->first('srmEst', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('ibuEst', Lang::get('common.estimatedIBU'), array('class' => 'required')) }}
                </td>
                <td>
                    {{ Form::text('ibuEst', Input::old('ibuEst')) }}
                    {{ $errors->first('ibuEst', Lang::get('html.errorMessage')) }}
                </td>
            </tr>
			<tr>
                <td>
                    {{ Form::label('untID', Lang::get('common.untID')) }}
                </td>
                <td>
                    {{ Form::text('untID', Input::old('untID')) }}
                    
                </td>
            </tr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {{ link_to_action('BeerController@index', Lang::get('common.cancel'), null, array( 'class' => 'btnalt')); }}
                    {{ Form::submit(Lang::get('common.save'), array( 'class' => 'btn')) }}
                </td>
            </tr>
        </table>

