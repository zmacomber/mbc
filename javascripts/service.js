var mbcServices = angular.module('mbcServices', ['ngResource']);

mbcServices.factory('HomePageArticle', ['$resource',
    function(return $resource) {
        return $resource('api/home_page_article', {}, {
            query: { method:'GET' }
        });
    }]);
