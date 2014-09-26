'use strict';

describe('module: Shift.Sessions.Services', function() {

    beforeEach(module('Shift.Sessions.Services'));

    describe('Service: LoginService', function() {

        var LoginService, $http, $rootScope, $cookies;

        beforeEach(function(){
            angular.module('test', ['Shift.Sessions.Services'])
                .value('$cookies', $cookies = { username: '', remember: '' });
        });

        beforeEach(module('test'));

        beforeEach(inject(function(_LoginService_, _$rootScope_) {
            LoginService = _LoginService_;
            $rootScope = _$rootScope_;
        }));

        it('should contain empty string for cookies.username', function() {
            expect($cookies.username).toEqual('');
        });

        it('should contain empty string for cookies.remember', function() {
            expect($cookies.remember).toEqual('');
        });

        it('should update username (email) property', function() {
            expect($cookies.username).toEqual('');
            LoginService.updateUsername('MyUsername');
            expect(LoginService.username).toEqual('MyUsername');
        });

        it('should return empty session data as default', function() {
            var data = { remember: '', username: ''};
            expect(LoginService.getSessionData()).toEqual(data);
        });

        it('should return modified session data when updated', function() {
            var data = { remember: '1', username: 'MyUsername'};
            LoginService.setRememberMe(data)
            expect(LoginService.getSessionData()).toEqual(data);
        });


    });
});