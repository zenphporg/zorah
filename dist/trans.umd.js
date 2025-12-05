!(function (n, e) {
  'object' == typeof exports && 'undefined' != typeof module
    ? (module.exports = e())
    : 'function' == typeof define && define.amd
      ? define(e)
      : ((n || self).trans = e())
})(this, function () {
  var n = function (n, e) {
    var t = n
    return void 0 === e
      ? n
      : (Object.entries(e).forEach(function (n) {
          var e = n[0],
            r = n[1]
          t = t.toString().replace(':' + e, String(r))
        }),
        t)
  }
  return function (e, t, r) {
    var u = window.locale,
      i = null
    try {
      var l
      if (
        (i = e.split('.').reduce(
          function (n, e) {
            var t
            return null != (t = null == n ? void 0 : n[e]) ? t : null
          },
          null == r || null == (l = r.translations[u]) ? void 0 : l.php
        ))
      )
        return n(i, t)
    } catch (n) {}
    try {
      var o,
        f = null == r || null == (o = r.translations[u]) ? void 0 : o.json
      if ((f && !Array.isArray(f) && (i = f[e]), i)) return n(i, t)
    } catch (n) {}
    return n(e, t)
  }
})
