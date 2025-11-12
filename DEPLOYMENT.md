# DEPLOYMENT GUIDE - NEDMUN-VI

Complete guide for deploying NEDMUN-VI to cPanel with auto-deployment.

## 🚀 Initial Setup (One-time)

### 1. Prepare Your Server

**Via cPanel File Manager:**
1. Login to cPanel
2. Navigate to public_html (or your desired directory)
3. Create folder: `nedmun` (or your preferred name)

**Via SSH (Recommended):**
```bash
ssh username@yourdomain.com
cd public_html
mkdir nedmun
cd nedmun
```

### 2. Initialize Git Repository

```bash
# Initialize Git
git init

# Add remote repository
git remote add origin https://github.com/yourusername/nedmun-vi.git

# Pull the code
git pull origin main
```

### 3. Configure Database

```bash
# Copy template
cp config/database.php.example config/database.php

# Edit with your credentials
nano config/database.php
```

Update:
```php
private $host = 'localhost';        // Usually localhost
private $db_name = 'your_db_name';  // Your cPanel database name
private $username = 'your_db_user'; // Your database username
private $password = 'your_db_pass'; // Your database password
```

### 4. Import Database

**Via phpMyAdmin:**
1. Login to cPanel → phpMyAdmin
2. Create database: `nedmun_vi` (or your chosen name)
3. Select database → Import
4. Choose `database.sql` file
5. Click "Go"

**Via SSH:**
```bash
mysql -u username -p database_name < database.sql
```

### 5. Configure Email (Optional)

```bash
cp config/email.php.example config/email.php
nano config/email.php
```

### 6. Update Configuration

Edit `config/config.php`:
```php
define('BASE_URL', 'https://yourdomain.com/nedmun/');
```

### 7. Set Permissions

```bash
chmod 755 -R .
chmod 644 config/database.php
chmod 644 config/email.php
chmod 755 deploy.php
```

## 🔄 Auto-Deployment Setup

### 1. Configure Deploy Script

Edit `deploy.php`:
```php
define('DEPLOY_SECRET_KEY', 'your-super-secret-random-key-12345');
```

Generate a strong key:
```bash
openssl rand -hex 32
```

### 2. Test Deployment Manually

Visit: `https://yourdomain.com/nedmun/deploy.php?key=your-secret-key`

You should see: "Deployment successful!"

Check logs:
```bash
cat deployment.log
```

### 3. Setup GitHub Webhook

**For GitHub:**
1. Go to repository → Settings → Webhooks
2. Click "Add webhook"
3. Fill in:
   - **Payload URL:** `https://yourdomain.com/nedmun/deploy.php?key=your-secret-key`
   - **Content type:** `application/json`
   - **Which events:** Just the push event
   - **Active:** ✓ Checked
4. Click "Add webhook"

**For GitLab:**
1. Go to repository → Settings → Webhooks
2. Fill in:
   - **URL:** `https://yourdomain.com/nedmun/deploy.php?key=your-secret-key`
   - **Trigger:** Push events
3. Click "Add webhook"

### 4. Test Auto-Deployment

```bash
# Make a small change locally
echo "Test" > test.txt

# Commit and push
git add test.txt
git commit -m "test: Auto-deployment test"
git push origin main

# Wait a few seconds, then check your website
# The test.txt file should appear
```

Check deployment log:
```bash
ssh username@yourdomain.com
cd public_html/nedmun
cat deployment.log
```

## 📋 Daily Workflow

### Making Changes

**Local Development:**
```bash
# Make your changes
git add .
git commit -m "feat: Your feature description"
git push origin main

# Website automatically updates!
```

### Checking Deployment Status

```bash
# SSH into server
ssh username@yourdomain.com
cd public_html/nedmun

# View recent deployments
tail -20 deployment.log

# Pull manually if needed
git pull origin main
```

## 🔧 Troubleshooting

### Issue: Deployment Not Working

**Check 1: Verify Webhook**
- GitHub → Settings → Webhooks → Check recent deliveries
- Should show 200 response

**Check 2: Check Logs**
```bash
cat deployment.log
cat error_log
```

**Check 3: Test Manually**
```bash
cd public_html/nedmun
git pull origin main
```

**Check 4: Permissions**
```bash
ls -la deploy.php
# Should be executable (755)
```

### Issue: 403 Forbidden on deploy.php

**Fix:**
```bash
chmod 755 deploy.php
```

Check `.htaccess` doesn't block it:
```apache
# In .htaccess, ensure deploy.php is accessible
<Files "deploy.php">
    Require all granted
</Files>
```

### Issue: Git Pull Fails

**Possible causes:**
1. File conflicts
2. Permission issues
3. Authentication problems

**Fix:**
```bash
cd public_html/nedmun

# Reset to remote state (CAUTION: Loses local changes)
git fetch origin
git reset --hard origin/main

# Or stash local changes
git stash
git pull origin main
git stash pop
```

### Issue: Database Not Updating

**Remember:** Database changes need manual migration!

```bash
# Export schema locally
mysqldump -u root -p --no-data nedmun_vi > database.sql

# Commit and push
git add database.sql
git commit -m "chore: Update database schema"
git push origin main

# On server, import manually
mysql -u username -p database_name < database.sql
```

## 🔒 Security Checklist

- [ ] `.gitignore` excludes sensitive files
- [ ] `database.php` not in Git repository
- [ ] `email.php` not in Git repository
- [ ] Deploy secret key is strong and unique
- [ ] Admin password changed from default
- [ ] SSL certificate installed (HTTPS)
- [ ] File permissions are correct (755/644)

## 📊 Monitoring

### Check Deployment History

```bash
# View all deployments
cat deployment.log

# View last 50 lines
tail -50 deployment.log

# Search for failures
grep "failed" deployment.log
```

### Clear Old Logs

```bash
# Backup old log
mv deployment.log deployment.log.backup

# Or clear it
> deployment.log
```

## 🆘 Emergency Rollback

If deployment breaks the site:

```bash
# SSH into server
cd public_html/nedmun

# Find last working commit
git log --oneline

# Rollback to specific commit
git reset --hard COMMIT_HASH

# Example:
git reset --hard abc1234
```

## 📞 Support

**Issues with deployment?**
- Check `deployment.log`
- Check `error_log` 
- Test `deploy.php` manually
- Verify webhook in GitHub/GitLab

**Need help?**
- Tech Partner: [TE Links](https://telinks.org)

---

**Remember:** 
- Always test changes locally first
- Database changes need manual migration
- Keep deployment logs for troubleshooting
- Regular backups are essential!

**NEDMUN-VI** | Powered by TE Links
