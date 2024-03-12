<form method='post' name="frmDE_R" id="frmDE_R" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idRelacion" id="idRelacion" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
    <div class="mb-3 input-group">
        <label for="relDelito" class="input-group-text">Delito:</label>
        <select class="form-select" id="relDelito" name="relDelito">
        <option value="-1">Seleccione una opción</option>
        </select>
    </div>
    <div class="mb-3 input-group">
        <label for="ddlI" class="input-group-text">Imputado:</label>
        <select class="form-select noValidate" id="ddlI" name="ddlI">
            <option value="-1">Seleccione una opción</option>
        </select>
        <button type="button" title="Agregar imputado" class="btn btn-outline-success" onclick="javascript:acumular('I')">Agregar imputado</button>
    </div>
    <div class="mb-3">
        <input type="hidden" id="hdnacumuladoI" name="hdnacumuladoI">
        <div class="alert alert-dark" id="txtacumuladoI">
            
        </div>                          
    </div>
    <div class="mb-3 input-group">
        <label for="ddlV" class="input-group-text">Víctima:</label>        
        <select class="form-select noValidate" id="ddlV" name="ddlV">
            <option value="-1">Seleccione una opción</option>
        </select>
        <button type="button" title="Agregar víctima" class="btn btn-outline-success" onclick="javascript:acumular('V')">Agregar víctima</button>        
    </div>
    <div class="mb-3">
        <input type="hidden" id="hdnacumuladoV" name="hdnacumuladoV">
        <div class="alert alert-dark" id="txtacumuladoV">
        
        </div>                          
    </div>
</form>  
<script type="text/javascript">
    function acumular(tipo)
    {
    var id=-1;
    var valor='';
        id=$("#ddl"+tipo+" :selected").val();
        valor=$("#ddl"+tipo+" :selected").text();

      if (id>-1) {
        var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+id+"'>"+valor+
        "<button type='button' class='btn-close' onclick='eliminar(this,\""+tipo+"\")'></button></span>";
        
        var ids = JSON.parse("["+$("#hdnacumulado"+tipo).val()+"]");
        
        if (!(ids.includes(parseInt(id)))) {

            ids.push(id.toString());
            $("#ddl"+tipo+" :selected").attr('disabled',true);
            $("#hdnacumulado"+tipo).val(ids.toString());
            $("#txtacumulado"+tipo).append(badge);
        }
      }
    }
    function eliminar(element,tipo)
    {   
        var ids = JSON.parse("["+$("#hdnacumulado"+tipo).val()+"]");
        var id=element.parentElement.id.slice(5);
        if (ids.includes(parseInt(id))) {              
                var result=ids.filter(function(ele){  return ele != id; });
            $("#hdnacumulado"+tipo).val(result.toString());
            $("#ddl"+tipo+" option[value="+id+"]").attr('disabled',false);
            element.parentElement.remove();

        }       
    }        
</script>
