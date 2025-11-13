'use strict';

// Simple mock for blockUI to avoid CDN dependency issues
angular.module('blockUI', [])
  .provider('blockUIConfig', function blockUIConfigProvider() {
    this.template = function(val) {};
    this.$get = function() {
      return {};
    };
  })
  .factory('blockUI', function() {
    var instanceStore = {};
    
    return {
      instances: {
        get: function(name) {
          if (!name) return instanceStore;
          if (!instanceStore[name]) {
            instanceStore[name] = {
              start: function() {},
              stop: function() {},
              reset: function() {}
            };
          }
          return instanceStore[name];
        }
      },
      start: function() {},
      stop: function() {},
      reset: function() {}
    };
  });


