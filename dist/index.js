const t = (t, n, e) => {
    const l = window.locale
    let c = null
    try {
      if (((c = t.split('.').reduce((t, r) => t[r] || null, e.translations[l].php)), c)) return r(c, n)
    } catch (t) {}
    try {
      if (((c = e.translations[l].json[t]), c)) return r(c, n)
    } catch (t) {}
    return r(t, n)
  },
  r = (t, r) => {
    let n = t
    return void 0 === r
      ? t
      : (Object.entries(r).forEach(([t, r]) => {
          n = n.toString().replace(':' + t, r)
        }),
        n)
  },
  n = {
    install: (r, n) => r.mixin({ methods: { t: (r, e, l = n) => t(r, e, l), trans: (r, e, l = n) => t(r, e, l) } }),
  },
  e = (t, r, n) => {
    const e = process.env.LOCALE
    let c = null
    try {
      if (((c = t.split('.').reduce((t, r) => t[r] || null, n.translations[e].php)), c)) return l(c, r)
    } catch (t) {}
    try {
      if (((c = n.translations[e].json[t]), c)) return l(c, r)
    } catch (t) {}
    return l(t, r)
  },
  l = (t, r) => {
    let n = t
    return void 0 === r
      ? t
      : (Object.entries(r).forEach(([t, r]) => {
          n = n.toString().replace(':' + t, r)
        }),
        n)
  },
  c = {
    install: (t, r) => t.mixin({ methods: { t: (t, n, l = r) => e(t, n, l), trans: (t, n, l = r) => e(t, n, l) } }),
  }
export { c as ZorahSSR, n as ZorahVue, t as trans }
