var n = function (n, t, u) {
    var i = window.locale,
      l = null
    try {
      var o
      if (
        (l = n.split('.').reduce(
          function (n, r) {
            var t
            return null != (t = null == n ? void 0 : n[r]) ? t : null
          },
          null == u || null == (o = u.translations[i]) ? void 0 : o.php
        ))
      )
        return r(l, t)
    } catch (n) {}
    try {
      var e,
        a = null == u || null == (e = u.translations[i]) ? void 0 : e.json
      if ((a && !Array.isArray(a) && (l = a[n]), l)) return r(l, t)
    } catch (n) {}
    return r(n, t)
  },
  r = function (n, r) {
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
  t = {
    install: function (r, t) {
      return r.mixin({
        methods: {
          __: function (r, u, i) {
            return (void 0 === i && (i = t), n(r, u, i))
          },
          trans: function (r, u, i) {
            return (void 0 === i && (i = t), n(r, u, i))
          },
        },
      })
    },
  },
  u = function (n, r, t) {
    var u,
      l,
      o =
        void 0 !== import.meta && null != (u = import.meta.env) && u.VITE_LOCALE
          ? import.meta.env.VITE_LOCALE
          : 'undefined' != typeof process && null != (l = process.env) && l.LOCALE
            ? process.env.LOCALE
            : 'en',
      e = null
    try {
      var a
      if (
        (e = n.split('.').reduce(
          function (n, r) {
            var t
            return null != (t = null == n ? void 0 : n[r]) ? t : null
          },
          null == t || null == (a = t.translations[o]) ? void 0 : a.php
        ))
      )
        return i(e, r)
    } catch (n) {}
    try {
      var c,
        v = null == t || null == (c = t.translations[o]) ? void 0 : c.json
      if ((v && !Array.isArray(v) && (e = v[n]), e)) return i(e, r)
    } catch (n) {}
    return i(n, r)
  },
  i = function (n, r) {
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
  l = {
    install: function (n, r) {
      return n.mixin({
        methods: {
          __: function (n, t, i) {
            return (void 0 === i && (i = r), u(n, t, i))
          },
          trans: function (n, t, i) {
            return (void 0 === i && (i = r), u(n, t, i))
          },
        },
      })
    },
  }
export { l as ZorahSSR, t as ZorahVue, n as trans }
