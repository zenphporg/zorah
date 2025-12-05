import { trans, type ZorahConfig, type ReplacementValues } from './client.js';
import type { App } from 'vue';

export interface ZorahVuePlugin {
  install(app: App, options?: ZorahConfig): void;
}

// prettier-ignore
export const ZorahVue: ZorahVuePlugin = {
  install: (v: App, options?: ZorahConfig) => v.mixin({
    methods: {
      __(key: string, replace?: ReplacementValues, config: ZorahConfig | undefined = options) {
        return trans(key, replace, config)
      },
      trans(key: string, replace?: ReplacementValues, config: ZorahConfig | undefined = options) {
        return trans(key, replace, config)
      }
    }
  })
}
