import type { App } from 'vue';
import { setConfig, trans, type ReplacementValues, type ZorahConfig } from './client.js';

export interface ZorahVuePlugin {
  install(app: App, options?: ZorahConfig): void;
}

// prettier-ignore
export const ZorahVue: ZorahVuePlugin = {
  install: (v: App, options?: ZorahConfig) => {
    if (options) {
      setConfig(options);
    }
    v.mixin({
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
}
