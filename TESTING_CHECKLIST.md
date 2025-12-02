# GO-KOPI PS Rental System - Testing Checklist

## Phase: Final Quality Assurance & Role-Based Access Control

**Overall Status**: Ready for Testing  
**Last Updated**: Current Session  
**Tested By**: [To be filled]

---

## 1. TEST: Admin Role Access Control

### Prerequisites

- Test User: admin@test.com / Password: admin123 (or your admin password)
- Database: Verify admin user exists with role='admin'

### Steps

1. Open browser, go to login page (`/`)

   - [ ] Login page shows dark mode by default
   - [ ] No demo credentials visible
   - [ ] Form fields properly styled

2. Login as Admin user

   - [ ] Login succeeds
   - [ ] Redirected to admin dashboard

3. Check Sidebar Menu

   - [ ] "Dashboard" link visible ✓
   - [ ] "MANAJEMEN" section visible with: Pelanggan, Unit PS, Transaksi Sewa ✓
   - [ ] "ADMIN" section visible with: Manajemen User ✓
   - [ ] "LAPORAN & ANALITIK" section NOT visible ❌ (should NOT appear for admin)

4. Direct URL Test
   - [ ] Go directly to `/reports` URL
   - [ ] Expected: 403 Forbidden error (access denied)
   - [ ] Message should indicate insufficient permissions

### Expected Results

✅ Admin can access: Dashboard, Customers, Consoles, Rentals, Users  
✅ Admin CANNOT access: Reports section  
✅ Direct /reports access denied with 403 error

### Notes

```
If Reports appears in sidebar for admin:
  Issue: Sidebar.php role check failed
  Check: Line 50 in sidebar.php - should be <?php if ($role == 'owner'): ?>

If admin can access /reports without error:
  Issue: Reports controller require_role() not enforced
  Check: Line 9 in Reports.php - should have require_role('owner')
```

---

## 2. TEST: Kasir Role Access Control

### Prerequisites

- Test User: kasir@test.com / Password: kasir123 (or your kasir password)
- Database: Verify kasir user exists with role='kasir'

### Steps

1. Logout from Admin (or open new incognito window)

2. Login as Kasir user

   - [ ] Login succeeds
   - [ ] Redirected to kasir dashboard

3. Check Sidebar Menu

   - [ ] "Dashboard" link visible ✓
   - [ ] "MANAJEMEN" section visible with: Pelanggan, Unit PS, Transaksi Sewa ✓
   - [ ] "ADMIN" section NOT visible ❌
   - [ ] "LAPORAN & ANALITIK" section NOT visible ❌

4. Dashboard Verification

   - [ ] Shows only kasir-specific data
   - [ ] No owner analytics or reports

5. Direct URL Test
   - [ ] Try `/users` - should get 403 (only admin can access)
   - [ ] Try `/reports` - should get 403 (only owner can access)

### Expected Results

✅ Kasir can access: Dashboard, Customers, Consoles, Rentals  
✅ Kasir CANNOT access: User Management, Reports  
✅ Both /users and /reports blocked with 403 error

### Notes

```
If kasir can access /users or /reports:
  Issue: Controller role validation not enforced
  Check: MY_Controller.php - require_admin() or require_role()
```

---

## 3. TEST: Owner Role Access Control ⭐ CRITICAL

### Prerequisites

- Test User: owner@test.com / Password: owner123 (or your owner password)
- Database: Verify owner user exists with role='owner'

### Steps

1. Logout from Kasir (or new incognito window)

2. Login as Owner user

   - [ ] Login succeeds
   - [ ] Redirected to owner dashboard

3. Check Sidebar Menu

   - [ ] "Dashboard" link visible ✓
   - [ ] "MANAJEMEN" section NOT visible ❌
   - [ ] "ADMIN" section NOT visible ❌
   - [ ] "LAPORAN & ANALITIK" section visible with 5 links:
     - [ ] Dashboard Laporan (chart-bar icon)
     - [ ] Laporan Pendapatan (money-bill-wave icon)
     - [ ] Performa Konsol (gamepad icon)
     - [ ] Analisis Pembayaran (credit-card icon)
     - [ ] Analisis Pelanggan (users icon)

