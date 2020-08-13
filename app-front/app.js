angular.module("NotesApp", ["ngStorage","ngRoute"])

.run(function ($rootScope) {
    $rootScope.urlServer = "API_URL"
})

.config(function ($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "templates/login.html",
            controller: "LoginController"
        })
        .when("/notes", {
            templateUrl: "templates/notes.html",
            controller: "NotesController"
        })
})