'use strict';

describe('module: Shift.Users.Filters', function() {
    var $filter;

    beforeEach(module('Shift.Users.Filters'));

    beforeEach(inject(function(_$filter_) {
        $filter = _$filter_;
    }));

    describe('filter: userStatus', function() {
        it('should return active for active user', function() {
            var user = { confirmation_token: '', confirmed_at: '2014-01-01 00:00:00' };
            expect($filter('userStatus')(user)).toEqual('Active');
        });
    });

    describe('filter: userStatus', function() {
        it('should return Awaiting confirmation for non-active user', function() {
            var user = { confirmation_token: 'abc123', confirmed_at: null };
            expect($filter('userStatus')(user)).toEqual('Awaiting confirmation');
        });
    });

    describe('filter: userStatus', function() {
        it('should return ACTIVATION ERROR with both token and confirmed_at', function() {
            var user = { confirmation_token: 'abc123', confirmed_at: '2014-01-01 00:00:00' };
            expect($filter('userStatus')(user)).toEqual('ACTIVATION ERROR');
        });
    });


    describe('filter: userStatus', function() {
        it('should return ACTIVATION ERROR with no token or confirm_at', function() {
            var user = { confirmation_token: null, confirmed_at: null };
            expect($filter('userStatus')(user)).toEqual('ACTIVATION ERROR');
        });
    });

});
