import type { ZorahConfig, ReplacementValues } from './client.js';

const getLocale = (): string => {
  // Vite uses import.meta.env
  if (typeof import.meta !== 'undefined' && import.meta.env?.VITE_LOCALE) {
    return import.meta.env.VITE_LOCALE as string;
  }

  // Webpack/Node uses process.env
  if (typeof process !== 'undefined' && process.env?.LOCALE) {
    return process.env.LOCALE;
  }

  return 'en';
};

export const trans = (key: string, replace?: ReplacementValues, Zorah?: ZorahConfig): string => {
  const locale = getLocale();

  let translation: unknown = null;

  try {
    translation = key
      .split('.')
      .reduce<unknown>((t, i) => (t as Record<string, unknown>)?.[i] ?? null, Zorah?.translations[locale]?.php);

    if (translation) {
      return checkForVariables(translation as string, replace);
    }
  } catch (e) {
    // Translation not found in php translations
  }

  try {
    const jsonTranslations = Zorah?.translations[locale]?.['json'];
    if (jsonTranslations && !Array.isArray(jsonTranslations)) {
      translation = jsonTranslations[key];
    }

    if (translation) {
      return checkForVariables(translation as string, replace);
    }
  } catch (e) {
    // Translation not found in json translations
  }

  return checkForVariables(key, replace);
};

export const checkForVariables = (translation: string, replace?: ReplacementValues): string => {
  let translated = translation;

  if (typeof replace === 'undefined') {
    return translation;
  }

  Object.entries(replace).forEach(([key, value]) => {
    translated = translated.toString().replace(':' + key, String(value));
  });

  return translated;
};
