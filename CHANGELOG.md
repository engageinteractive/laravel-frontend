# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased
### Changes
- Updates to Laravel 5.5+

## 3.0.0 - 2018-12-02
### Changes
- Allow echo route to support GET methods by moving it into it's path (/frontend/echo)

## 2.1.2 - 2018-11-22
### Fixes
- Fixes typos in README.md

## 2.1.1 - 2018-11-22
### Fixes
- Fixes documentation for the PageDefaultsViewComposer.

## 2.1.0 - 2018-11-22
### Added
- `PageDefaultsViewComposer` to support page defaults in both frontend and non-frontend template.
### Changed
- 'index_template_path' in config now used the dot syntax preferred by Laravel.

## 2.0.0 - 2018-09-13
### Changed
- Exacted `ConfigProvider` logic out into the `engageinteractive/laravel-config-provider` package.
- Namespace is now `EngageInteractive` rather than `Engage` to better reflect our Github and Packagist account name.
