# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2025-01-XX

### Improved
- Enhanced documentation in README.md with clearer examples and explanations
- Improved `HasLocalizedRoutes` trait with better auto-detection capabilities
- Clarified that the trait is optional and not required for basic functionality
- Updated documentation to emphasize middleware-based approach as primary method

### Documentation
- Added comprehensive examples for using models with short links
- Clarified that middleware handles everything automatically
- Improved explanation of automatic route detection
- Added more detailed usage examples

## [1.0.1] - 2025-01-XX

### Improved
- Enhanced documentation in README.md with clearer examples and explanations
- Improved `HasLocalizedRoutes` trait with better auto-detection capabilities
- Clarified that the trait is optional and not required for basic functionality
- Updated documentation to emphasize middleware-based approach as primary method
- Better explanation of how middleware automatically works on all routes

### Documentation
- Added comprehensive examples showing middleware-based approach is the main method
- Clarified that model modification is not required - everything works through routes and middleware
- Improved explanation of automatic route detection
- Added more detailed usage examples for better understanding

## [1.0.0] - 2024-01-XX

### Added
- Initial release of Laravel Multilingual package
- Support for unlimited languages with comprehensive language list (60+ languages)
- Flexible locale hiding/showing in URLs (hide any locale, not just default)
- Automatic locale detection from URL, session, cookie, or browser
- Smart caching system for improved performance
- Route macros for easy localized route registration
- Blade component for language switcher
- Helper functions for URL localization
- RTL language support
- Middleware for automatic locale handling
- Comprehensive configuration options
- Auto-population of locale names and flags from available locales
- Console command for cache clearing
- Support for Laravel 9, 10, 11, and 12

### Features
- High-performance URL generation with caching
- Minimal middleware overhead
- Clean URL structure with optional locale hiding
- Session and cookie-based locale persistence
- Browser language detection
- Route exclusion support
- Full backward compatibility

### Configuration
- `supported_locales`: Choose which languages to support
- `hidden_locales`: Control which locales to hide from URL
- `available_locales`: Comprehensive list of 60+ languages with names and flags
- Flexible configuration via config file or .env

