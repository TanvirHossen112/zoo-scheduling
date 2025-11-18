# 🦁 Zoo Scheduling System

A modern Laravel + Vue.js application for managing zoo visitor schedules with time slot availability tracking and
visitor analytics.

## 📋 Features

- **Visitor Schedule Management**
    - Schedule zoo visits with date and time slot selection
    - Support multiple visitors per booking (up to 3)
    - Dynamic time slot availability based on capacity (200 visitors per slot)
    - Real-time validation with error feedback

- **Membership Number Validation**
    - Custom validation rule with checksum algorithm
    - Format: `XXXX-XXXX-XX` (10 digits with hyphens after 4th and 8th positions)
    - Checksum verification: First 8 digits modulo 97 equals last 2 digits
    - Example: `1147-2239-49` (11472239 % 97 = 49)

- **Analytics Dashboard**
    - Date-wise visitor count visualization
    - Interactive date range filtering
    - Chart.js integration for graphical representation

- **Modern UI/UX**
    - Vue.js 3 with Composition API
    - Tailwind CSS 4 styling
    - Real-time form validation
    - Responsive design

## 🛠️ Tech Stack

- **Backend:** Laravel 12.38.1 (PHP 8.3)
- **Frontend:** Vue.js 3.5.24
- **Styling:** Tailwind CSS 4.0.0
- **Database:** MySQL
- **Build Tool:** Vite 7.0.7
- **Testing:** Pest PHP
- **Package Manager:** npm

## 📦 Installation

### Prerequisites

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd zoo-scheduling
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**

   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=zoo_scheduling
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Build Frontend Assets**
   ```bash
   npm run dev
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Visit: `http://localhost:8000`

## 🗄️ Database Schema

### `visitor_schedules` Table

| Column              | Type      | Description                                       |
|---------------------|-----------|---------------------------------------------------|
| `id`                | bigint    | Primary key                                       |
| `uuid`              | uuid      | Group identifier for multi-visitor bookings       |
| `date`              | date      | Visit date                                        |
| `timeslot`          | int       | Time slot (10, 12, 14, or 16)                     |
| `first_name`        | string    | Visitor first name                                |
| `last_name`         | string    | Visitor last name (nullable)                      |
| `membership_number` | string    | Unique membership number with checksum (nullable) |
| `created_at`        | timestamp | Creation timestamp                                |
| `updated_at`        | timestamp | Update timestamp                                  |

## 🔌 API Endpoints

### Schedule Visitor

**POST** `/api/v1/schedule`

Create a new visitor schedule with one or multiple visitors.

**Request Body:**

```json
{
  "date": "2025-11-20",
  "timeslot": 10,
  "visitors": [
    {
      "first_name": "John",
      "last_name": "Doe",
      "membership_number": "1147-2239-49"
    },
    {
      "first_name": "Jane",
      "last_name": "Doe",
      "membership_number": "1234-5678-42"
    }
  ]
}