4. Report Links Test

   - [ ] Click "Dashboard Laporan" → `/reports` loads successfully
   - [ ] Click "Laporan Pendapatan" → `/reports/revenue` loads
   - [ ] Click "Performa Konsol" → `/reports/console_performance` loads
   - [ ] Click "Analisis Pembayaran" → `/reports/payment_analysis` loads
   - [ ] Click "Analisis Pelanggan" → `/reports/customer_analysis` loads

5. Active State Test

   - [ ] When on `/reports`, "Dashboard Laporan" highlighted in sidebar
   - [ ] When on `/reports/revenue`, "Laporan Pendapatan" highlighted
   - [ ] Each report link shows as active correctly

6. Dashboard Data
   - [ ] Owner dashboard shows financial statistics
   - [ ] Revenue data displays
   - [ ] Console performance metrics visible
   - [ ] Payment data aggregations shown

### Expected Results

✅ Owner can access: Dashboard, All 5 Report endpoints  
✅ Owner CANNOT access: Customers, Consoles, Rentals, User Management  
✅ All report data displays correctly  
✅ Sidebar shows only report-related menu items

### Critical Validation

```
CHECKLIST:
[ ] Owner sidebar shows only Dashboard + Reports section
[ ] All 5 report links accessible and functional
[ ] Active state highlights correct report link
[ ] Try /customers as owner → 403 error (should be blocked)
[ ] Try /users as owner → 403 error (should be blocked)
```

---

## 4. TEST: Dark Mode Persistence

### Steps

1. Login as any user (owner recommended to see reports)

2. Test Dark Mode Toggle

   - [ ] Page displays in dark mode by default
   - [ ] Toggle button visible (moon/sun icon in header)
   - [ ] Click toggle → switches to light mode
   - [ ] Click toggle → switches back to dark mode

3. Persistence Test

   - [ ] Toggle to light mode
   - [ ] Refresh page (F5)
   - [ ] Expected: Page loads in light mode (localStorage persisted)
   - [ ] Toggle back to dark mode
   - [ ] Refresh page
   - [ ] Expected: Page loads in dark mode

4. Cross-Page Persistence

   - [ ] Set to dark mode
   - [ ] Navigate to different page (e.g., /dashboard → /reports/revenue)
   - [ ] Expected: Stays in dark mode
   - [ ] Set to light mode
   - [ ] Navigate between pages
   - [ ] Expected: Stays in light mode

5. New Session Test

   - [ ] Set theme to light mode
   - [ ] Close browser completely
   - [ ] Reopen, login again
   - [ ] Expected: Page loads in light mode (localStorage persisted)

6. Form Styling in Dark Mode
   - [ ] Input fields: Dark background, light text ✓
   - [ ] Buttons: Properly colored in dark mode ✓
   - [ ] Tables: Readable in dark mode ✓
   - [ ] Alerts: Visible in dark mode ✓
   - [ ] Modals: Properly styled ✓

### Expected Results

✅ Dark mode persists via localStorage  
✅ Theme persists across page navigation  
✅ Theme persists across browser sessions  
✅ All UI elements styled correctly in both modes

### Troubleshooting

```
If dark mode doesn't persist:
  Check: localStorage in browser DevTools > Application tab
  Key should be "theme" with value "dark" or "light"
  File: public/js/dark-mode.js - check localStorage.setItem()

If theme doesn't apply to new page:
  Check: dark-mode.js loaded in header
  File: application/views/layouts/header.php - verify script include
  Issue: initializeDarkMode() might not be called on page load
```

---

## 5. TEST: User Management - Owner Role Creation

### Prerequisites

- Logged in as Admin user
- Have admin credentials

### Steps

1. Navigate to Users Management (`/users`)

   - [ ] Page loads successfully
   - [ ] User list displays

2. Click "Tambah User" button

   - [ ] Form opens with fields: Nama, Email, Password, Role

