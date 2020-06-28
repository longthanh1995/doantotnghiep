// Generated by CoffeeScript 1.10.0
(function() {
  var plugin,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  plugin = function(core, options) {
    var install, methods;
    if (options == null) {
      options = {};
    }
    methods = ["register", "start", "stop", "on", "off", "emit"];
    install = function(sb, subCore) {
      var fn, fn1, i, len;
      sb.sub = {};
      fn1 = (function(_this) {
        return function(fn) {
          return sb.sub[fn] = function() {
            subCore[fn].apply(subCore, arguments);
            return sb;
          };
        };
      })(this);
      for (i = 0, len = methods.length; i < len; i++) {
        fn = methods[i];
        fn1(fn);
      }
      if (subCore.permission != null) {
        return sb.sub.permission = {
          add: subCore.permission.add,
          remove: subCore.permission.remove
        };
      }
    };
    return {
      init: function(sb, opt, done) {
        var SubSandbox, i, j, len, len1, p, plugins, ref, ref1, ref2, subCore;
        sb._subCore = subCore = new core.constructor;
        if (options.useGlobalMediator) {
          core._mediator.installTo(subCore._mediator, true);
        } else if (options.mediator != null) {
          if ((ref = options.mediator) != null) {
            if (typeof ref.installTo === "function") {
              ref.installTo(subCore._mediator, true);
            }
          }
        }
        subCore.Sandbox = SubSandbox = (function(superClass) {
          extend(SubSandbox, superClass);

          function SubSandbox() {
            return SubSandbox.__super__.constructor.apply(this, arguments);
          }

          return SubSandbox;

        })(core.Sandbox);
        plugins = [];
        if (options.inherit) {
          ref1 = core._plugins;
          for (i = 0, len = ref1.length; i < len; i++) {
            p = ref1[i];
            plugins.push({
              plugin: p.creator,
              options: p.options
            });
          }
        }
        if (options.use instanceof Array) {
          ref2 = options.use;
          for (j = 0, len1 = ref2.length; j < len1; j++) {
            p = ref2[j];
            plugins.push(p);
          }
        } else if (typeof options.use === "function") {
          plugins.push(options.use);
        }
        return subCore.use(plugins).boot(function(err) {
          if (err) {
            return done(err);
          }
          install(sb, subCore);
          return done();
        });
      },
      destroy: function(sb) {
        return sb._subCore.stop();
      }
    };
  };

  if ((typeof define !== "undefined" && define !== null ? define.amd : void 0) != null) {
    define(function() {
      return plugin;
    });
  } else if ((typeof window !== "undefined" && window !== null ? window.scaleApp : void 0) != null) {
    window.scaleApp.plugins.submodule = plugin;
  } else if ((typeof module !== "undefined" && module !== null ? module.exports : void 0) != null) {
    module.exports = plugin;
  }

}).call(this);