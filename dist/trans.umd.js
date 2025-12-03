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
            f = n[1]
          t = t.toString().replace(':' + e, f)
        }),
        t)
  }
  return function (e, t, f) {
    var i = window.locale,
      o = null
    try {
      if (
        (o = e.split('.').reduce(function (n, e) {
          return n[e] || null
        }, f.translations[i].php))
      )
        return n(o, t)
    } catch (n) {}
    try {
      if ((o = f.translations[i].json[e])) return n(o, t)
    } catch (n) {}
    return n(e, t)
  }
})
