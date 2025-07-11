const Zorah = {
  translations: {
    en: { php: { messages: { hello: 'Hello' } }, json: [] },
    es: {
      php: { messages: { welcome: 'Welcome', hello: 'Hello :name' } },
      json: { Hello: 'Hola', Goodbye: 'Adi\u00f3s' },
    },
  },
}

if (typeof window !== 'undefined' && typeof window.Zorah !== 'undefined') {
  Object.assign(Zorah.translations, window.Zorah.translations)
}

export { Zorah }
