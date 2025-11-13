# Setup Notes - Bitcoin Poker Dice

## What was fixed to make this run

This legacy PHP/AngularJS app (originally built ~2014) has been modernized to run on Docker with PHP 7.4.

### PHP 7.4 Compatibility Fixes

1. **system/core/Common.php** - Removed deprecated reference assignment (`=&`)
2. **application/models/user_model.php** - Added safe null-checking for Bitcoin address parsing
3. **application/libraries/includes/xmlrpc.inc** - Converted PHP 4-style constructors to `__construct()`
   - `xmlrpc_client`, `xmlrpcresp`, `xmlrpcmsg`, `xmlrpcval`
4. **application/libraries/includes/jsonrpc.inc** - Converted `jsonrpcmsg` constructor
5. **index.php** - Suppressed `E_DEPRECATED` and `E_STRICT` warnings

### Dependency Management

- **Removed Bower** - Old package manager replaced with CDN links
- **CDN Assets** - All third-party libraries now load from reliable CDNs:
  - Bootstrap 3.4.1
  - Font Awesome 4.7.0  
  - AngularJS 1.2.32 + modules
  - jQuery 2.1.4
  - Various Angular plugins (ng-table, ngprogress, angular-block-ui, etc.)

### Configuration

- **Environment Variables** - All hardcoded credentials moved to `.env`
- **Database** - MySQL 5.7 with automatic schema import from `docker/mysql/init/bitzee.sql`
- **Demo Mode** - Enabled by default (`GAME_DEMO_MODE=true`) to prevent real Bitcoin transactions

### Known Issues

1. **Fonts** - Font-Awesome and Bootstrap Glyphicons load from CDN, so local `/dist/fonts/` 404s are harmless
2. **Bitcoin Integration** - Bitcoin RPC calls are stubbed in demo mode
3. **Playing Cards CSS** - Simple fallback CSS created at `/assets/css/cards.css`

### Quick Start

```bash
cp env.example .env
docker compose up --build -d
```

Then visit: http://localhost:8080

The app will auto-create a user account with a GUID on first visit.

### Development

- PHP logs: `docker compose logs -f web`
- Restart after code changes: `docker compose restart web`
- Access database: `docker compose exec db mysql -ubitcoin -pbitcoinpassword bitzee`

### Future Improvements

- Migrate from CodeIgniter 2 to 3 or 4
- Update AngularJS 1.2 to modern framework
- Replace deprecated xmlrpc/jsonrpc libraries
- Add proper Bitcoin testnet integration for demo mode



