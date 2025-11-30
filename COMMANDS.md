# LaraPDFX Command Line Help

## Available Commands

### Install Command

```bash
php artisan larapdfx:install [--force]
```

**Description:** Install and configure LaraPDFX package

**Options:**
- `--force` - Overwrite existing configuration file

**What it does:**
1. Publishes configuration file to `config/larapdfx.php`
2. Checks for Chrome/Chromium installation
3. Provides installation instructions if Chrome not found
4. Shows next steps and configuration tips

**Example:**
```bash
# Normal installation
php artisan larapdfx:install

# Force overwrite config
php artisan larapdfx:install --force
```

---

### Test Command

```bash
php artisan larapdfx:test [--output=PATH]
```

**Description:** Test LaraPDFX installation by generating a sample PDF

**Options:**
- `--output=PATH` - Custom output file path (default: storage/app/test.pdf)

**What it does:**
1. Generates a test PDF with modern CSS features
2. Tests Chrome integration
3. Verifies all features work correctly
4. Shows file size and location

**Example:**
```bash
# Generate test PDF at default location
php artisan larapdfx:test

# Generate at custom location
php artisan larapdfx:test --output=storage/app/custom-test.pdf
```

---

## Getting Help

### Show Command Help

```bash
# Show install command help
php artisan help larapdfx:install

# Show test command help
php artisan help larapdfx:test

# List all Laravel Artisan commands
php artisan list
```

---

## Configuration

### Publish Configuration

```bash
# Publish only config
php artisan vendor:publish --provider="Deecodek\LaraPDFX\LaraPDFXServiceProvider" --tag="larapdfx-config"

# Force overwrite
php artisan vendor:publish --provider="Deecodek\LaraPDFX\LaraPDFXServiceProvider" --tag="larapdfx-config" --force
```

### Configuration File

Located at: `config/larapdfx.php`

**Available Options:**

```php
'paper' => [
    'format' => 'A4',           // Default paper format
    'margins' => [
        'top' => 10,            // Top margin (mm)
        'right' => 10,          // Right margin (mm)
        'bottom' => 10,         // Bottom margin (mm)
        'left' => 10,           // Left margin (mm)
    ],
],

'chrome_path' => null,          // Path to Chrome binary (null = auto)
'node_binary' => null,          // Path to Node.js (null = auto)
'npm_binary' => null,           // Path to NPM (null = auto)
'timeout' => 60,                // Timeout in seconds
'print_background' => true,     // Print background colors/images
'output_directory' => 'pdfs',   // Default output directory

'queue' => [
    'enabled' => false,         // Enable queue processing
    'connection' => null,       // Queue connection
    'queue' => 'default',       // Queue name
],
```

---

## Environment Variables

You can override config values using `.env`:

```env
LARAPDFX_PAPER_FORMAT=A4
LARAPDFX_MARGIN_TOP=10
LARAPDFX_MARGIN_RIGHT=10
LARAPDFX_MARGIN_BOTTOM=10
LARAPDFX_MARGIN_LEFT=10
LARAPDFX_CHROME_PATH=/usr/bin/chromium-browser
LARAPDFX_NODE_BINARY=/usr/bin/node
LARAPDFX_NPM_BINARY=/usr/bin/npm
LARAPDFX_TIMEOUT=60
LARAPDFX_PRINT_BACKGROUND=true
LARAPDFX_OUTPUT_DIR=pdfs
LARAPDFX_QUEUE_ENABLED=false
LARAPDFX_QUEUE_CONNECTION=redis
LARAPDFX_QUEUE_NAME=default
```

---

## Common Commands Workflow

### Initial Setup

```bash
# 1. Install package
composer require deecodek/larapdfx

# 2. Run installation
php artisan larapdfx:install

# 3. Test installation
php artisan larapdfx:test

# 4. Customize config (optional)
php artisan vendor:publish --provider="Deecodek\LaraPDFX\LaraPDFXServiceProvider" --tag="larapdfx-config"
```

### Update Package

```bash
# Update to latest version
composer update deecodek/larapdfx

# Re-publish config if needed
php artisan vendor:publish --provider="Deecodek\LaraPDFX\LaraPDFXServiceProvider" --tag="larapdfx-config" --force
```

### Troubleshooting

```bash
# Clear all Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Test installation
php artisan larapdfx:test

# Check Chrome installation
which chromium-browser  # Linux
which google-chrome     # macOS
```

---

## Docker Commands

### In Dockerfile

```dockerfile
# Install Chromium
RUN apt-get update && apt-get install -y chromium-browser

# Or for Alpine
RUN apk add --no-cache chromium
```

### Docker Compose

```yaml
services:
  app:
    build: .
    environment:
      LARAPDFX_CHROME_PATH: /usr/bin/chromium-browser
      LARAPDFX_TIMEOUT: 120
```

---

## Production Deployment

### Check Requirements

```bash
# Verify Chrome is installed
chromium-browser --version

# Or
google-chrome --version

# Verify Node.js (if needed)
node --version
npm --version
```

### Optimize for Production

```bash
# Optimize composer autoloader
composer install --optimize-autoloader --no-dev

# Cache Laravel config
php artisan config:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

---

## Getting Help

### Command Help

```bash
php artisan larapdfx:install --help
php artisan larapdfx:test --help
```

### Documentation

- **Full Docs:** [README.md](README.md)
- **Quick Start:** [QUICK_START.md](QUICK_START.md)
- **Examples:** [examples/](examples/)
- **Installation:** [INSTALLATION.md](INSTALLATION.md)

### Support

- **GitHub Issues:** https://github.com/deecodek/larapdfx/issues
- **Discussions:** https://github.com/deecodek/larapdfx/discussions

---

**For more information, visit:** https://github.com/deecodek/larapdfx
