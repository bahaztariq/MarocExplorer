# 🌍 MarocExplorer

**MarocExplorer** is a RESTful API built with **Laravel** that allows users to discover and explore Morocco — its destinations, cultural activities, traditional dishes, and custom travel itineraries. Users can create personalised itineraries and save their favourites.

---

## 🚀 Features

- 🔐 **Authentication** — Register, login, and logout via Laravel Sanctum (token-based)
- 🗺️ **Itineraires** — Create, view, update, and delete travel itineraries
- 📍 **Destinations** — Explore Moroccan destinations linked to itineraries
- 🎭 **Activities** — Discover cultural and tourist activities per destination
- 🍜 **Dishes** — Browse traditional Moroccan dishes per destination
- ❤️ **Favourites** — Save and manage favourite itineraries (Many-to-Many)
- 🔍 **Search** — Search across destinations, activities, and dishes

---

## 🏗️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 11 |
| Auth | Laravel Sanctum |
| Database | MySQL |
| Language | PHP 8.x |

---

## 📦 Installation

```bash
# Clone the repository
git clone https://github.com/your-username/MarocExplorer.git
cd MarocExplorer

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure your database in .env, then run migrations
php artisan migrate

# Start the server
php artisan serve
```

---

## 🗄️ Database Schema

```
users
 ├── itineraires       (one-to-many)
 └── favourites        (many-to-many with itineraires)

itineraires
 └── destinations      (one-to-many)
      ├── activities   (one-to-many)
      ├── dishes       (one-to-many)
      └── images       (polymorphic)
```

---

## 📡 API Endpoints

All routes are prefixed with `/api/v1`. Protected routes require a Bearer token.

### Auth
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/register` | ❌ | Register a new user |
| POST | `/login` | ❌ | Login and get token |
| POST | `/logout` | ✅ | Logout and revoke token |

### Users
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/users` | ✅ | Get authenticated user |
| PUT | `/users/{id}` | ✅ | Update user profile |
| DELETE | `/users/{id}` | ✅ | Delete user account |

### Itineraires
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/itineraires` | ✅ | List all itineraries |
| POST | `/itineraires` | ✅ | Create an itinerary |
| GET | `/itineraires/{id}` | ✅ | Get a single itinerary |
| PUT | `/itineraires/{id}` | ✅ | Update an itinerary |
| DELETE | `/itineraires/{id}` | ✅ | Delete an itinerary |
| GET | `/itineraires/search/{query}` | ✅ | Search itineraries |

### Destinations
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/destinations` | ✅ | List all destinations |
| GET | `/destinations/{id}` | ✅ | Get a destination |
| GET | `/destinations/search/{query}` | ✅ | Search destinations |

### Activities
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/activities` | ✅ | List all activities |
| GET | `/activities/{id}` | ✅ | Get an activity |
| GET | `/activities/search/{query}` | ✅ | Search activities |

### Dishes
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/dishes` | ✅ | List all dishes |
| GET | `/dishes/{id}` | ✅ | Get a dish |
| GET | `/dishes/search/{query}` | ✅ | Search dishes |

### Favourites
| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/favourites` | ✅ | List user's favourite itineraries |
| POST | `/favourites/{itineraire}` | ✅ | Toggle favourite (add/remove) |
| GET | `/favourites/{itineraire}/check` | ✅ | Check if itinerary is favourited |

---

## 🔐 Authentication

This API uses **Laravel Sanctum** for token-based authentication.

Include the token in every protected request:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 👤 Author

Built by Tariq Bahaz.
