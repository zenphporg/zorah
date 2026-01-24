import type { App } from 'vue';
import { type ZorahConfig } from './client.js';
export interface ZorahVuePlugin {
  install(app: App, options?: ZorahConfig): void;
}
export declare const ZorahVue: ZorahVuePlugin;
