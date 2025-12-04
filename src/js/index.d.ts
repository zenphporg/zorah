// File: index.d.ts
export {};

declare module 'zorah-js' {
  export interface ZorahConfig {
    translations: {
      [locale: string]: {
        php: { [key: string]: any };
        json: { [key: string]: string } | string[];
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

// Extend the global Window interface
declare global {
  interface Window {
    locale: string;
  }
}
