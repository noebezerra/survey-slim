(function(){
    'use strict';

    var module = angular.module('Pagination', []);

    module.service('SeverPaginate', function($http) {
        //variáveis de configuração
        var data = {};
        var current = 0;
        var perPage = 0;
        var total = 0;

        var next = null;
        var prev = null;

        var goToPage = function(url) {
        
        }

        //Seta a configuração da paginação
        var configure = function(config) {
            if (config.data !== undefined) {
                data = config.data;
                if (perPage == 0) {
                    perPage = config.data.length;
                }
            }

            next = null;
            if (config.next !== undefined) {
                next = config.next;
            }

            prev = null;
            if (config.prev !== undefined) {
                prev = config.prev;
            }
            if (config.total !== undefined) {
                total = config.total;
            }

            //aqui onde recebo o goToPage()
            if (config.goToPage !== undefined) {
                goToPage = config.goToPage;
            }
        }

        //retorna os dados
        var getData = function(response) {
            var from = current*perPage+1;
            var to = (from+perPage)-1;

            if (to > total) {
                to = total;
            }
            return getData = {
                result : {
                    data: data,
                    from: from,
                    to: to
                },
                total : total,
                next : function() {
                    console.log(next);
                    if (next !== null) {
                        current++;
                        goToPage(next);
                    }
                },
                prev : function() {
                    if (prev !== null) {
                        current--;
                        goToPage(prev);
                    }
                }
            };
        }

        this.configure = configure;
        this.getData = getData;

    });
})()