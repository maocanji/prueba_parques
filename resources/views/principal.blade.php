@extends('layouts.app_')

@section('content')
<div  ng-app="welcomeApp" ng-controller="listaCtrl"  class="ng-scope">
    <div class="container">
        <main>
            <div class="py-5 justify-content-center">
                <h2>Practica</h2>
                <p>1) Se debe publicar la información en un repositorio GIT público al que se debe tener acceso para poder descargar el codigo</p>
                                   <p>2) Se debe construir un API en el backend de Laravel version 7.x o 8.x</p>
                                    <p>3) Se debe construir un Frontend en Angular 8 o superior</p>
                                   <p>4) La base de datos debe ser mysql8</p>
                                   <p>5) El servidor de aplicaciones debe ser Apache o Nginx</p>
                                   <p>6) El frontend debe hacer uso de rxjs</p>
                                   <p>* Es deseable que se realiza la entrega de un esquema bajo docker</p>
                                   <p>La prueba consiste en lo siguiente, se debe tener 1 formulario con 3 campos: uno de correo, uno de departamento y uno de municipios (los deptos puede ser inventados al igual
                                       que los municipios NO es necesario incluir todos los del pais). Este formulario debe hacer una llamada al backend de la aplicación para realizar el cargue de los departamentos
                                       y dependiendo del departamente seleccionado realizar el llenado del combo del municipio. Todos los 3 campos son obligatorios. Una vez se realice el POST el frontend debe realizar una validación basica y el backend  debe validar que los municipios existen y que el correo de @minambiente.gov.co. La información debe persistir en una bd. Una vez la información persiste se debe visualizar los datos en una tabla que despliegue 2 registros y que tenga un esquema de paginación. Sobre cada registro se puede ejecutar la acción de eliminar un registro dado clic sobre el elemento deseado a lo cual sale un mensaje que confirme la acción y luego eliminar el registro en la bd y refrescar el listado.
                                   </p>
            </div>
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Formulario</span>
                    </h4>
{{--<% listMun.data['cod_dep'] %>--}}
{{--<% listMun[0]['mun'] %>--}}

                    <div class=" well">
                        <% munici %>
                    </div>
                    <form name="registroForm">
                            <section class="col-md-12">

                                {{ csrf_field() }}

                                <div class='form-group'>
                                    <label for="departamento">Departamento</label>
                                    <select  ng-init="formData.departamento"
                                        ng-options="departamento.nombre_dep for departamento in listDep.data track by departamento.id_dep" class='form-control'
                                        name='departamento' data-ng-model='formData.departamento' data-ng-value='departamento.id_dep' ng-change='myFunc(formData.departamento)'
                                        data-ng-class='{ error: registroForm.departamento.$invalid && !registroForm.$pristine }'>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>

                                <div class='form-group'>
                                    <label for="departamento">Municipio (**)</label>
                                    <select ng-init="municipio"
                                             ng-options="muni.mun for muni in munici track by muni.mun" class='form-control'
                                             name='muni' data-ng-model='formData.muni' data-ng-value='muni.mun' required
                                             data-ng-class='{ error: registroForm.muni.$invalid && !registroForm.$pristine }'>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>



                                <div class='form-group'>
                                    <label for="email">Email</label>
                                    <input type="email"  class='form-control' placeholder='Email'
                                           name='email' data-ng-model='formData.email' required
                                           data-ng-class='{ error: registroForm.email.$invalid && !registroForm.$pristine }'>
                                    </input>
                                </div>

                            </section>
                                <div class="col-md-12">
                                <p></p>
                                    <input type="submit" class='form-control btn btn-primary'
                                           data-ng-click='guardarDatos(formData)' data-ng-disabled='!registroForm.$valid'>
                                </div>
                    </form>
                </div>


                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>
                    <table ng-table="tableParams"  class="table  table-striped ">
                        <div class="form-group pull-left">
                            <p>Total Reg: <strong> <% reg.length  %> </strong>
                        </div>

                        <tr ng-repeat="dato in data track by $index" ng-class="clase[$index]">
                            <td  class="text-center small" data-title="'No.'" >
                                <% $index %>
                            </td>

                            <td data-title="'id'" class="project-title text-left"   >
                                <% dato.id  %>
                            </td>

                            <td data-title="'Email'" class="project-title text-left" style=" font-size: 14px; width: 10px" groupable="'email'" sortable="'email'" filter="{ 'email': 'text' }" filter-data="email" >
                                <% dato.email  %>
                            </td>

                            <td data-title="'Municipio'" class="project-title text-center"   >
                                <% dato.municipios  %>
                            </td>
                            <td data-title="'Departamento'" class="project-title text-center"   >
                                <% dato.departamentos  %>
                            </td>
                            <td>
                            <button type="button" class="btn btn-sm btn-danger" ng-click="borrarRegistro($index)">Delete</button>

                            </td>

                        </tr>
                    </table>

                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Mensajes de validación</div>

                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <p>Corrige los siguientes errores:</p>
                                        <ul>
                                            @foreach ($errors->all() as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                            <!-- Validation for 4 fields-->
                                <div id="validation">{!! $errors->first('email') !!}</div>
                                <div id="validation">{!! $errors->first('municipio') !!}</div>
                                <div id="validation">{!! $errors->first('departamento') !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>



@endsection
