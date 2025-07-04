# 📨 Postman Collection Viewer

**Turn Your Postman Collections into Interactive API Docs.**

`Postman Collection Viewer` is an open-source Laravel-based tool that transforms your Postman collections into clean, navigable, and interactive API documentation — much like Swagger UI, but powered by Postman’s export format.

---

## 🚀 Features

- 📁 Import any Postman Collection (v2.1)
- 📚 Auto-generate clean, organized API documentation
- 📤 Test endpoints directly from the UI
- 🔍 View request/response parameters, headers, and bodies
- 🧩 Easy integration with Laravel projects
- 🌐 Web-based interface – perfect for teams and API consumers

---

## 📷 Screenshot

> _(Add a screenshot or demo GIF here to help users understand the UI quickly)_

---

## 📦 Installation

### Requirements

- PHP >= 8.1
- Composer
- Laravel >= 10.x
- Node.js & npm (for frontend assets)
- MySQL/PostgreSQL/SQLite supported

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/babulmirdha/postman-collection-viewer.git

# 2. Move into the project directory
cd postman-collection-viewer

# 3. Install PHP dependencies
composer install

# 4. Copy the .env file and set up your DB
cp .env.example .env
php artisan key:generate

# 5. Run migrations
php artisan migrate

# 6. Install frontend dependencies
npm install && npm run dev

# 7. Serve the app
php artisan serve
````

---

## 🧪 Usage

1. Export your collection from Postman in **v2.1 format**
2. Upload it via the UI or place it in the designated storage path (optional customization)
3. Browse and test endpoints through the generated interface

---

## 🛠️ Configuration

You can customize things like:

* Base URL or API environment
* Token headers or auth
* Viewer theme (coming soon)

---

## 🙌 Contributing

Contributions are welcome! Feel free to fork the repo, open issues, or submit pull requests.

```bash
# Format code before commit
composer fix
npm run format
```

---

## 📄 License

This project is open-sourced under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Babul Mirdha**
🔗 [LinkedIn](https://linkedin.com/in/your-profile)
📫 [babulmirdha@example.com](mailto:babulmirdha@example.com) (update this)

---

## ⭐️ Star the project

If you find this useful, please consider giving it a ⭐ on GitHub — it helps others discover it!

```

