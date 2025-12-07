URL Shortner

A multi URL shortener built with Laravel, where:

- There can be multiple **companies**
- Each company has multiple **users**
- Each user has a **role**: `SuperAdmin`, `Admin`, or `Member`
- `Admin` and `Member` can create short URLs
- `SuperAdmin` can manage companies/users and see all URLs, but **cannot** create short URLs

---

## Table of Contents

- [Project Summary](#project-summary)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Migration & Seeding](#database-migration--seeding)
- [Running the Application](#running-the-application)
- [Authentication & Roles](#authentication--roles)
  - [SuperAdmin](#superadmin)
  - [Admin](#admin)
  - [Member](#member)
- [URL Shortening Rules](#url-shortening-rules)
- [Project Structure (High-Level)](#project-structure-high-level)
- [Troubleshooting](#troubleshooting)

---

## Project Summary

This service allows users to generate short URLs inside a multi-company environment.

**Core rules:**

- The app supports **multiple companies**.
- Each company has **multiple users**.
- Each user has a **role**:
  - `SuperAdmin`
  - `Admin`
  - `Member`
- **Invitation flow**:
  - `SuperAdmin` can invite an `Admin` in a new company.
  - `Admin` can invite another `Admin` or `Member` in their own company.
- **Short URL creation**:
  - `Admin` and `Member` can create short URLs.
  - `SuperAdmin` cannot create short URLs.
- **Visibility**:
  - `SuperAdmin` can see **all** short URLs across all companies.
  - `Admin` can see **all** short URLs within **their own company**.
  - `Member` can see only the URLs **created by themselves**.
- Short URLs are publicly resolvable and redirect to the original URL.

---

## Features

- Multi-tenant (Company-based) design
- Role-based access control:
  - `SuperAdmin`, `Admin`, `Member`
- Invitation system:
  - `SuperAdmin` → invite `Admin` + company creation
  - `Admin` → invite `Admin` or `Member` within same company
- URL Shortener:
  - Generates unique `short_code` for each URL
  - Public redirect endpoint for short links
- Authorization rules enforced in controllers:
  - Who can create URLs
  - Which URLs each role can see
- Basic HTML views (no heavy CSS required; can be extended)

---

## Tech Stack

- **Language:** PHP (>= 8.2 recommended)
- **Framework:** Laravel 10 / 11 / 12 (this project is built on Laravel 11.x)
- **Database:** MySQL 
- **Authentication:** Laravel authentication scaffolding ( Breeze )
- **Others:**
  - Composer for PHP dependencies


---

## Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.2
- **Composer**
- **MySQL** 
- **Node.js & NPM**
- **XAMAPP**
- **Git** (optional but recommended)

---

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/RAJ-RATHORE07/URL-Shortner.git
   cd URL-Shortner

2 .Install PHP dependencies
composer create-project laravel/laravel url-shortener
cd url-shortener
    
3. Copy environment file
  cp .env.example .env

4 .Generate application key
php artisan key:generate


5. Database Migration & Seeding
Run migrations to create the tables:
php artisan migrate


Then run seeders to create the default roles, permissions, companies, and the initial SuperAdmin user:
php artisan db:seed
php artisan db:seed --class=SuperAdminSeeder

6.Running the Application
Start the Laravel development server
php artisan serve

The app will usually be available at:
**http://127.0.0.1:8000**

