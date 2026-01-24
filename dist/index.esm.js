var n,
  r = function (r) {
    n = r
  },
  t = function () {
    return n
  },
  u = function (r, t) {
    return i(r, t, n)
  },
  i = function (n, r, t) {
    var u = window.locale,
      i = null
    try {
      var l
      if (
        (i = n.split('.').reduce(
          function (n, r) {
            var t
            return null != (t = null == n ? void 0 : n[r]) ? t : null
          },
          null == t || null == (l = t.translations[u]) ? void 0 : l.php
        ))
      )
        return o(i, r)
    } catch (n) {}
    try {
      var e,
        c = null == t || null == (e = t.translations[u]) ? void 0 : e.json
      if ((c && !Array.isArray(c) && (i = c[n]), i)) return o(i, r)
    } catch (n) {}
    return o(n, r)
  },
  o = function (n, r) {
    var t = n
    return void 0 === r
      ? n
      : (Object.entries(r).forEach(function (n) {
          var r = n[0],
            u = n[1]
          t = t.toString().replace(':' + r, String(u))
        }),
        t)
  },
  l = function (n, r, t) {
    var u,
      i,
      o =
        void 0 !== import.meta && null != (u = import.meta.env) && u.VITE_LOCALE
          ? import.meta.env.VITE_LOCALE
          : 'undefined' != typeof process && null != (i = process.env) && i.LOCALE
            ? process.env.LOCALE
            : 'en',
      l = null
    try {
      var c
      if (
        (l = n.split('.').reduce(
          function (n, r) {
            var t
            return null != (t = null == n ? void 0 : n[r]) ? t : null
          },
          null == t || null == (c = t.translations[o]) ? void 0 : c.php
        ))
      )
        return e(l, r)
    } catch (n) {}
    try {
      var a,
        v = null == t || null == (a = t.translations[o]) ? void 0 : a.json
      if ((v && !Array.isArray(v) && (l = v[n]), l)) return e(l, r)
    } catch (n) {}
    return e(n, r)
  },
  e = function (n, r) {
    var t = n
    return void 0 === r
      ? n
      : (Object.entries(r).forEach(function (n) {
          var r = n[0],
            u = n[1]
          t = t.toString().replace(':' + r, String(u))
        }),
        t)
  },
  c = {
    install: function (n, r) {
      return n.mixin({
        methods: {
          __: function (n, t, u) {
            return (void 0 === u && (u = r), l(n, t, u))
          },
          trans: function (n, t, u) {
            return (void 0 === u && (u = r), l(n, t, u))
          },
        },
      })
    },
  },
  a = {
    install: function (n, t) {
      ;(t && r(t),
        n.mixin({
          methods: {
            __: function (n, r, u) {
              return (void 0 === u && (u = t), i(n, r, u))
            },
            trans: function (n, r, u) {
              return (void 0 === u && (u = t), i(n, r, u))
            },
          },
        }))
    },
  }
export { c as ZorahSSR, a as ZorahVue, u as __, t as getConfig, r as setConfig, i as trans }
