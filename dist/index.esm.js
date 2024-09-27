var n = function (n, t, u) {
    var i = window.locale,
      c = null
    try {
      if (
        (c = n.split('.').reduce(function (n, r) {
          return n[r] || null
        }, u.translations[i].php))
      )
        return r(c, t)
    } catch (n) {}
    try {
      if ((c = u.translations[i].json[n])) return r(c, t)
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
          t = t.toString().replace(':' + r, u)
        }),
        t)
  },
  t = {
    install: function (r, t) {
      return r.mixin({
        methods: {
          t: function (r, u, i) {
            return void 0 === i && (i = t), n(r, u, i)
          },
          trans: function (r, u, i) {
            return void 0 === i && (i = t), n(r, u, i)
          },
        },
      })
    },
  },
  u = function (n, r, t) {
    var u = process.env.LOCALE,
      c = null
    try {
      if (
        (c = n.split('.').reduce(function (n, r) {
          return n[r] || null
        }, t.translations[u].php))
      )
        return i(c, r)
    } catch (n) {}
    try {
      if ((c = t.translations[u].json[n])) return i(c, r)
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
          t = t.toString().replace(':' + r, u)
        }),
        t)
  },
  c = {
    install: function (n, r) {
      return n.mixin({
        methods: {
          t: function (n, t, i) {
            return void 0 === i && (i = r), u(n, t, i)
          },
          trans: function (n, t, i) {
            return void 0 === i && (i = r), u(n, t, i)
          },
        },
      })
    },
  }
export { c as ZorahSSR, t as ZorahVue, n as trans }
