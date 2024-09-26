import { trans } from './client.js'
// prettier-ignore
export const ZorahVue = {
	install: (v, options) => v.mixin({
    methods: {
      __: (key, replace, config = options) => trans(key, replace, config),
      trans: (key, replace, config = options) => trans(key, replace, config)
    }
  })
}
