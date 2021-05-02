<script>

    var angularApp = angular.module( 'welcomeApp', [ 'ngTable','ui.bootstrap'] );
    angularApp.config(function($interpolateProvider , $httpProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    });

    angularApp.controller( 'listaCtrl', function(   $scope , $http, $timeout, $log, $filter, ngTableParams ,$modal){
        /*Inicializar variables*/
        $scope.reg = {!! $datos !!};

        $scope.airplanes = [];
        $http.get('dep-mun.json').then(function(data) {
            $scope.airplanes = data
        });

        $scope.students = [{ name: 'John' }, { name: 'Smith' }, { name: 'Allen' }, { name: 'Johnson' }, { name: 'Harris' }, { name: 'Williams' }, { name: 'David' }];
        /*Función para guardar */
        $scope.guardarDatos = function() {
            $scope.ruta = '{!! url( "store" ) !!}';
            /*Se envían los datos del formulario por ajax*/
            $http.post( $scope.ruta ,
                {
                    _token : $("input[name='_token']").val(),
                    email : $('input[name=email]').val(),
                    municipio : $('input[name=municipio]').val(),
                    departamento: $('input[name=departamento]').val()
                }).then(function successCallback(response,data) {
                $scope.reg.push(response.data.reg);
            }, function errorCallback(response,data,message,errors) {

                    //process validation errors here.
                    console.log(response.data.errors);
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each( response.data.errors , function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $( '#validation' ).html( errorsHtml );


            });
        };
        $scope.tableParams = new ngTableParams({
            page        : 1 ,
            count       :  2,

        },
            {
                total: $scope.reg.length,
                getData: function ($defer, params) {
                    $scope.data = $scope.reg.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    $defer.resolve($scope.data);
                }
            });

        /* Función para borrar el trámite */
        $scope.borrarRegistro = function (index) {
            console.log(index);
            var modalInstance = $modal.open({
                animation: $scope.animationsEnabled,
                templateUrl: '{!! route( "confirmar" ) !!}',
                controller: 'ModalConfirmarCtrl',
                size: 'md',
                resolve: {
                    index: function () {
                        // return index;
                        return $scope.reg[index];
                    },
                    description: function () {
                        return 'Desea eliminar el registro ';
                    }
                }
            });
            modalInstance.result.then(function (index) {
                $http.post( '{!! route( "eliminar" ) !!}' ,
                    {
                        registro : index
                    }).then(function successCallback(response,data) {
                        console.log(response)
                    $scope.mensaje = "Regitro eliminado.";
                    $scope.reg.splice(index, 1);
                }), function errorCallback(response,data) {
                    $scope.error   = "Error al tratar de eliminar un registro.";
                    // $timeout(function(){$scope.error = '';},6000);
                };
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
    });
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
