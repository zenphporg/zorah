// File: index.d.ts

declare module 'zorah-js' {
  export interface ZorahConfig {
    translations: {
      [locale: string]: {
        php: { [key: string]: any };
        json: { [key: string]: string };
      };
    };
  }

  export interface ZorahOptions extends ZorahConfig {}

  export type TranslationKey = string;
  export type ReplacementValues = { [key: string]: string | number };

  export function trans(key: TranslationKey, replace?: ReplacementValues, config?: ZorahConfig): string;

  export const ZorahVue: {
    install(app: any, options?: ZorahOptions): void;
  };

  export const ZorahSSR: {
    install(app: any, options?: ZorahOptions): void;
  };
}

// Extend Vue's global properties
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    __: (key: string, replace?: { [key: string]: string | number }, config?: import('zorah-js').ZorahConfig) => string;
    trans: (
      key: string,
      replace?: { [key: string]: string | number },
      config?: import('zorah-js').ZorahConfig
    ) => string;
  }
}

// Extend the global Window interface
declare global {
  interface Window {
    locale: string;
  }
}
