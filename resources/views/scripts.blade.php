<script>

    var angularApp = angular.module( 'welcomeApp', [ 'ngTable','ui.bootstrap'] );
    angularApp.config(function($interpolateProvider , $httpProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    });

    angularApp.controller( 'listaCtrl', function(   $scope , $http, $timeout, $log, $filter, ngTableParams ,$modal){

        /* Función para cargar archivos de deparatamentos json que se encuentra en public */

        $http.get('departamentos.json').then(function(data) {
            $scope.listDep = data
        });
        /* Función para cargar archivos de municipios json que se encuentra en public */
        $http.get('municipios.json').then(function(response) {
            $scope.listMun = response.data;
        });

        /*Inicializar variables*/
        $scope.reg = {!! $datos !!};
        $scope.munici  = [];

        /* Función para reiniciar el formulario y sus validaciones */
        /*  */
        $scope.reset = function(form) {
            $scope.formData = {};
            $scope.munici = {};
                registroForm.$setPristine();
                registroForm.$setUntouched();
                formData.$setPristine();
                formData.$setUntouched();

            alert('Formulario para Iniciar - limpio');
        };


        /* Función que recorre el listado de los municipios que hacen parte de los departamentos */
        /* Importante la estructura de los archivos en JSON */

        $scope.myFunc = function($index) {
            for(var i = 0, arr = 5; i < arr; i++ ){
                    if($scope.listMun[i]['cod_dep'] === $index['id_dep'] ){
                        $scope.munici.push($scope.listMun[i]);
                }else{
                        console.log('-')
                    }
            }
            return $scope.munici;
        };


        /* Función para guardar */
        $scope.guardarDatos = function(formData) {

            $scope.ruta = '{!! url( "store" ) !!}';
            /* Se envían los datos del formulario por Ajax */
            $http.post( $scope.ruta ,
                {
                    _token : $("input[name='_token']").val(),
                     email : $('input[name=email]').val(),
                    municipio : formData.muni['mun'],
                    departamento : formData.departamento['nombre_dep'],
                }).then(function successCallback(response,data) {
                /* Agrega la fila al tabla componente ng-table */
                $scope.data.push(response.data.reg);
                /* Funciòn reinicar foirmulario */
                $scope.reset();

            }, function errorCallback(response,data,message,errors) {
                /* Lista de Errores */
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each( response.data.errors , function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $( '#validation' ).html( errorsHtml );
            });
        };


        /* tabla de registro - Ng Table - Componente */
        $scope.tableParams = new ngTableParams({
            page        : 1,
            count       :  10,
        },
            {
                total: $scope.reg.length,
                getData: function ($defer, params) {
                    $scope.data = $scope.reg.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    $defer.resolve($scope.data);
                }
            });

        /* Función para Elimina  el Registro */
        $scope.borrarRegistro = function (index) {
            /* Función de llamar el modal con el diseño de Verificar para eliminar */
            var modalInstance = $modal.open({
                animation: $scope.animationsEnabled,
                templateUrl: '{!! route( "confirmar" ) !!}',
                controller: 'ModalConfirmarCtrl',
                size: 'md',
                resolve: {
                    index: function () {
                        /* Indice selecionado de la tabla de registro */
                        return $scope.reg[index];
                    },
                    description: function () {
                        return 'Desea eliminar el registro ';
                    }
                }
            });
            /*Interaciòn de la respuesta del modal */
            /* llama a la ruta de eliminaciòn en el controlador */
            modalInstance.result.then(function (index) {
                $http.post( '{!! route( "eliminar" ) !!}' ,
                    {
                        registro : index
                    }).then(function successCallback(response,data) {
                    /* Quita la fila de registro */
                    $scope.data.splice($scope.reg.indexOf(index),1);

                }), function errorCallback(response,data) {
                    $scope.error   = "Error al tratar de eliminar un registro.";

                };
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
    });
    /* Controlador del modal angularjs */
    angularApp.controller('ModalConfirmarCtrl', function ($scope, $log, $modalInstance, index, description) {
        $scope.codigo = index;
        $scope.description = description;
        /* función para cerrar y enviar datos */
        $scope.ok = function () {
            $modalInstance.close($scope.codigo);
        };
        /* función para cerrar y no enviar datos */
        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });

</script>
