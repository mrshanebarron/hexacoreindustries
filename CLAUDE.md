# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP-based website for Hexacore Industries, an industrial fasteners and supplies company. The site uses a simple PHP structure with Tailwind CSS for styling and Alpine.js for interactive components.

## Architecture

- **Main entry point**: `index.php` - Contains the homepage with video background, navigation, and company information
- **Menu system**: `menu.php` - Large multi-level navigation menu (1355 lines) containing the product catalog structure
- **Static assets**:
  - `HexacoreIndustriesCatalog.pdf` - Main product catalog (47MB)
  - `videos/` - Background videos for homepage (MP4/MOV/OGG formats with Git LFS)
  - Various image assets (logo.webp, background.webp, business cards)
- **Development tools**:
  - `walter/` - Development directory with duplicate files and scraping tools
  - `walter/scrape/fasteners/` - Scrapy project for product data extraction

## Key Features

- Video background rotation system with 5-second intervals
- Multi-level dropdown navigation menu
- PDF viewer modal for catalog viewing
- Responsive design using Tailwind CSS
- Alpine.js for UI interactions

## Development Commands

Since this is a PHP project without a build system:

- **Run locally**: Use a PHP development server or a tool like Laravel Herd
- **No build/compilation needed** - Direct PHP execution
- **No tests configured** - Static PHP site without test framework
- **Video format conversion**: `videos/format.sh` - Script to ensure all videos have .mov, .mp4, and .ogg versions
- **Web scraping**: `cd walter/scrape/fasteners && scrapy crawl products` - Extract product data using Scrapy

## Important Notes

- The menu.php file is extremely large (1355 lines) and contains the entire product hierarchy
- All product links currently point to the same PDF catalog
- Video files are configured with Git LFS (.gitattributes present) in multiple formats for browser compatibility
- Site uses CDN versions of Tailwind CSS and Alpine.js (no local dependencies)
- The `walter/` directory appears to be a development/staging area with duplicate files and experimental features