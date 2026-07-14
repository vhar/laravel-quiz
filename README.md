# Laravel Quiz

Laravel package for managing quizzes and related entities inside a Laravel application.

> **Pet project notice**
>
> This package is part of a personal pet project and is developed for educational and architectural purposes.
>
> The package is not intended as a standalone production-ready Laravel package.
> It is committed together with the main Laravel application codebase.

---

## About

Laravel Quiz provides the application layer and domain logic required to create and manage quizzes.

The package is responsible for handling quiz lifecycle operations, including creating quizzes, retrieving quiz data, updating quiz content and settings, and applying business rules related to quiz configuration.

The package follows Laravel application architecture principles with separation between:

- HTTP layer
- Application layer
- Domain rules
- Data models
- Authorization logic

---

## Purpose

The main goal of this package is to provide a structured foundation for building a quiz platform.

It is designed to support:

- creating different types of quizzes;
- managing quiz settings;
- validating quiz-specific business rules;
- controlling access to quiz editing;
- integrating file attachments;
- extending the system with additional quiz-related entities.

---

## Architecture

The package uses a layered architecture:

```
Quiz
│
├── Http
│   └── API controllers, requests and resources
│
├── Application
│   ├── Commands
│   ├── Queries
│   ├── Mappers
│   ├── Services
│   ├── Policies
│   ├── Scopes
│   ├── Views
│   └── Data
│
├── Models
│
├── Enums
│
└── Rules
```

### Application layer

The application layer contains use cases and business operations:

- commands for state changes;
- queries for retrieving data;
- handlers responsible for executing operations;
- services responsible for reusable application logic.

---

## Features

Current functionality includes:

- quiz creation;
- quiz retrieval;
- quiz updating;
- validation of quiz business rules;
- enum-based quiz configuration;
- authorization of quiz editing;
- policy-based access control;
- file attachment integration;
- API resources for response transformation.

---

## Integration

The package is designed to run as part of a Laravel application.

It is not distributed as an isolated Composer package.

The package source code is included directly in the Laravel application repository:

```
Laravel application
│
├── app/
│
├── packages/
│   └── Vhar/
│       └── Quiz/
│
└── composer.json
```

---

## Development status

The project is under active development.

The current implementation focuses on building a clean and extensible backend architecture for a quiz platform.

Future entities may include:

- questions;
- answers;
- scoring rules;
- quiz attempts;
- user progress tracking;
- moderation features.

---

## License

This project is a personal pet project.