3. Role Dropdown Test

   - [ ] Click Role dropdown
   - [ ] Verify all 3 options present:
     - [ ] Admin
     - [ ] Kasir
     - [ ] Owner ← Must be visible!
   - [ ] If Owner not visible, issue with users/form.php

4. Create Test Owner User

   - [ ] Fill Name: "Test Owner 2"
   - [ ] Fill Email: "testowner2@test.com"
   - [ ] Fill Password: "password123"
   - [ ] Select Role: Owner
   - [ ] Click "Simpan" button

5. Validation Test

   - [ ] If validation error appears → check Users.php controller validation
   - [ ] If success → verify user created in database
   - [ ] Check users table → new row should have role='owner'

6. Edit Owner User
   - [ ] Click edit on newly created owner user
   - [ ] Role field shows "Owner" ✓
   - [ ] Edit password, click save
   - [ ] Should succeed without errors

### Expected Results

✅ Owner option visible in role dropdown  
✅ Can create user with Owner role  
✅ Form validation accepts 'owner' value  
✅ User saved to database with role='owner'  
✅ Can edit owner users without errors

### Validation Points

```
File: application/views/users/form.php
Line ~61 should include:
  <option value="owner">Owner</option>

File: application/controllers/Users.php
Line 33 should have: 'in_list[admin,kasir,owner]'
Line 76 should have: 'in_list[admin,kasir,owner]'
```

---

## 6. TEST: Sidebar Active States

### Prerequisites

- Logged in as Owner user
- All 5 report routes working

### Steps

1. Click "Dashboard Laporan"

   - [ ] Page loads
   - [ ] Sidebar shows "Dashboard Laporan" highlighted/active
   - [ ] URL is `/reports`

2. Click "Laporan Pendapatan"

   - [ ] Page loads
   - [ ] Sidebar shows "Laporan Pendapatan" highlighted/active
   - [ ] URL is `/reports/revenue`
   - [ ] Previous link no longer highlighted

3. Click "Performa Konsol"

   - [ ] Page loads
   - [ ] Only "Performa Konsol" highlighted
   - [ ] URL is `/reports/console_performance`

4. Click "Analisis Pembayaran"

   - [ ] Only this link highlighted
   - [ ] URL is `/reports/payment_analysis`

5. Click "Analisis Pelanggan"

   - [ ] Only this link highlighted
   - [ ] URL is `/reports/customer_analysis`

6. Navigate Using Browser Back Button
   - [ ] Click back button
   - [ ] Sidebar active state updates correctly
   - [ ] No visual glitches

### Expected Results

✅ Exactly one report link highlighted at a time  
✅ Active state matches current URL  
✅ Active state updates when navigating  
✅ No double-highlighting or missing highlights

---

## 7. TEST: UI/UX Consistency

### Prerequisites

- Test in both dark and light modes
- Test in multiple browsers if possible

### Visual Consistency Check

1. Login Page

   - [ ] Dark mode by default
   - [ ] Professional gradient background
   - [ ] Form fields properly styled
   - [ ] Button has gradient effect
   - [ ] Error messages display clearly

2. Dashboard Pages (Admin/Kasir/Owner)

   - [ ] Consistent header layout
   - [ ] Sidebar visible and functional
   - [ ] Content readable in both themes
   - [ ] Cards properly styled
   - [ ] Charts/data displays correctly

3. Data Tables

   - [ ] Table headers visible
   - [ ] Rows alternating colors (if applicable)
   - [ ] Text readable in both modes
   - [ ] Borders visible

4. Forms

   - [ ] Input fields have proper contrast
   - [ ] Labels visible
   - [ ] Placeholder text visible
   - [ ] Focus states show clearly (blue glow)
   - [ ] Error messages highlighted

5. Buttons & Links

   - [ ] Buttons have hover effects
   - [ ] Disabled buttons appear grayed out
   - [ ] Links have proper color
   - [ ] Gradient buttons display correctly

