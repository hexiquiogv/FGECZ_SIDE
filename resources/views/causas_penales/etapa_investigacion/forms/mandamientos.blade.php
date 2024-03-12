        <div class="input-group">
          <label for="causa_H_tipo_mandamiento" class="input-group-text">Tipo de mandamiento:</label>
          <select class="form-select mand{{$imputado->id}} noValidate" name="causa_H_tipo_mandamiento" id="causa_H_tipo_mandamiento">
            <option value="-1">Seleccione una opción</option>
            @foreach ($TipoMJ as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach 
          </select>
          <button type="button" title="Acumular mandamiento" class="btn btn-outline-success" onclick="javascript:acumularMandamiento({{$imputado->id}})">
          Acumular mandamiento</button>
        </div>
        <div>        
          <input type="hidden" id="hdnacumulado{{$imputado->id}}" name="hdnacumulado{{$imputado->id}}">
          <div class="alert alert-dark mb-0" id="txtacumulado{{$imputado->id}}"></div>                          
        </div>
        <div class="input-group"> 
          <label for="causa_H_solicitud_de_mandamiento_judicial" class="input-group-text">Fecha de solicitud del mandamiento judicial:</label>
          <input type="date" class="form-control mand{{$imputado->id}}" name="causa_H_solicitud_de_mandamiento_judicial" 
          id="causa_H_solicitud_de_mandamiento_judicial">         
         
          <label for="causa_H_estatus_mandamiento" class="input-group-text">Estatus de mandamiento judicial:</label>
          <select class="form-select mand{{$imputado->id}}" name="causa_H_estatus_mandamiento" id="causa_H_estatus_mandamiento">
            <option value="-1">Seleccione una opción</option>
            @foreach ($estatusMJ as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach               
          </select>
          <label for="causa_H_fecha_libera" class="input-group-text d-none">Fecha de libramiento del mandamiento:</label>
          <input type="date" class="form-control mand{{$imputado->id}} d-none" name="causa_H_fecha_libera" id="causa_H_fecha_libera">
        </div>
        <div class="input-group">          
          <label for="causa_H_fecha_mandamiento" class="input-group-text">Fecha de cumplimiento del mandamiento:</label>
          <input type="date" class="form-control mand{{$imputado->id}} noValidate" name="causa_H_fecha_mandamiento" id="causa_H_fecha_mandamiento" placeholder="">
          <button type="button" class="btn btn-primary" onclick="javascript:addMandamiento({{$imputado->id}})">Agregar mandamiento</button>
        </div>
        <input type="hidden" name="hdnMandamientos{{$imputado->id}}" id="hdnMandamientos{{$imputado->id}}">
        <table id="mandamientos{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
            <caption></caption>    
            <thead class="table-light">
            <tr>                            
              <th scope="col">Tipo de mandamiento</th>
              <th scope="col">Fecha de solicitud del mandamiento judicial</th>
              <th scope="col">Estatus de mandamiento judicial</th>
              <!-- <th scope="col">Fecha de libramiento del mandamiento</th> -->
              <th scope="col">Fecha de cumplimiento del mandamiento</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($mandamientos_DE[$imputado->id]))
             @foreach ($mandamientos_DE[$imputado->id] as $mandamiento)                         
              <tr class="tr{{$imputado->id}}_{{$mandamiento->id}}">
                <td>{{$mandamiento->TIPO_MANDAMIENTO}}</td>
                <td>{{$mandamiento->SOLICITUD_DE_MANDAMIENTO_JUDICIAL}}</td>
                <td>{{$mandamiento->ESTATUS_MANDAMIENTO}}</td>
                {{-- <td>{{$mandamiento->FECHA_LIBERA}}</td> --}}
                <td>{{$mandamiento->FECHA_MANDAMIENTO}}</td>
                <td>
                  {{--<button type="button" title="Eliminar mandamiento" class="btn btn-danger" 
                  onclick="eliminarMandamiento('{{$imputado->id}}','{{$mandamiento->id}}',1)">×</button>--}}
                </td>
              </tr>
             @endforeach                          
            @endif
           @foreach ($mandamientos[$imputado->id] as $mandamiento)                         
            <tr class="tr{{$imputado->id}}_{{$mandamiento->id}}">
              <td>{{$mandamiento->TIPO_MANDAMIENTO}}</td>
              <td>{{$mandamiento->SOLICITUD_DE_MANDAMIENTO_JUDICIAL}}</td>
              <td>{{$mandamiento->ESTATUS_MANDAMIENTO}}</td>
              {{-- <td>{{$mandamiento->FECHA_LIBERA}}</td> --}}
              <td>{{$mandamiento->FECHA_MANDAMIENTO}}</td>
              <td>
                <button type="button" title="Eliminar mandamiento" class="btn btn-danger" 
                onclick="eliminarMandamiento('{{$imputado->id}}','{{$mandamiento->id}}',1)">×</button>
              </td>
            </tr>
           @endforeach                          

          </tbody>
        </table>    

<script type="text/javascript">

</script>