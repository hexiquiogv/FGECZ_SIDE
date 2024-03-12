<div class="row justify-content-center">
   <div class="col-md-12">
      <div class="p-3 bg-body rounded shadow">
         <h6 class="border-bottom pb-2 mb-3">Cargar archivo</h6>

         <form method='post' action="{{ route('inicio.importExcel') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 input-group">
               <label class="input-group-text" type="button" onclick="$('#file').click()">Adjuntar archivo</label>
               <input type="text" id="nombreFile" class="form-control" readonly>                 
            </div>
               <input type="file" class="form-control d-none" id="file" name="file" value="">
            <button type="button" onclick="guardar()" id="submitBtn" class="btn btn-primary">Importar</button>
            <!-- <button type="submit" class="btn btn-primary">Importar</button> -->
         </form>          
      </div>
   </div>   
</div>
<script>
  function guardar()
  {
   if ($("#file").val().length>0) {
      document.getElementById("submitBtn").disabled=true;
      $("form").submit();
   }
   else
   {
      if ($(".nece").length<1) {
         $("form").append('<div class="alert alert-danger nece">Es necesario cargar un archivo</div>');
      }
   }
  }
   document.getElementById('file').onchange = function () {
  $("#nombreFile").val(this.value.split('\\').pop());
};
</script>