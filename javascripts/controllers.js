var mbcControllers = angular.module('mbcControllers', []);

mbcControllers.controller('MbcCtrl', ['$scope', 'HomePageArticle',
    function($scope, HomePageArticle) {
        HomePageArticle.get(function(success) {
            console.log(success);
            $scope.homePageArticle = success;
        });
    }
]);
