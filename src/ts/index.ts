import { __, getConfig, setConfig, trans, type ReplacementValues, type ZorahConfig } from './client.js';
import { ZorahSSR, type ZorahSSRPlugin } from './ssr.js';
import { ZorahVue, type ZorahVuePlugin } from './vue.js';

export { __, getConfig, setConfig, trans, ZorahSSR, ZorahVue };
export type { ReplacementValues, ZorahConfig, ZorahSSRPlugin, ZorahVuePlugin };
