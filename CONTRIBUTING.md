# Contributing to Zorah

Thank you for considering contributing to Zorah! This document outlines the development workflow and requirements for contributing to this project.

## Requirements

Before you begin, ensure you have the following installed:

- **PHP 8.4+** - Required for development and testing
- **Composer** - For PHP dependency management
- **Bun** - For JavaScript package management and build tools
- **Git** - For version control

## Getting Started

### 1. Fork and Clone

1. Fork the repository on GitHub
2. Clone your fork locally:

```bash
git clone https://github.com/YOUR_USERNAME/zorah.git
cd zorah
```

### 2. Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
bun install
```

### 3. Set Up Development Environment

The project uses Orchestra Testbench for testing Laravel functionality. No additional setup is required as the tests create their own application instance.

**Important**: After cloning, run the following to set up Git hooks:

```bash
bunx husky
```

Then **remove the `prepare` script** from `package.json` to prevent CI failures:

```json
// Remove this line from package.json:
"prepare": "husky"
```

## Development Workflow

### Branch Management

- `main` - Latest development version
- `N.x` - Maintenance branches for major versions (e.g., `1.x`, `2.x`)

### Making Changes

1. **Create a feature branch** from `main`:

```bash
git checkout main
git pull origin main
git checkout -b feature/your-feature-name
```

2. **Make your changes** following the coding standards
3. **Write tests** for your changes (100% coverage expected)
4. **Run the test suite** to ensure everything passes

### Testing

This project maintains **100% test coverage** as a quality standard.

#### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test:coverage

# Run static analysis
composer analyze
```

#### Writing Tests

- Use **Pest** testing framework
- Write **functional tests** that verify actual behavior
- Avoid meaningless assertions like `expect(true)->toBeTrue()`
- Test real functionality, not just structural properties
- Ensure new code maintains 100% coverage

### Code Quality

#### Static Analysis

Run PHPStan for static analysis:

```bash
composer analyze
```

The project uses maximum static analysis level. All code must pass without errors.

#### Code Style

This project follows the **Zen.Foundation coding standard**:

- **2 spaces for indentation** (not 4 spaces or tabs)
- PSR-12 compliance with Zen.Foundation modifications
- Use `zenphp/fixr` for automatic code formatting

**Code Formatting:**

```bash
# Format code using zenphp/fixr (included as dev dependency)
composer fix

# Check code style without fixing
composer fix:check
```

The `zenphp/fixr` package in default mode produces beautiful 2-spaced code that follows our standards.

## Commit Guidelines

This project uses **Conventional Commits** for automated versioning and changelog generation. For complete details, see the [Conventional Commits specification](https://www.conventionalcommits.org/).

### Commit Message Format

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

### Commit Types

Listed in order of importance and release impact:

- `breaking`: Breaking changes (**major** version release)
- `feat`: A new feature (**minor** version release)
- `fix`: A bug fix (**patch** version release)
- `refactor`: Code refactoring without changing functionality (**patch** version release)
- `docs`: Documentation changes (**patch** version release)
- `task`: Code or other tasks (**patch** version release)
- `issue`: Non-bug issue resolved (**patch** version release)
- `chore`: Maintenance tasks (**no release**)
- `style`: Code style adjustments (**no release**)
- `test`: Test-related changes (**no release**)

### Examples

```bash
# Feature addition
git commit -m "feat: add support for nested translation keys"

# Bug fix
git commit -m "fix: resolve JSON parsing error for malformed files"

# Breaking change
git commit -m "breaking: remove deprecated translation methods"

# Documentation
git commit -m "docs: update installation instructions"

# Refactoring
git commit -m "refactor: simplify translation compilation logic"
```

## Submitting Pull Requests

### Before Submitting

1. **Rebase on main** to ensure your branch is up to date:

```bash
git checkout main
git pull origin main
git checkout your-feature-branch
git rebase main
```

2. **Run the full test suite**:

```bash
composer test:coverage
composer analyze
```

3. **Ensure 100% test coverage** is maintained
4. **Verify all tests pass**
5. **Check that static analysis passes**

### Pull Request Process

#### ⚠️ Important PR Requirements

- **Target branch**: PRs are ONLY accepted for the `main` branch, not maintenance branches
- **Maintainer approval required**: PRs must have maintainer approval before merging
- **Missing approval**: PRs without maintainer approval will be set to draft

#### Submission Steps

1. **Push your branch** to your fork:

```bash
git push origin your-feature-branch
```

2. **Create a Pull Request** on GitHub targeting the `main` branch with:
   - Clear title describing the change
   - Detailed description of what was changed and why
   - Reference any related issues
   - Confirm that tests pass and coverage is maintained

3. **Wait for maintainer review** and approval
4. **Respond to feedback** and make requested changes
5. **Rebase and force-push** if needed to keep history clean

### Pull Request Requirements

- ✅ All tests must pass
- ✅ 100% test coverage must be maintained
- ✅ Static analysis must pass without errors
- ✅ Branch must be rebased on latest `main`
- ✅ Conventional commit messages must be used
- ✅ Code must follow project standards

## Release Process

Releases are automated using semantic-release based on conventional commits:

- `feat` commits trigger minor releases
- `fix` commits trigger patch releases
- `breaking` commits trigger major releases
- Other commit types may trigger patch releases based on configuration

### ⚠️ Important: Breaking Changes

**Pull requests with `breaking` commit types will be refused or set to draft.** Breaking changes require careful coordination and should only be introduced by maintainers after proper planning and discussion.

## Getting Help

- **Issues**: Report bugs or request features via GitHub Issues
- **Discussions**: Use GitHub Discussions for questions and ideas
- **Security**: Report security vulnerabilities via our [security policy](https://github.com/zenphporg/zorah/security/policy)

## Code of Conduct

Please be respectful and professional in all interactions. We're here to build great software together.

---

Thank you for contributing to Zorah! 🚀
