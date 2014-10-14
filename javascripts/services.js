var mbcServices = angular.module('mbcServices', []);

mbcServices.factory('HomePageArticle', ['$resource',
    function($resource) {
        return $resource('http://localhost:3000/api/home_page_article');
    }
]);
