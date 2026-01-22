#!/bin/bash

# Install npm dependencies and build
npm install
npm run build

# Run Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
