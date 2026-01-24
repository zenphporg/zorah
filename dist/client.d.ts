export interface ZorahConfig {
  translations: {
    [locale: string]: {
      php: {
        [key: string]: unknown;
      };
      json:
        | {
            [key: string]: string;
          }
        | string[];
    };
  };
}
export type ReplacementValues = {
  [key: string]: string | number;
};
export declare const setConfig: (config: ZorahConfig) => void;
export declare const getConfig: () => ZorahConfig | undefined;
export declare const __: (key: string, replace?: ReplacementValues) => string;
export declare const trans: (key: string, replace?: ReplacementValues, Zorah?: ZorahConfig) => string;
export declare const checkForVariables: (translation: string, replace?: ReplacementValues) => string;
