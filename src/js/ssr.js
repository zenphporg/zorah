import { trans } from './server.js'
// prettier-ignore
export const ZorahSSR = {
	install: (v, options) => v.mixin({
    methods: {
      __: (key, replace, config = options) => trans(key, replace, config),
      trans: (key, replace, config = options) => trans(key, replace, config)
    }
  })
}
