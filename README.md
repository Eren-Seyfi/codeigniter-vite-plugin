<p align="center">
  <img src="assets/codeIgniter.png" height="44" alt="CodeIgniter" />
  &nbsp;&nbsp;&nbsp;&nbsp;
  <img src="assets/vitejs.png" height="36" alt="Vite" />
</p>

# ⚡ CodeIgniter Vite Plugin

<p align="center">
  <a href="#-english">🇬🇧 English</a>
  &nbsp; • &nbsp;
  <a href="#-turkce">🇹🇷 Türkçe</a>
</p>

---

## 🇬🇧 English
<a id="-english"></a>

This plugin lets you include Vite-built CSS/JS assets in CodeIgniter 4 views in a **Laravel-like** way ✅

> ⚠️ **Note:** This is **not an official** package released by the CodeIgniter or Vite teams.  
> It is a third-party library developed independently.

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

### 📦 Installation

```bash
composer require eren-seyfi/codeigniter-vite-plugin
```

---

### 🚀 Usage

#### 1) 🧱 Generate Vite files
```bash
php spark vite:install
```

This command creates:
- ✅ `resources/js/app.js`
- ✅ `resources/css/app.css`
- ✅ `vite.config.mjs`

---

#### 2) ⚙️ Install Vite and build
```bash
npm init -y
npm i -D vite
```

Add scripts to `package.json`:
```json
"scripts": {
  "build": "vite build",
  "watch": "vite build --watch"
}
```

Build:
```bash
npm run build
```

💡 For auto rebuild during development:

```bash
npm run watch
```

---

#### 3) 🧩 Add it to your HTML

In your layout/view file, put this inside the **`<head>`** section:

```html
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My CI4 App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <h1>Hello 👋</h1>
  </body>
</html>
```

🎉 That’s it!

---

## 🇹🇷 Türkçe
<a id="-turkce"></a>

CodeIgniter 4 projelerinde Vite ile build edilen CSS/JS dosyalarını **Laravel benzeri** şekilde view içine eklemeni sağlar ✅

> ⚠️ **Not:** Bu kütüphane CodeIgniter veya Vite ekibi tarafından yayınlanan **resmi bir paket değildir**.  
> Bağımsız (third-party) bir geliştirici tarafından geliştirilmiştir.

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

### 📦 Kurulum

```bash
composer require eren-seyfi/codeigniter-vite-plugin
```

---

### 🚀 Kullanım

#### 1) 🧱 Vite dosyalarını oluştur
```bash
php spark vite:install
```

Bu komut şunları oluşturur:
- ✅ `resources/js/app.js`
- ✅ `resources/css/app.css`
- ✅ `vite.config.mjs`

---

#### 2) ⚙️ Vite’ı kur ve build al
```bash
npm init -y
npm i -D vite
```

`package.json` içine scripts ekle:
```json
"scripts": {
  "build": "vite build",
  "watch": "vite build --watch"
}
```

Build al:
```bash
npm run build
```

💡 Geliştirirken otomatik build için:

```bash
npm run watch
```

---

#### 3) 🧩 HTML içine ekle

Vite dosyalarını eklemek için layout/view dosyanda **`<head>` içine** şunu yaz:

```html
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My CI4 App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <h1>Merhaba 👋</h1>
  </body>
</html>
```

🎉 Hepsi bu!