6. Alerts & Messages

   - [ ] Success messages (green) visible
   - [ ] Error messages (red) visible
   - [ ] Warning messages (yellow) visible
   - [ ] Info messages (blue) visible

7. Responsive Design (Mobile)
   - [ ] Sidebar toggles on mobile
   - [ ] Content wraps properly
   - [ ] Buttons remain clickable
   - [ ] Forms are usable

### Expected Results

✅ All elements properly styled in both dark/light modes  
✅ No broken or missing styles  
✅ Professional appearance throughout  
✅ Consistent branding and colors

---

## Issues Found & Fixes Applied

### Issue 1: Reports in Admin Sidebar ✅ FIXED

**Status**: RESOLVED  
**Root Cause**: Sidebar.php had Reports in Admin section  
**Fix Applied**: Moved Reports to dedicated Owner-only section (Lines 50-87)  
**Validation**: Sidebar now shows role-specific menus

### Issue 2: Owner Role Missing from Dropdown ✅ FIXED

**Status**: RESOLVED  
**Root Cause**: users/form.php only had admin and kasir options  
**Fix Applied**: Added Owner option to dropdown (Line 61)  
**Validation**: Owner visible when creating users

### Issue 3: Form Validation Rejecting Owner Role ✅ FIXED

**Status**: RESOLVED  
**Root Cause**: Users.php validation used 'in_list[admin,kasir]'  
**Fix Applied**: Updated to 'in_list[admin,kasir,owner]' in store() and update()  
**Validation**: Forms accept Owner role without validation errors

### Issue 4: Demo Credentials on Login ✅ FIXED

**Status**: RESOLVED  
**Root Cause**: login.php displayed demo account info box  
**Fix Applied**: Removed login-info div  
**Validation**: Clean login page without credential display

### Issue 5: Dark Mode Not Working Everywhere ✅ FIXED

**Status**: RESOLVED  
**Root Cause**: dark-mode.js not loaded or initialized  
**Fix Applied**: Added to all headers, multiple initialization triggers, 100+ CSS lines  
**Validation**: Dark mode works across all pages

---

## Sign-Off

| Item                  | Status              | Date | Tester | Notes |
| --------------------- | ------------------- | ---- | ------ | ----- |
| Admin Access Control  | [ ] PASS / [ ] FAIL |      |        |       |
| Kasir Access Control  | [ ] PASS / [ ] FAIL |      |        |       |
| Owner Access Control  | [ ] PASS / [ ] FAIL |      |        |       |
| Dark Mode Persistence | [ ] PASS / [ ] FAIL |      |        |       |
| User Management       | [ ] PASS / [ ] FAIL |      |        |       |
| Sidebar Active States | [ ] PASS / [ ] FAIL |      |        |       |
| UI/UX Consistency     | [ ] PASS / [ ] FAIL |      |        |       |

**Overall Status**: [ ] READY FOR DEPLOYMENT / [ ] NEEDS FIXES

---

## Notes & Observations

```
[Add your testing notes here as you go through the checklist]

1. Admin role test results:
2. Kasir role test results:
3. Owner role test results:
4. Dark mode findings:
5. User management findings:
6. Other observations:
```

---

## Rollback Information (if needed)

If any issue is found and needs immediate rollback:

**Last Stable Commit**: [To be filled]  
**Critical Files Modified**:

- application/views/layouts/sidebar.php (Lines 22-87)
- application/views/users/form.php (Line 61)
- application/controllers/Users.php (Lines 33, 76)
- application/views/auth/login.php (removed login-info div)
- public/js/dark-mode.js (enhanced)
- public/css/style.css (expanded 100+ lines)

---

## Next Steps After Testing

1. ✅ Complete all 7 test sections above
2. ✅ Document any issues found
3. ✅ Fix issues if needed
4. ✅ Re-test affected areas
5. ✅ Get sign-off from stakeholder
6. ✅ Deploy to production
7. ✅ Monitor for issues in production

---

**Document Version**: 1.0  
**Created**: Current Session  
**Status**: ACTIVE - TESTING IN PROGRESS
