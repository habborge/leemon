<div class="modal fade text-left" id="selectionaddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    <div class="modal-dialog modal-width" role="document" style="max-width: 650px">
        <div class="modal-content">
            
                <div class="">
                    
                    <div class="modal-header bg-color-b">
                        <span class="modal-title white" id="myModalLabel9">Seleccione Dirección</span>
                        <button type="button" class="close x-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-12 modal-body" style="">
                        <div class="row">
                            <div id="content_info" class="col-md-12 order-md-1">

                            </div>
                        </div>
                    </div>
                </div>
          
        </div>
    </div>
</div>
@section('modal-js')
<script>  
    function showdata(data){
        $('#content_info').html(data.info);
        // $('#total_ganado').text(data.total);
    }

    function changeAddress(data){
        $.ajax({
                type:'POST',
                url:'/addresses/listchange',
                dataType:'json',
                data: {id: data},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function(x){
                $('#loading_web').show();
                },
                success:function(data){
                if(data.status==200){
                    showdata(data);
                    $('#loading_web').hide(); 
                    window.location.reload();
                    $('#selectionaddress').modal('hide');
                }else if(data.status==403){
                    $('#loading_web').hide(); 
                    $.each(data.errors, function( index, value ){
                    toastr.error(value, 'Error!', {  timeOut: 5e3});
                    });  
                }else{ 
                    $('#loading_web').hide(); 
                    toastr.error(data.message, "Error!");
                }  
                }
            });
    }
</script>

<script> 
    $(document).ready(function(){ 
        $(".prueba2").click(function (){
            alert("hola");
        });

    });
</script>
@endsection
