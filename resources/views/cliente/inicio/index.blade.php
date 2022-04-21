@extends('cliente.layouts.layout')

@section('content')

<div class="row">
    <div class="col-7">
        <h4 class="mb-3 text-primary">1. Servicio y Proveedor</h4>
        
        <div class="form-group">
            <label for="servicio_id">Servicio</label>
            <select name="servicio_id" id="servicio_id" class="form-control select2" disabled>
                <option value="">Cargando...</option>
            </select>
            <small class="text-muted">Seleccione el servicio.</small>
        </div>
        
        <div class="form-group">
            <label for="proveedor_id">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-control select2" disabled>
                <option value="">-- Seleccione servicio --</option>
            </select>
            <small class="text-muted">Seleccione el proveedor del servicio.</small>
        </div>
        
        <h4 class="mb-3 text-primary">2. Fecha y Hora</h4>
        
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="fecha"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="lista-horas"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <h4 class="mb-3 text-primary">3. Datos personales</h4>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder="" value="" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" placeholder="" value="" required>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" placeholder="">
            <div class="invalid-feedback"></div>
        </div>

    </div>
    
    <div class="col-5">
        <div class="resumen sticky-top">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Resumen de la reserva</span>
            </h4>

            <ul class="list-group mb-3">
                <li class="list-group-item lh-condensed">
                    <div class="js-reserva-servicio">
                        <h6 class="my-0"></h6>
                        <p class="m-0 text-muted"></p>
                    </div>
                    <div class="mt-2">
                        <ul class="list-unstyled">
                            <li><i class="text-muted fas fa-user-tie"></i> <span class="js-reserva-proveedor"></span></li>
                            <li><i class="text-muted fas fa-calendar-alt"></i> <span class="js-reserva-fecha"></span></li>
                            <li><i class="text-muted fas fa-clock"></i> <span class="js-reserva-hora"></span></li>
                        </ul>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-lg btn-secondary btn-block js-btn-agendar" disabled>Confirmar Cita</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
    
    let cal_options = {
        inline: true,
        locale: 'es',
        format: 'YYYY-MM-DD',
        minDate: moment(),
        maxDate: moment().add('3','months'),
        buttons: {},
    };
    
    function actualizar_dias_proveedor_servicio(proveedor_id, servicio_id) {
        $('#lista-horas').html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
        axios({
            method: 'post',
            url: '{{route('data.dias-proveedor-servicio')}}',
            data: {
                proveedor_id: proveedor_id,
                servicio_id: servicio_id,
            },
        }).then(function(response){
            
            if(response.data.length) {
                let dias_bloqueados = [0,1,2,3,4,5,6];
                response.data.forEach( function(valor, indice, array) {
                    dias_bloqueados.splice( dias_bloqueados.indexOf(valor) ,1);
                });
                cal_options.daysOfWeekDisabled = dias_bloqueados;
            }
            
        }).then(function(){
            $('#fecha').datetimepicker('destroy');
            $('#fecha').datetimepicker(cal_options);
        });
        
        // GET HORAS
        $('#fecha').on('change.datetimepicker', function(e){
            var fecha = e.date.format('YYYY-MM-DD');
            $('.js-reserva-fecha').text(e.date.format('DD-MM-YYYY'));
            $('#lista-horas').html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
            axios({
                method: 'post',
                url: '{{route('data.horas-dia-proveedor-servicio')}}',
                data: { 
                    fecha: e.date.format('YYYY-MM-DD'),
                    proveedor_id: proveedor_id,
                    servicio_id: servicio_id,
                },
            }).then(function(response){
                $('#lista-horas').html('');
                if(response.data.length > 0) {
                    response.data.forEach( function(valor, indice, array) {
                        $('#lista-horas').append('<button type="button" class="btn btn-outline-primary mr-1 js-btn-hora" data-toggle="button" data-hora="'+valor+'">'+valor+'</button>');
                    });
                } else {
                    $('#lista-horas').html('<p class="text-muted p-2 text-center">No hay horas disponibles para esta fecha.</p>');
                }
            }).catch(function(error){
                console.log(error);
                $('#lista-horas').html('<p class="text-muted p-2 text-center">Error al cargar las horas.</p>');
            });
        });
    }
    
    $(function(){
        
        // Carga servicios
        axios({
            method: 'post',
            dataType: 'json',
            url: '{{ route('data.servicios') }}',
        }).then(function(response){
            $('#servicio_id').html('<option value="">- Seleccionar -</option>');
                
            response.data.forEach(servicio => {
                $('#servicio_id').append('<option value="'+servicio.id+'">'+servicio.nombre+'</option>');
            });
        }).catch(function(error){
            console.log(error);
        }).then(function(){
            $('#servicio_id').removeAttr('disabled');
        });
        
        // Carga proveedores de servicio
        $('#servicio_id').change(function(){
            var id = $(this).val();
            var nombre = $(this).find('option:selected').text();

            if (id != '') {
                $('#proveedor_id').html('<option value="">Cargando...</option>');
                $('.js-reserva-servicio h6').text(nombre);
                axios({
                    method: 'post',
                    url: '{{ route('data.proveedores-servicio') }}',
                    data: {servicio_id: id},
                }).then(function(response){
                    $('#proveedor_id').html('<option value="">- Seleccionar -</option>');
                    response.data.forEach(proveedor => {
                        $('#proveedor_id').append('<option value="'+proveedor.id+'">'+proveedor.nombre+'</option>');
                    });
                }).catch(function(error){
                }).then(function(){
                    $('#proveedor_id').removeAttr('disabled');
                });
            }
        });
        
        // Carga fechas proveedor de servicio
        $('#proveedor_id').change(function(){
            var id = $(this).val();
            var nombre = $(this).find('option:selected').text();

            if (id != '') {
                $('.js-reserva-proveedor').text(nombre);
                actualizar_dias_proveedor_servicio(id, $('#servicio_id').val());
            } else {
                $('#fecha').datetimepicker('destroy');
            }
        });

        $('#lista-horas').on('click','.js-btn-hora', function(){
            let hora = $(this).data('hora');
            $('.js-reserva-hora').text(hora);
            $('.js-btn-hora').removeClass('active');
            $('.js-btn-agendar').removeAttr('disabled').removeClass('btn-secondary').addClass('btn-primary');
        });

    });
</script>
@endpush