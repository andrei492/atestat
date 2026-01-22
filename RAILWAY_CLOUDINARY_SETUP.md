# 🚀 Railway Deployment - Cloudinary Setup Guide

## Current Issue
Getting **500 server error** when uploading images because Cloudinary is not configured.

## ✅ Solution: Set up Cloudinary (Free Forever Plan)

### Step 1: Create Cloudinary Account (2 minutes)

1. Go to: **https://cloudinary.com/users/register_free**
2. Sign up with email (free forever plan)
3. After login, you'll see your **Dashboard**
4. Find the **API Environment variable** section - it looks like:
   ```
   CLOUDINARY_URL=cloudinary://123456789012345:abcdefghijklmnopqrst@your-cloud-name
   ```
5. **Copy this entire URL** (you'll need it in the next step)

### Step 2: Add to Railway Environment Variables (1 minute)

1. Go to your Railway project: **https://railway.app**
2. Select your project: `atestat-production`
3. Click on your **Laravel service**
4. Go to **"Variables"** tab
5. Click **"+ New Variable"**
6. Add:
   - **Variable Name**: `CLOUDINARY_URL`
   - **Value**: Paste the URL from Cloudinary dashboard
   - Example: `cloudinary://123456789012345:abcdefghijklmnopqrst@your-cloud-name`
7. Click **"Add"**
8. Railway will **automatically redeploy** your app

### Step 3: Verify Deployment (2 minutes)

1. Wait for Railway to finish redeploying (check the deployment logs)
2. Once deployed, visit your Railway app URL
3. Try uploading a profile photo or creating a post with an image
4. It should now work! ✅

## Why This Fixes the 500 Error

- **Before**: Your code tries to upload to Cloudinary but no credentials are configured
- **After**: Cloudinary credentials are set, uploads work to cloud storage
- **Benefit**: Images are stored on Cloudinary (persistent), not Railway (ephemeral)

## Local Development (Optional)

If you want to test uploads locally:

1. Open `.env` file in your project
2. Add the same `CLOUDINARY_URL` from Cloudinary dashboard:
   ```
   CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
   ```
3. Save and restart your local server

## Free Tier Limits (Cloudinary)

✅ **25 GB storage**
✅ **25 GB bandwidth/month**
✅ **Unlimited transformations**
✅ Perfect for your app!

## Additional Notes

- The migration for `shared_post_id` will run automatically on Railway
- Images uploaded to Cloudinary are **permanent** (won't be deleted on redeployments)
- Old images in local storage won't work on Railway (ephemeral file system)
- All new uploads will go directly to Cloudinary

## Need Help?

If you still see errors after adding CLOUDINARY_URL:
1. Check Railway deployment logs for specific error messages
2. Verify the CLOUDINARY_URL was copied correctly (no extra spaces)
3. Make sure the variable is added to the correct service in Railway
