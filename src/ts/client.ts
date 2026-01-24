export interface ZorahConfig {
  translations: {
    [locale: string]: {
      php: { [key: string]: unknown };
      json: { [key: string]: string } | string[];
    };
  };
}

export type ReplacementValues = { [key: string]: string | number };

let _config: ZorahConfig | undefined;

export const setConfig = (config: ZorahConfig): void => {
  _config = config;
};

export const getConfig = (): ZorahConfig | undefined => {
  return _config;
};

export const __ = (key: string, replace?: ReplacementValues): string => {
  return trans(key, replace, _config);
};

export const trans = (key: string, replace?: ReplacementValues, Zorah?: ZorahConfig): string => {
  const locale = window.locale;

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
