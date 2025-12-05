import { type ZorahConfig } from './client.js';
import type { App } from 'vue';
export interface ZorahVuePlugin {
  install(app: App, options?: ZorahConfig): void;
}
export declare const ZorahVue: ZorahVuePlugin;
