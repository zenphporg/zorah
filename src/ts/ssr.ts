import { trans } from './server.js';
import type { ZorahConfig, ReplacementValues } from './client.js';
import type { App } from 'vue';

export interface ZorahSSRPlugin {
  install(app: App, options?: ZorahConfig): void;
}

// prettier-ignore
export const ZorahSSR: ZorahSSRPlugin = {
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
