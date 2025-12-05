import type { ZorahConfig, ReplacementValues } from './client.js';
export declare const trans: (key: string, replace?: ReplacementValues, Zorah?: ZorahConfig) => string;
export declare const checkForVariables: (translation: string, replace?: ReplacementValues) => string;
