<div class="row justify-content-center">
   <div class="col-md-12">
      <div class="p-3 bg-body rounded shadow">
         <h6 class="border-bottom pb-2 mb-3">Cargar archivo</h6>

         <form method='post' action="{{ route('inicio.importdata') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
               <input type="file" class="form-control" id="file" name="file" value="">
            </div>

            <button type="submit" class="btn btn-primary">Importar</button>
         </form>          
      </div>
   </div>   
</div>