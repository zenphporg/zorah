var n = function (n, t, u) {
    var e = window.locale,
      o = null;
    try {
      var i;
      if (
        (o = n.split('.').reduce(
          function (n, r) {
            var t;
            return null != (t = null == n ? void 0 : n[r]) ? t : null;
          },
          null == u || null == (i = u.translations[e]) ? void 0 : i.php,
        ))
      )
        return r(o, t);
    } catch (n) {}
    try {
      var l,
        c = null == u || null == (l = u.translations[e]) ? void 0 : l.json;
      if ((c && !Array.isArray(c) && (o = c[n]), o)) return r(o, t);
    } catch (n) {}
    return r(n, t);
  },
  r = function (n, r) {
    var t = n;
    return void 0 === r
      ? n
      : (Object.entries(r).forEach(function (n) {
          var r = n[0],
            u = n[1];
          t = t.toString().replace(':' + r, String(u));
        }),
        t);
  },
  t = {
    install: function (r, t) {
      return r.mixin({
        methods: {
          __: function (r, u, e) {
            return (void 0 === e && (e = t), n(r, u, e));
          },
          trans: function (r, u, e) {
            return (void 0 === e && (e = t), n(r, u, e));
          },
        },
      });
    },
  },
  u = function (n, r, t) {
    var u,
      o,
      i =
        void 0 !==
          {
            url:
              'undefined' == typeof document
                ? new (require('url').URL)('file:' + __filename).href
                : (document.currentScript &&
                    'SCRIPT' === document.currentScript.tagName.toUpperCase() &&
                    document.currentScript.src) ||
                  new URL('index.cjs', document.baseURI).href,
          } &&
        null != (u = void 0) &&
        u.VITE_LOCALE
          ? (void 0).VITE_LOCALE
          : 'undefined' != typeof process && null != (o = process.env) && o.LOCALE
            ? process.env.LOCALE
            : 'en',
      l = null;
    try {
      var c;
      if (
        (l = n.split('.').reduce(
          function (n, r) {
            var t;
            return null != (t = null == n ? void 0 : n[r]) ? t : null;
          },
          null == t || null == (c = t.translations[i]) ? void 0 : c.php,
        ))
      )
        return e(l, r);
    } catch (n) {}
    try {
      var d,
        v = null == t || null == (d = t.translations[i]) ? void 0 : d.json;
      if ((v && !Array.isArray(v) && (l = v[n]), l)) return e(l, r);
    } catch (n) {}
    return e(n, r);
  },
  e = function (n, r) {
    var t = n;
    return void 0 === r
      ? n
      : (Object.entries(r).forEach(function (n) {
          var r = n[0],
            u = n[1];
          t = t.toString().replace(':' + r, String(u));
        }),
        t);
  };
((exports.ZorahSSR = {
  install: function (n, r) {
    return n.mixin({
      methods: {
        __: function (n, t, e) {
          return (void 0 === e && (e = r), u(n, t, e));
        },
        trans: function (n, t, e) {
          return (void 0 === e && (e = r), u(n, t, e));
        },
      },
    });
  },
}),
  (exports.ZorahVue = t),
  (exports.trans = n));
