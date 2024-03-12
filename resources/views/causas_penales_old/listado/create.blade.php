<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="addCausa" onclick="javascript:addCausa('0')">
  Agregar causa
</button>


<script type="text/javascript">

   function addCausa(idCausa){
       location.replace("{{ route('dash',['d0',Request::segment(3)]) }}/"+idCausa);
	}
</script>