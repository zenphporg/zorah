export {};

declare global {
  interface Window {
    locale: string;
  }

  interface ImportMetaEnv {
    VITE_LOCALE?: string;
  }

  interface ImportMeta {
    env?: ImportMetaEnv;
  }
}
