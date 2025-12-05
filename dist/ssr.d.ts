import type { ZorahConfig } from './client.js';
import type { App } from 'vue';
export interface ZorahSSRPlugin {
  install(app: App, options?: ZorahConfig): void;
}
export declare const ZorahSSR: ZorahSSRPlugin;
